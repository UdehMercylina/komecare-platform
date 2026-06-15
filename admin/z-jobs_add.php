<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['add'])){
		$title = $_POST['title'];
		$slug = slugify($title);
		$short_description = $_POST['short_description'];
		$description = $_POST['description'];

		$conn = $pdo->open();

			try{
				$stmt = $conn->prepare("INSERT INTO jobs (title, short_description, description, slug) VALUES (:title, :short_description, :description, :slug)");
				$stmt->execute(['title'=>$title, 'short_description'=>$short_description, 'description'=>$description, 'slug'=>$slug]);


				$_SESSION['success'] = 'Job added successfully';



			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up job form first';
	}

	header('location: jobs.php');

?>