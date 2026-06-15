<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$time_of_day = $_POST['time_of_day'];

		$conn = $pdo->open();

		$now = date('Y-m-d h:i A');

		try{
			$stmt = $conn->prepare("UPDATE availability SET start_date=:start_date, end_date=:end_date, time_of_day=:time_of_day WHERE id=:id");
			$stmt->execute(['start_date'=>$start_date, 'end_date'=>$end_date, 'time_of_day'=>$time_of_day, 'id'=>$id]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    		$activity->execute(['user_id'=>$staff["id"], 'message'=>'Updated Availability', 'category'=>'Audit', 'date_sent'=>$now]);
    		
			$_SESSION['success'] = 'Availability updated successfully';

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