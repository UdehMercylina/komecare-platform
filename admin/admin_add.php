<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
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

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email address is already in system';
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$now = date('Y-m-d');
			try{
				$stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, full_name, gender, uname, profile_code, phone_no, admin_role, status, type, created_on) VALUES (:email, :password, :firstname, :lastname, :full_name, :gender, :uname, :profile_code, :phone_no, :admin_role, :status, :type, :created_on)");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'full_name'=>$full_name, 'gender'=>$gender, 'uname'=>$uname, 'profile_code'=>$profile_code, 'phone_no'=>$phone_no, 'admin_role'=>$admin_role, 'status'=>1, 'type'=>2, 'created_on'=>$now]);

				$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Created and added '.$full_name.' as a new '.$admin_role.' admin', 'category'=>'Audit', 'date_sent'=>$now]);
				$_SESSION['success'] = 'Admin created successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up admin creation form first';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>