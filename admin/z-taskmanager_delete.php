<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM project_manager WHERE pm_id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'Manager deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select project manager to delete first';
	}

	header('location: taskmanagers.php');
	
?>