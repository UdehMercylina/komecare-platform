<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$selected_date = $_POST['selected_date'];
		$time_of_day = $_POST['time_of_day'];

		$conn = $pdo->open();

		$now = date('Y-m-d h:i A');

		$get_status = $conn->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
		$get_status->execute(['id'=>$staff['id']]);
		$curr_det = $get_status->fetch(PDO::FETCH_ASSOC);

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM availability WHERE user_id=:user_id AND selected_date=:selected_date AND soft_delete=0");
		$stmt->execute(['user_id'=>$staff['id'], 'selected_date'=>$selected_date]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0 && $curr_det['availability_status'] == 'close'){
			$_SESSION['error'] = 'You have already set availability for this day. Please select another day.';
		}
		else{

			if($row['numrows'] > 0 && $curr_det['availability_status'] == 'open'){
				try{

					$stmt = $conn->prepare("UPDATE availability SET time_of_day=:time_of_day WHERE user_id=:id AND selected_date=:selected_date");
					$stmt->execute(['time_of_day'=>$time_of_day, 'id'=>$staff['id'], 'selected_date'=>$selected_date]);

					$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
		    		$activity->execute(['user_id'=>$staff["id"], 'message'=>'Updated Availability', 'category'=>'Audit', 'date_sent'=>$now]);

					$_SESSION['success'] = 'Availability updated successfully';

				}
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
				}
			}else{

				try{
					$stmt = $conn->prepare("INSERT INTO availability (user_id, selected_date, time_of_day) VALUES (:user_id, :selected_date, :time_of_day)");
					$stmt->execute(['user_id'=>$staff['id'], 'selected_date'=>$selected_date, 'time_of_day'=>$time_of_day]);

					$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
		    		$activity->execute(['user_id'=>$staff["id"], 'message'=>'Updated Availability', 'category'=>'Audit', 'date_sent'=>$now]);

					$_SESSION['success'] = 'Availability added successfully';

				}
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
				}
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up availability form first';
	}

	header('location: availability.php');

?>