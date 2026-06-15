<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$full_name = $_POST['full_name'];
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$nationality = $_POST['nationality'];
		$phone_no = $_POST['phone_no'];
		$type = $_POST['type'];
		$profile_code = $_POST['profile_code'];
		$postal_code = $_POST['postal_code'];
		$career_path = $_POST['career_path'];
		$application_status = $_POST['application_status'];
		$passport_id = $_POST['passport_id'];
		$visa_status = $_POST['visa_status'];
		$perm_lc = $_POST['perm_lc'];
		$flight_ticket = $_POST['flight_ticket'];
		$green_card = $_POST['green_card'];
		$office_addr = $_POST['office_addr'];
		$salary = $_POST['salary'];
		$start_date = $_POST['start_date'];
		$company_message = $_POST['company_message'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already taken';
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$filename = $_FILES['photo']['name'];
			$now = date('Y-m-d');
			if(!empty($filename)){
				move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$filename);	
			}
			try{
				$stmt = $conn->prepare("INSERT INTO users (email, password, full_name, uname, nationality, phone_no, photo, status, type, profile_code, postal_code, career_path, application_status, passport_id, visa_status, perm_lc, flight_ticket, green_card, office_addr, salary, start_date, company_message, created_on) VALUES (:email, :password, :full_name, :uname, :nationality, :phone_no, :photo, :status, :type, :profile_code, :postal_code, :career_path, :application_status, :passport_id, :visa_status, :perm_lc, :flight_ticket, :green_card, :office_addr, :salary, :start_date, :company_message, :created_on)");
				$stmt->execute(['email'=>$email, 'password'=>$password, 'full_name'=>$full_name, 'uname'=>$uname, 'nationality'=>$nationality, 'phone_no'=>$phone_no, 'photo'=>$filename, 'status'=>0, 'type'=>$type, 'profile_code'=>$profile_code, 'postal_code'=>$postal_code, 'career_path'=>$career_path, 'application_status'=>$application_status, 'passport_id'=>$passport_id, 'visa_status'=>$visa_status, 'perm_lc'=>$perm_lc, 'flight_ticket'=>$flight_ticket, 'green_card'=>$green_card, 'office_addr'=>$office_addr, 'salary'=>$salary, 'start_date'=>$start_date, 'company_message'=>$company_message, 'created_on'=>$now]);
				$_SESSION['success'] = 'Worker added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up worker form first';
	}

	header('location: users.php');

?>