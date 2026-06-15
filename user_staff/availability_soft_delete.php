<?php
include 'includes/session.php';

if(isset($_POST['delete'])){
	$id = $_POST['id'];

	$conn = $pdo->open();

	$now = date('Y-m-d h:i A');

	try{
		$stmt = $conn->prepare("UPDATE availability SET soft_delete=1 WHERE id=:id");
		$stmt->execute(['id'=>$id]);

		$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
	    $activity->execute(['user_id'=>$staff["id"], 'message'=>'Deleted Availability', 'category'=>'Audit', 'date_sent'=>$now]);

		$_SESSION['success'] = 'Availability deleted successfully';
	}
	catch(PDOException $e){
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();}
else{
	$_SESSION['error'] = 'Select Availability to delete first';
}	

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>