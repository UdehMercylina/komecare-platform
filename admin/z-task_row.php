<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, task.pm_id AS task_pmid, project_manager.pm_id AS manager_pmid FROM task LEFT JOIN project_manager ON task.pm_id=project_manager.pm_id LEFT JOIN users ON task.user_id=users.id WHERE task.task_id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();
		
		$pdo->close();

		echo json_encode($row);
	}
?>