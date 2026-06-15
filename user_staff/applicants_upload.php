<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$full_name = $firstname." ".$lastname;
		$gender = $_POST['gender'];
		$dob = $_POST['dob'];
		$uname = $_POST['uname'];
		$profile_code = $_POST['profile_code'];
		$phone_no = $_POST['phone_no'];
		$address = $_POST['address'];
		$town_city = $_POST['town_city'];
		$postcode = $_POST['postcode'];
		$country = $_POST['country'];
		$career_path = $_POST['career_path'];

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
			$stmt = $conn->prepare("UPDATE users SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, full_name=:full_name, gender=:gender, dob=:dob, uname=:uname, profile_code=:profile_code, phone_no=:phone_no, address=:address, town_city=:town_city, postcode=:postcode, country=:country, career_path=:career_path, application_status=:application_status, updated_at=:updated_at WHERE id=:id");
			$stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'full_name'=>$full_name, 'gender'=>$gender, 'dob'=>$dob, 'uname'=>$uname, 'profile_code'=>$profile_code, 'phone_no'=>$phone_no, 'address'=>$address, 'town_city'=>$town_city, 'postcode'=>$postcode, 'country'=>$country, 'career_path'=>$career_path, 'application_status'=>1, 'updated_at'=>$now, 'id'=>$id]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    		$activity->execute(['user_id'=>$admin["id"], 'message'=>'Successfully onboarded '.$full_name, 'category'=>'Audit', 'date_sent'=>$now]);

			$_SESSION['success'] = 'User onboarded successfully. Transferred to recruitment team.';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select user to onboard';
	}

	header('location: onboarding.php');

?>