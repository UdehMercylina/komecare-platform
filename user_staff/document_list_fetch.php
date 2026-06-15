<?php
	include 'includes/session.php';

	$output = '';

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM documents_list WHERE soft_delete=0 ORDER BY document_name");
	$stmt->execute();

	foreach($stmt as $row){
		$output .= "
			<option value='".$row['id']."' class='append_items'>- ".$row['document_name']." -</option>
		";
	}

	$pdo->close();
	echo json_encode($output);

?>