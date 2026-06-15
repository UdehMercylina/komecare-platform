<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$time_of_day = $_POST['time_of_day'];

		$conn = $pdo->open();

		$now = date('Y-m-d h:i A');

		try{
			$stmt = $conn->prepare("INSERT INTO availability (user_id, start_date, end_date, time_of_day) VALUES (:user_id, :start_date, :end_date, :time_of_day)");
			$stmt->execute(['user_id'=>$staff['id'], 'start_date'=>$start_date, 'end_date'=>$end_date, 'time_of_day'=>$time_of_day]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    		$activity->execute(['user_id'=>$staff["id"], 'message'=>'Updated Availability', 'category'=>'Audit', 'date_sent'=>$now]);

			$_SESSION['success'] = 'Availability added successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up availability form first';
	}

	header('location: availability.php');

?>