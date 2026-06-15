<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$full_name = $firstname." ".$lastname;
		$gender = $_POST['gender'];
		$uname = $_POST['uname'];
		$profile_code = $_POST['profile_code'];
		$phone_no = $_POST['phone_no'];
		$admin_role = $_POST['admin_role'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		$now = date('Y-m-d h:i A');

		if($password == $row['password']){
			$password = $row['password'];
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		try{
			$stmt = $conn->prepare("UPDATE users SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, full_name=:full_name, gender=:gender, uname=:uname, phone_no=:phone_no, admin_role=:admin_role, updated_at=:updated_at WHERE id=:id");
			$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'full_name'=>$full_name, 'gender'=>$gender, 'uname'=>$uname, 'phone_no'=>$phone_no, 'admin_role'=>$admin_role, 'updated_at'=>$now, 'id'=>$id]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    		$activity->execute(['user_id'=>$admin["id"], 'message'=>'Updated '.$full_name.' details', 'category'=>'Audit', 'date_sent'=>$now]);

			$_SESSION['success'] = 'Admin details updated successfully.';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select admin to update';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;
?>