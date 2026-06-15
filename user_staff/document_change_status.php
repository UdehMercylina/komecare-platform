<?php
	include 'includes/session.php';

	if(isset($_POST['update_status'])){
		$id = $_POST['id'];
		$status = $_POST['status'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM documents WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		$now = date('Y-m-d h:i A');

		//get the current details of the document
		$get_stmt = $conn->prepare("SELECT *, documents.id AS fileid FROM documents LEFT JOIN documents_list ON documents.file_id = documents_list.id LEFT JOIN users ON documents.user_id = users.id WHERE documents.id=:id LIMIT 1");
	    $get_stmt->execute(['id'=>$id]);
	    $curr_det = $get_stmt->fetch(PDO::FETCH_ASSOC);

	    if ($curr_det["file_status"] == $status) {
	    	$_SESSION['error'] = 'The file status is already set to this already';
	    	header('Location: '.$_SERVER['HTTP_REFERER']);
			exit;
	    }

	    //if the status is requested
		if ($status == "requested") {
			try{
				$stmt = $conn->prepare("UPDATE documents SET soft_delete=1 WHERE id=:id");
				$stmt->execute(['id'=>$id]);

				$crt_stmt = $conn->prepare("INSERT INTO documents (user_id, file_id, date_requested, file_status) VALUES (:user_id, :file_id, :date_requested, :file_status)");
    			$crt_stmt->execute(['user_id'=>$curr_det["user_id"], 'file_id'=>$curr_det["file_id"], 'date_requested'=>$now, 'file_status'=>$status]);

    			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Requested '.$curr_det["document_name"].' document from '.$curr_det["full_name"], 'category'=>'Audit', 'date_sent'=>$now]);

				$_SESSION['success'] = 'Document status updated successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

	    //if the status is submitted
		if ($status == "submitted") {
			try{
				$stmt = $conn->prepare("UPDATE documents SET file_status=:status, date_submitted=:date_submitted WHERE id=:id");
				$stmt->execute(['status'=>$status, 'date_submitted'=>$now, 'id'=>$id]);

    			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Changed '.$curr_det["full_name"].' '.$curr_det["document_name"].' document status from '.$curr_det["file_status"].' to '.$status, 'category'=>'Audit', 'date_sent'=>$now]);

				$_SESSION['success'] = 'Document status updated successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

	    //if the status is approved
		if ($status == "approved") {
			try{
				$stmt = $conn->prepare("UPDATE documents SET file_status=:status, date_approved=:date_approved WHERE id=:id");
				$stmt->execute(['status'=>$status, 'date_approved'=>$now, 'id'=>$id]);

    			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Approved '.$curr_det["full_name"].' '.$curr_det["document_name"].' document', 'category'=>'Audit', 'date_sent'=>$now]);

				$_SESSION['success'] = 'Document status updated successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select document status first';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>