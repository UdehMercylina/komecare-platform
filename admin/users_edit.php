<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$full_name = $_POST['full_name'];
		$uname = $_POST['uname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$nationality = $_POST['nationality'];
		$phone_no = $_POST['phone_no'];
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
		$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		if($password == $row['password']){
			$password = $row['password'];
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		$file_title = $_POST['file_title'];
		$file_name = $_FILES['new_file']['name'];
		if(!empty($file_name)){
			move_uploaded_file($_FILES['new_file']['tmp_name'], 'uploads/'.$file_name);

			try{
				$stmt = $conn->prepare("INSERT INTO worker_files (worker_id, file_title, file_name) VALUES (:worker_id, :file_title, :file_name)");
				$stmt->execute(['worker_id'=>$id, 'file_title'=>$file_title, 'file_name'=>$file_name]);
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		try{
			$stmt = $conn->prepare("UPDATE users SET email=:email, password=:password, full_name=:full_name, uname=:uname, nationality=:nationality, phone_no=:phone_no, profile_code=:profile_code, postal_code=:postal_code, career_path=:career_path, application_status=:application_status, passport_id=:passport_id, visa_status=:visa_status, perm_lc=:perm_lc, flight_ticket=:flight_ticket, green_card=:green_card, office_addr=:office_addr, salary=:salary, start_date=:start_date, company_message=:company_message WHERE id=:id");
			$stmt->execute(['email'=>$email, 'password'=>$password, 'full_name'=>$full_name, 'uname'=>$uname, 'nationality'=>$nationality, 'phone_no'=>$phone_no, 'profile_code'=>$profile_code, 'postal_code'=>$postal_code, 'career_path'=>$career_path, 'application_status'=>$application_status, 'passport_id'=>$passport_id, 'visa_status'=>$visa_status, 'perm_lc'=>$perm_lc, 'flight_ticket'=>$flight_ticket, 'green_card'=>$green_card, 'office_addr'=>$office_addr, 'salary'=>$salary, 'start_date'=>$start_date, 'company_message'=>$company_message, 'id'=>$id]);
			$_SESSION['success'] = 'Worker updated successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit worker form first';
	}

	header('location: users.php');

?>