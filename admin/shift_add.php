<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$stakeholder_id = $_POST['stakeholder_id'];
		$task_title = $_POST['task_title'];
		$business_unit = $_POST['business_unit'];
		$shift_location = $_POST['shift_location'];
		$shift_start_date = $_POST['shift_start_date'];
		$shift_due_date = $_POST['shift_due_date'];
		$task_description_summary = $_POST['task_description_summary'];
		$task_description = $_POST['task_description'];
		$shift_status = "unassigned";

		$conn = $pdo->open();

		$now = date('Y-m-d');
		try{
			$stmt = $conn->prepare("INSERT INTO shift (stakeholder_id, task_title, business_unit, shift_location, shift_start_date, shift_due_date, task_description_summary, task_description, shift_status, last_updated) VALUES (:stakeholder_id, :task_title, :business_unit, :shift_location, :shift_start_date, :shift_due_date, :task_description_summary, :task_description, :shift_status, :last_updated)");
			$stmt->execute(['stakeholder_id'=>$stakeholder_id, 'task_title'=>$task_title, 'business_unit'=>$business_unit, 'shift_location'=>$shift_location, 'shift_start_date'=>$shift_start_date, 'shift_due_date'=>$shift_due_date, 'task_description_summary'=>$task_description_summary, 'task_description'=>$task_description, 'shift_status'=>$shift_status, 'last_updated'=>$now]);

			$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Created a task. Task Title: '.$task_title, 'category'=>'Audit', 'date_sent'=>$now]);

			$_SESSION['success'] = 'Shift created successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up shift form first';
	}

	header('location: recruitment_unassigned_shifts.php');

?>