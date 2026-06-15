<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM task WHERE task_id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'Task deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select task to delete first';
	}

	header('location: tasks.php');
	
?>