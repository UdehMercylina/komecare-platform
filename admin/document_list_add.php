
<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];

		$conn = $pdo->open();

		$now = date('Y-m-d h:i A');

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM documents_list WHERE document_name=:name");
		$stmt->execute(['name'=>$name]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Document already exist';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO documents_list (document_name, created_by) VALUES (:name, :created_by)");
				$stmt->execute(['name'=>$name, 'created_by'=>$admin["id"]]);

				$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Created a '.$name.' document', 'category'=>'Audit', 'date_sent'=>$now]);

				$_SESSION['success'] = 'Document added successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up document creation form first';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>