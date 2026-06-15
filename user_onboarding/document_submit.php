<?php
	include 'inc/session.php';
	include '../admin/includes/slugify.php';

	$user_id = $_SESSION['onboardee'];

	if(isset($_POST['submit_file'])){
		$id = $_POST['id'];
		$doc_name = $_POST['doc_name'];
		$date_issued = $_POST['date_issued'];
		$date_expiring = $_POST['date_expiring'];
		$file_name = $_FILES['file_name']['name'];

		$conn = $pdo->open();

		$date_view = date('Y-m-d');

		$now = date('Y-m-d h:i A');

		if(!empty($file_name)){
			move_uploaded_file($_FILES['file_name']['tmp_name'], '../admin/uploads/'.$file_name);
			$filename = $file_name;	
		}
		else{
			$_SESSION['error'] = 'You need to select a file';
			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}

		try{

			$stmt = $conn->prepare("UPDATE documents SET date_submitted=:date_submitted, date_expiring=:date_expiring, date_issued=:date_issued, file_status=:file_status, file_name=:file_name WHERE id=:id");
			$stmt->execute(['date_submitted'=>$now, 'date_expiring'=>$date_expiring, 'date_issued'=>$date_issued, 'file_status'=>'submitted', 'file_name'=>$filename, 'id'=>$id]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :start_date)");
			$activity->execute(['user_id'=>$user_id, 'message'=>'Submitted '.$doc_name.' document with id:'.$id.' for review', 'category'=>'Audit', 'start_date'=>$now]);

			$_SESSION['success'] = 'File subbmitted successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'You are not doing something right';
	}

	header('Location: documents_requested');
	exit;
?>