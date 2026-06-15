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

    			try {
	                $to = $email;
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
							  <p style="font-size: 16px; color: #333;">You are requested to submit '.$curr_det["document_name"].' document.</p>
							  <p style="font-size: 16px; color: #333;">Please login to submit.</p>
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

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select document to request';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>