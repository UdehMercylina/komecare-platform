<?php
  include 'includes/session.php';

  $output = '';

  $conn = $pdo->open();

  $stmt = $conn->prepare("SELECT * FROM users WHERE type=:type AND soft_delete=:soft_delete ORDER BY full_name");
  $stmt->execute(['type'=>0, 'soft_delete'=>0]);

  foreach($stmt as $row){
    $output .= "
      <option value='".$row['id']."' class='append_items'>".$row['full_name']."</option>
    ";
  }

  $pdo->close();
  echo json_encode($output);

?>