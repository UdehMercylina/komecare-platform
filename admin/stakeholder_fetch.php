<?php
  include 'includes/session.php';

  $output = '';

  $conn = $pdo->open();

  $stmt = $conn->prepare("SELECT * FROM users WHERE type=:type ORDER BY business_name");
  $stmt->execute(['type'=>1]);

  foreach($stmt as $row){
    $output .= "
      <option value='".$row['id']."' class='append_items'>".$row['business_name']."</option>
    ";
  }

  $pdo->close();
  echo json_encode($output);

?>