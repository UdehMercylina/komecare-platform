<?php
	include 'inc/session.php';
	include '../admin/includes/slugify.php';

	$user_id = $_SESSION['onboardee'];

	if(isset($_POST['update'])){
		$dob = $_POST['dob'];

		$conn = $pdo->open();

		$date_view = date('Y-m-d');

		$act_time = date('Y-m-d h:i A');

		try{

			$stmt = $conn->prepare("UPDATE users SET dob=:dob WHERE id=:id");
			$stmt->execute(['dob'=>$dob, 'id'=>$user_id]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :start_date)");
			$activity->execute(['user_id'=>$user_id, 'message'=>'Updated your profile. Added Date of Birth', 'category'=>'Audit', 'start_date'=>$act_time]);

			$_SESSION['success'] = 'Profile Setup Completed';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'You are not doing something right';
	}

	header('location: profile.php');

?>