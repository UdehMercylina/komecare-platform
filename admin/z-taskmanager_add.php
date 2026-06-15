<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$pm_name = $_POST['pm_name'];
		$pm_position = $_POST['pm_position'];
		$total_projects_managed = $_POST['total_projects_managed'];

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("INSERT INTO project_manager (pm_name, pm_position, total_projects_managed) VALUES (:pm_name, :pm_position, :total_projects_managed)");
			$stmt->execute(['pm_name'=>$pm_name, 'pm_position'=>$pm_position, 'total_projects_managed'=>$total_projects_managed]);
			$_SESSION['success'] = 'Project manager added successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up project manager form first';
	}

	header('location: taskmanagers.php');

?>