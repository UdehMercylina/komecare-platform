<?php
	include 'includes/session.php';

	if(isset($_POST['update_status'])){
		$id = $_POST['id'];
		$status = $_POST['status'];
		$reason = $_POST['reason'];

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

				$crt_stmt = $conn->prepare("INSERT INTO documents (user_id, file_id, date_requested, file_status, comment) VALUES (:user_id, :file_id, :date_requested, :file_status, :reason)");
    			$crt_stmt->execute(['user_id'=>$curr_det["user_id"], 'file_id'=>$curr_det["file_id"], 'date_requested'=>$now, 'file_status'=>$status, 'reason'=>$reason]);

    			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Requested '.$curr_det["document_name"].' document from '.$curr_det["full_name"], 'category'=>'Audit', 'date_sent'=>$now]);

    			try {
	                $to = $curr_det['email'];
	                $subject = "Komecare Document Request";
	                $message = '
					<html>
						<head>
						<title>Komecare</title>
						</head>
						<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;">
							<div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
							  <h1 style="font-size: 24px; color: #333; margin-bottom: 20px;">KOMECARE</h1>
							  <p style="font-size: 16px; color: #333;">Dear '.$curr_det["full_name"].'</p>
							  <p style="font-size: 16px; color: #333;">You are requested to resubmit '.$curr_det["document_name"].'</p>
							  <p style="font-size: 16px; color: #333;">Please login to resubmit.</p>
							  <p style="font-size: 16px; color: #007bff;"><a href="https://www.komerec.com/" style="color: #007bff; text-decoration: none;">Login</a></p>
							</div>
						</body>
					</html>
					';

	                // Set content-type for KomeCare
	                $headers = 'MIME-Version: 1.0' . "\r\n";
	                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	                // Additional headers
	                $headers .= 'From: ' . getenv('MAIL_FROM_NAME') . ' <' . getenv('MAIL_USERNAME') . '>' . "\r\n";

	                // Send the email
	                mail($to, $subject, $message, $headers);

	                unset($_SESSION['firstname']);
	                unset($_SESSION['lastname']);
	                unset($_SESSION['email']);

	            } 
	            catch (Exception $e) {
	                $_SESSION['success'] = 'Document requested successfully but email not sent.';
	                header('Location: '.$_SERVER['HTTP_REFERER']);
	            }

				$_SESSION['success'] = 'Document requested successfully';

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