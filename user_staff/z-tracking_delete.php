<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE tracking, update_tracking FROM tracking INNER JOIN update_tracking on tracking.trackingId = update_tracking.trackingId WHERE tracking.id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'tracking deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select tracking to delete first';
	}

	header('location: tracking.php');
	
?>