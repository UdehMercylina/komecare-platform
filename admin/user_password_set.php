<?php
	include 'includes/session.php';

	if(isset($_POST['set_password'])){
		$id = $_POST['id'];
		$password = $_POST['password'];

		$password = password_hash($password, PASSWORD_DEFAULT);

		$conn = $pdo->open();
		
		$now = date('Y-m-d h:i A');

		//get the currennt details of the user
		$get_stmt = $conn->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
	    $get_stmt->execute(['id'=>$id]);
	    $curr_det = $get_stmt->fetch(PDO::FETCH_ASSOC);

		try{
			$stmt = $conn->prepare("UPDATE users SET password=:password, updated_at=:updated_at WHERE id=:id");
			$stmt->execute(['password'=>$password, 'updated_at'=>$now, 'id'=>$id]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    		$activity->execute(['user_id'=>$admin["id"], 'message'=>'Set password for '.$curr_det["full_name"], 'category'=>'Audit', 'date_sent'=>$now]);

    		try {
                $to = $curr_det['email'];
                $subject = "Komecare Onboarding";
                $message = '
				<html>
					<head>
					<title>Komecare</title>
					</head>
					<body style="font-family: Arial, sans-serif; background-color: #f2f2f2; padding: 20px;">
						<div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
						  <h1 style="font-size: 24px; color: #333; margin-bottom: 20px;">KOMECARE</h1>
						  <p style="font-size: 16px; color: #333;">Dear '.$curr_det["full_name"].'</p>
						  <p style="font-size: 16px; color: #333;">Your password has been set. See below</p>
						  <p style="font-size: 16px; color: #333;">Password is <strong>'.$_POST['password'].'</strong></p>
						  <p style="font-size: 16px; color: #333;">Ensure you change your password once you are logged in.</p>
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
                $_SESSION['success'] = 'Password set successfully but email not sent.';
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }

			$_SESSION['success'] = 'Password set successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Enter password for user first';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>