<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$email = $_POST['email'];
		$phone_no = $_POST['phone_no'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$full_name = $_POST['firstname']." ".$_POST['lastname'];
		$uname = $_POST['uname'];
		$business_name = $_POST['business_name'];
		$industry = $_POST['industry'];
		$profile_code = $_POST['profile_code'];
		$address = $_POST['address'];
		$town_city = $_POST['town_city'];
		$postcode = $_POST['postcode'];
		$type = 1;
		$status = 1;

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already exists';
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$now = date('Y-m-d');
			try{
				$stmt = $conn->prepare("INSERT INTO users (email, phone_no, password, firstname, lastname, full_name, uname, business_name, industry, profile_code, address, town_city, postcode, status, type, created_on) VALUES (:email, :phone_no, :password, :firstname, :lastname, :full_name, :uname, :business_name, :industry, :profile_code, :address, :town_city, :postcode, :status, :type, :created_on)");
				$stmt->execute(['email'=>$email, 'phone_no'=>$phone_no, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'full_name'=>$full_name, 'uname'=>$uname, 'business_name'=>$business_name, 'industry'=>$industry, 'profile_code'=>$profile_code, 'address'=>$address, 'town_city'=>$town_city, 'postcode'=>$postcode, 'status'=>$status, 'type'=>$type, 'created_on'=>$now]);

				$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Created '.$business_name.' profile', 'category'=>'Audit', 'date_sent'=>$now]);

				$_SESSION['success'] = 'Stakeholder added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up stakeholder form first';
	}

	header('location: stakeholders_active.php');

?>