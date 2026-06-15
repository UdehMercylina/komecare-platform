<?php
	include 'includes/session.php';

	$output = '';

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM project_manager ORDER BY pm_name");
	$stmt->execute();

	foreach($stmt as $row){
		$output .= "
			<option value='".$row['pm_id']."' class='append_items'>".$row['pm_name']." - (".$row['total_projects_managed'].") projects managed</option>
		";
	}

	$pdo->close();
	echo json_encode($output);

?>