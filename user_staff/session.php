<?php
	include 'includes/conn.php';
	session_start();

	if(isset($_SESSION['user_staff'])){
		header('location: user_staff/dashboard.php');
	}
?>