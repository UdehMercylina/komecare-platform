<?php
include 'includes/session.php';

if(isset($_POST['delete'])){
	$id = $_POST['id'];

	$conn = $pdo->open();

	$now = date('Y-m-d h:i A');

	//get the currennt details of the document
	$get_stmt = $conn->prepare("SELECT * FROM documents LEFT JOIN users ON documents.user_id = users.id WHERE documents.id=:id LIMIT 1");
	$get_stmt->execute(['id'=>$id]);
	$curr_det = $get_stmt->fetch(PDO::FETCH_ASSOC);

	try{
		$stmt = $conn->prepare("UPDATE documents SET soft_delete=1 WHERE id=:id");
		$stmt->execute(['id'=>$id]);

		$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
	    $activity->execute(['user_id'=>$admin["id"], 'message'=>'Deleted '.$curr_det["full_name"].' '.$curr_det["file_title"].' document', 'category'=>'Audit', 'date_sent'=>$now]);

		$_SESSION['success'] = 'File deleted successfully';
	}
	catch(PDOException $e){
		$_SESSION['error'] = $e->getMessage();
	}

	$pdo->close();}
else{
	$_SESSION['error'] = 'Select file to delete first';
}	

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>