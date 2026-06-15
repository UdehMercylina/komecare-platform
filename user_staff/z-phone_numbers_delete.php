<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM phone_numbers WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'phone number deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select phone number to delete first';
	}

	header('location: phone_numbers.php');
	
?>