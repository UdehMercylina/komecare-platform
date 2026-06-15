
<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];

		$conn = $pdo->open();

		$now = date('Y-m-d h:i A');

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM documents_list WHERE document_name=:name");
		$stmt->execute(['name'=>$name]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Document already exist';
		}
		else{
			try{

				$get_stmt = $conn->prepare("SELECT * FROM documents_list WHERE id=:id LIMIT 1");
			    $get_stmt->execute(['id'=>$id]);
			    $curr_det = $get_stmt->fetch(PDO::FETCH_ASSOC);

				$stmt = $conn->prepare("UPDATE documents_list SET document_name=:name, updated_by=:updated_by, updated_at=:updated_at WHERE id=:id");
				$stmt->execute(['name'=>$name, 'updated_by'=>$admin["id"], 'updated_at'=>$now, 'id'=>$id]);

				$activity = $conn->prepare("INSERT INTO activity (user_id, message, category, date_sent) VALUES (:user_id, :message, :category, :date_sent)");
    			$activity->execute(['user_id'=>$admin["id"], 'message'=>'Changed '.$curr_det["document_name"].' to '.$name.' document', 'category'=>'Audit', 'date_sent'=>$now]);

				$_SESSION['success'] = 'Document updated successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up document edit form first';
	}

	header('Location: '.$_SERVER['HTTP_REFERER']);
	exit;

?>