<?php
	include 'includes/session.php';

	if(isset($_POST['update'])){
		$trackingId = $_POST['trackingId'];
		$location = $_POST['location'];
		$dateAndTime = $_POST['dateAndTime'];
		$remark = $_POST['remark'];
		$status = $_POST['status'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM tracking WHERE trackingId=:trackingId");
		$stmt->execute(['trackingId'=>$trackingId]);
		$row = $stmt->fetch();



		if($row['numrows'] > 0){

			/*$id = NULL;
			$now = date('Y-m-d g:i A');
            $status = '0';    

			$act_time = date('Y-m-d h:i A');*/

			
			try{

				$stmt = $conn->prepare("INSERT INTO update_tracking (trackingId, location, dateAndTime, remark, status) VALUES (:trackingId, :location, :dateAndTime, :remark, :status)");
				$stmt->execute(['trackingId'=>$trackingId, 'location'=>$location, 'dateAndTime'=>$dateAndTime, 'remark'=>$remark, 'status'=>$status]);
					            
				$_SESSION['success'] = 'Tracking Updated Successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up Update Tracking form first';
	}

	header('location: tracking.php');

?>