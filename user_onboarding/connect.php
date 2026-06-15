<?php
$servername = getenv('DB_HOST');
// Enter your MySQL username in the .env file
$username   = getenv('DB_USER');
// Enter your MySQL password in the .env file
$password   = getenv('DB_PASS');
// Enter your database name in the .env file
$dbname     = getenv('DB_NAME');
// Create connection
$conne = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conne->connect_error) {
    header("location:connection_error.php?error=$conn->connect_error");
    die($conne->connect_error);
}
?>