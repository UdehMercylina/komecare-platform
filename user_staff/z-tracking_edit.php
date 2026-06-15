<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$trackingId = $_POST['trackingId'];
		$shipmentId = $_POST['shipmentId'];
		$dateShipped = $_POST['dateShipped'];
		$expDelDate = $_POST['expDelDate'];
		$origin = $_POST['origin'];
		$destination = $_POST['destination'];
		$sender = $_POST['sender'];
		$senderAdd = $_POST['senderAdd'];
		$receiver = $_POST['receiver'];
		$receiverAdd = $_POST['receiverAdd'];
		$terms = $_POST['terms'];
		$reference = $_POST['reference'];
		$orderNum = $_POST['orderNum'];
		$invoiceNum = $_POST['invoiceNum'];
		$quantity = $_POST['quantity'];
		$service = $_POST['service'];
		$package = $_POST['package'];
		$weight = $_POST['weight'];
		$dimensions = $_POST['dimensions'];

		$conn = $pdo->open();
		$stmt = $conn->prepare("SELECT * FROM tracking WHERE id=:id");
		$stmt->execute(['id'=>$id]);
		$row = $stmt->fetch();

		try{
			$stmt = $conn->prepare("UPDATE tracking SET trackingId=:trackingId, shipmentId=:shipmentId, dateShipped=:dateShipped, expDelDate=:expDelDate, origin=:origin, destination=:destination, sender=:sender, senderAdd=:senderAdd, receiver=:receiver, receiverAdd=:receiverAdd, terms=:terms, reference=:reference, orderNum=:orderNum, invoiceNum=:invoiceNum, quantity=:quantity, service=:service, package=:package, weight=:weight, dimensions=:dimensions WHERE id=:id");
			$stmt->execute(['trackingId'=>$trackingId, 'shipmentId'=>$shipmentId, 'dateShipped'=>$dateShipped, 'expDelDate'=>$expDelDate, 'origin'=>$origin, 'destination'=>$destination, 'sender'=>$sender, 'senderAdd'=>$senderAdd, 'receiver'=>$receiver, 'receiverAdd'=>$receiverAdd, 'terms'=>$terms, 'reference'=>$reference, 'orderNum'=>$orderNum, 'invoiceNum'=>$invoiceNum, 'quantity'=>$quantity, 'service'=>$service, 'package'=>$package, 'weight'=>$weight, 'dimensions'=>$dimensions, 'id'=>$id]);
			$_SESSION['success'] = 'Tracking edited successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit tracking form first';
	}

	header('location: tracking.php');

?>