<?php
include 'includes/session.php';

if(isset($_POST['delete'])){
	$id = $_POST['id'];

	$conn = $pdo->open();

	$now = date('Y-m-d h:i A');

	//get the currennt details of the user
	$get_stmt = $conn->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
	$get_stmt->execute(['id'=>$id]);
	$curr_det = $get_stmt->fetch(PDO::FETCH_ASSOC);

	try{
		$stmt = $conn->prepare("UPDATE users SET soft_delete=1 WHERE id=:id");
		$stmt->execute(['id'=>$id]);

		$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
	    $activity->execute(['user_id'=>$admin["id"], 'message'=>'Revoked '.$curr_det["full_name"], 'category'=>'Audit', 'date_sent'=>$now]);

		$_SESSION['success'] = 'User revoked successfully';
	}
	catch(PDOException $e){
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();}
else{
	$_SESSION['error'] = 'Select user to revoke';
}	

header('Location: candidates_active.php');
exit;
?>