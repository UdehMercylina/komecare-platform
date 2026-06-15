<?php
include 'includes/session.php';

$id=$_REQUEST['id'];

$conn = $pdo->open();

try{
	$stmt = $conn->prepare("DELETE FROM identity_verification_file WHERE id_verification_file_id=:id");
	$stmt->execute(['id'=>$id]);

	$_SESSION['success'] = 'File deleted successfully';
}
catch(PDOException $e){
	$_SESSION['error'] = $e->getMessage();
}

$pdo->close();		

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>