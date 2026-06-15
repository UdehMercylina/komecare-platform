<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$title = $_POST['title'];
		$short_description = $_POST['short_description'];
		$description = $_POST['description'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM jobs WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		try{
			$stmt = $conn->prepare("UPDATE jobs SET title=:title, short_description=:short_description, description=:description WHERE id=:id");
			$stmt->execute(['title'=>$title, 'short_description'=>$short_description, 'description'=>$description, 'id'=>$id]);
			$_SESSION['success'] = 'Job edited successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit job form first';
	}

	header('location: jobs.php');

?>