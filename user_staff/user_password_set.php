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

			$_SESSION['success'] = 'Password set successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select document status first';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>