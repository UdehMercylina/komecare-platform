<?php
	include 'includes/session.php';

	if(isset($_POST['request'])){
		$id = $_POST['id'];
		$document_id = $_POST['document'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM documents WHERE file_id=:document_id AND user_id=:id AND soft_delete=0");
		$stmt->execute(['id'=>$id, 'document_id'=>$document_id]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
	    	header('Location: '.$_SERVER['HTTP_REFERER']);
			$_SESSION['error'] = 'Document already exist';
			exit;
		}

		$now = date('Y-m-d h:i A');

		//get the current details of the document
		$get_stmt = $conn->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
	    $get_stmt->execute(['id'=>$id]);
	    $curr_det = $get_stmt->fetch(PDO::FETCH_ASSOC);

	    //get the details of the document
		$doc_stmt = $conn->prepare("SELECT * FROM documents LEFT JOIN documents_list ON documents.file_id = documents_list.id WHERE documents.file_id=:id LIMIT 1");
	    $doc_stmt->execute(['id'=>$document_id]);
	    $doc_det = $doc_stmt->fetch(PDO::FETCH_ASSOC);

	    //if the status is requested
		if ($document_id !== "") {
			try{
				$crt_stmt = $conn->prepare("INSERT INTO documents (user_id, file_id, date_requested, file_status) VALUES (:user_id, :file_id, :date_requested, :file_status)");
    			$crt_stmt->execute(['user_id'=>$id, 'file_id'=>$document_id, 'date_requested'=>$now, 'file_status'=>"requested"]);

    			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Requested '.$doc_det["document_name"].' document from '.$curr_det["full_name"], 'category'=>'Audit', 'date_sent'=>$now]);

				$_SESSION['success'] = 'Document requested successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select document to request';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>