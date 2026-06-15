<?php
include 'includes/session.php';

$id=$_REQUEST['id'];

$conn = $pdo->open();

try{
	$stmt = $conn->prepare("DELETE FROM update_tracking WHERE id=:id");
	$stmt->execute(['id'=>$id]);

	$_SESSION['success'] = 'File deleted successfully';
}
catch(PDOException $e){
	$_SESSION['error'] = $e->getMessage();
}

$pdo->close();		

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>