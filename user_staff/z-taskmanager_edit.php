<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$pm_name = $_POST['pm_name'];
		$pm_position = $_POST['pm_position'];
		$total_projects_managed = $_POST['total_projects_managed'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM project_manager WHERE pm_id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		try{
			$stmt = $conn->prepare("UPDATE project_manager SET pm_name=:pm_name, pm_position=:pm_position, total_projects_managed=:total_projects_managed WHERE pm_id=:id");
			$stmt->execute(['pm_name'=>$pm_name, 'pm_position'=>$pm_position, 'total_projects_managed'=>$total_projects_managed, 'id'=>$id]);
			$_SESSION['success'] = 'Manager updated successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit project manager form first';
	}

	header('location: taskmanagers.php');

?>