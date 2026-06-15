<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$phonenumber = $_POST['phonenumber'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM phone_numbers WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		try{
			$stmt = $conn->prepare("UPDATE phone_numbers SET phonenumber=:phonenumber WHERE id=:id");
			$stmt->execute(['phonenumber'=>$phonenumber, 'id'=>$id]);
			$_SESSION['success'] = 'Phone Number edited successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit Phone Number form first';
	}

	header('location: phone_numbers.php');

?>