<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['add'])){
		$phonenumber = $_POST['phonenumber'];

		$conn = $pdo->open();

			try{
				$stmt = $conn->prepare("INSERT INTO phone_numbers (phonenumber) VALUES (:phonenumber)");
				$stmt->execute(['phonenumber'=>$phonenumber]);

				$_SESSION['success'] = 'Phone Number added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up Phone Number form first';
	}

	header('location: phone_numbers.php');
?>