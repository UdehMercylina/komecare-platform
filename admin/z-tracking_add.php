<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	include 'includes/session.php';

	if(isset($_POST['add'])){
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
		$email = $_POST['receiverEmail'];
		$terms = $_POST['terms'];
		$reference = $_POST['reference'];
		$orderNum = $_POST['orderNum'];
		$invoiceNum = $_POST['invoiceNum'];
		$quantity = $_POST['quantity'];
		$service = $_POST['service'];
		$package = $_POST['package'];
		$weight = $_POST['weight'];
		$dimensions = $_POST['dimensions'];
		$location = $_POST['location'];
		$dateAndTime = $_POST['dateAndTime'];
		$remark = $_POST['remark'];
		$status = $_POST['status'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM tracking WHERE trackingId=:trackingId");
		$stmt->execute(['trackingId'=>$trackingId]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Tracking ID already taken';
		}
		else{
			try{
				$stmt = $conn->prepare("INSERT INTO tracking (trackingId, shipmentId, dateShipped, expDelDate, origin, destination, sender, senderAdd, receiver, receiverAdd, terms, reference, orderNum, invoiceNum, quantity, service, package, weight, dimensions) VALUES (:trackingId, :shipmentId, :dateShipped, :expDelDate, :origin, :destination, :sender, :senderAdd, :receiver, :receiverAdd, :terms, :reference, :orderNum, :invoiceNum, :quantity, :service, :package, :weight, :dimensions)");
				$stmt->execute(['trackingId'=>$trackingId, 'shipmentId'=>$shipmentId, 'dateShipped'=>$dateShipped, 'expDelDate'=>$expDelDate, 'origin'=>$origin, 'destination'=>$destination, 'sender'=>$sender, 'senderAdd'=>$senderAdd, 'receiver'=>$receiver, 'receiverAdd'=>$receiverAdd, 'terms'=>$terms, 'reference'=>$reference, 'orderNum'=>$orderNum, 'invoiceNum'=>$invoiceNum, 'quantity'=>$quantity, 'service'=>$service, 'package'=>$package, 'weight'=>$weight, 'dimensions'=>$dimensions]);

				$stmt = $conn->prepare("INSERT INTO update_tracking (trackingId, location, dateAndTime, remark, status) VALUES (:trackingId, :location, :dateAndTime, :remark, :status)");
				$stmt->execute(['trackingId'=>$trackingId, 'location'=>$location, 'dateAndTime'=>$dateAndTime, 'remark'=>$remark, 'status'=>$status]);

				$message = '
					<!DOCTYPE html>
					<html lang="en-US">
					    <head>
					        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					        <title></title>
					    </head>
					    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="padding: 0;">
					        <div id="wrapper" dir="ltr" style="background-color: #f7f7f7; margin: 0; padding: 70px 0; width: 100%; -webkit-text-size-adjust: none;">
					            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
					                <tr>
					                    <td align="center" valign="top">
					                        <div id="template_header_image"></div>
					                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: #ffffff; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); border-radius: 3px;">
					                            <tr>
					                                <td align="center" valign="top">
					                                    <!-- Header -->
					                                    <table
					                                        border="0"
					                                        cellpadding="0"
					                                        cellspacing="0"
					                                        width="600"
					                                        id="template_header"
					                                        style="
					                                            background-color: #96588a;
					                                            color: #ffffff;
					                                            border-bottom: 0;
					                                            font-weight: bold;
					                                            line-height: 100%;
					                                            vertical-align: middle;
					                                            font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                            border-radius: 3px 3px 0 0;
					                                        "
					                                    >
					                                        <tr>
					                                            <td id="header_wrapper" style="padding: 36px 48px; display: block;">
					                                                <h1
					                                                    style="
					                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                        font-size: 30px;
					                                                        font-weight: 300;
					                                                        line-height: 150%;
					                                                        margin: 0;
					                                                        text-align: left;
					                                                        text-shadow: 0 1px 0 #ab79a1;
					                                                        color: #ffffff;
					                                                    "
					                                                >
					                                                    Sme Courier
					                                                </h1>
					                                            </td>
					                                        </tr>
					                                    </table>
					                                    <!-- End Header -->
					                                </td>
					                            </tr>
					                            <tr>
					                                <td align="center" valign="top">
					                                    <!-- Body -->
					                                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
					                                        <tr>
					                                            <td valign="top" id="body_content" style="background-color: #ffffff;">
					                                                <!-- Content -->
					                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
					                                                    <tr>
					                                                        <td valign="top" style="padding: 48px 48px 0;">
					                                                            <div id="body_content_inner" style="color: #636363; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">
					                                                                <p style="margin: 0 0 16px;">Dear '.$receiver.',</p>
					                                                                <p style="margin: 0 0 16px;">Your Shipment is on its way. You can track your item by clicking this link. <a href="https://komerec.com/track.php">Track your shipment</a></p>

					                                                                <h2
					                                                                    style="
					                                                                        color: #96588a;
					                                                                        display: block;
					                                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                        font-size: 18px;
					                                                                        font-weight: bold;
					                                                                        line-height: 130%;
					                                                                        margin: 0 0 18px;
					                                                                        text-align: left;
					                                                                    "
					                                                                >
					                                                                    [Shipment ID #'.$trackingId.']
					                                                                </h2>

					                                                                <div style="margin-bottom: 40px;">
					                                                                    <table
					                                                                        class="td"
					                                                                        cellspacing="0"
					                                                                        cellpadding="6"
					                                                                        border="1"
					                                                                        style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; width: 100%; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;"
					                                                                    >
					                                                                        <thead>
					                                                                            <tr>
					                                                                                <th class="td" scope="col" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;">Details</th>
					                                                                                <th class="td" scope="col" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;"></th>
					                                                                            </tr>
					                                                                        </thead>
					                                                                        <tbody>
					                                                                            <tr class="order_item">
					                                                                                <td
					                                                                                    class="td"
					                                                                                    style="
					                                                                                        color: #636363;
					                                                                                        border: 1px solid #e5e5e5;
					                                                                                        padding: 12px;
					                                                                                        text-align: left;
					                                                                                        vertical-align: middle;
					                                                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                        word-wrap: break-word;
					                                                                                    "
					                                                                                >
					                                                                                    From:
					                                                                                </td>
					                                                                                <td
					                                                                                    class="td"
					                                                                                    style="
					                                                                                        color: #636363;
					                                                                                        border: 1px solid #e5e5e5;
					                                                                                        padding: 12px;
					                                                                                        text-align: left;
					                                                                                        vertical-align: middle;
					                                                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                    "
					                                                                                >
					                                                                                    '.$sender.'
					                                                                                </td>
					                                                                            </tr>
					                                                                            <tr class="order_item">
					                                                                                <td
					                                                                                    class="td"
					                                                                                    style="
					                                                                                        color: #636363;
					                                                                                        border: 1px solid #e5e5e5;
					                                                                                        padding: 12px;
					                                                                                        text-align: left;
					                                                                                        vertical-align: middle;
					                                                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                        word-wrap: break-word;
					                                                                                    "
					                                                                                >
					                                                                                    Origin:
					                                                                                </td>
					                                                                                <td
					                                                                                    class="td"
					                                                                                    style="
					                                                                                        color: #636363;
					                                                                                        border: 1px solid #e5e5e5;
					                                                                                        padding: 12px;
					                                                                                        text-align: left;
					                                                                                        vertical-align: middle;
					                                                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                    "
					                                                                                >
					                                                                                    '.$origin.'
					                                                                                </td>
					                                                                            </tr>
					                                                                            <tr class="order_item">
					                                                                                <td
					                                                                                    class="td"
					                                                                                    style="
					                                                                                        color: #636363;
					                                                                                        border: 1px solid #e5e5e5;
					                                                                                        padding: 12px;
					                                                                                        text-align: left;
					                                                                                        vertical-align: middle;
					                                                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                        word-wrap: break-word;
					                                                                                    "
					                                                                                >
					                                                                                    Service Type:
					                                                                                </td>
					                                                                                <td
					                                                                                    class="td"
					                                                                                    style="
					                                                                                        color: #636363;
					                                                                                        border: 1px solid #e5e5e5;
					                                                                                        padding: 12px;
					                                                                                        text-align: left;
					                                                                                        vertical-align: middle;
					                                                                                        font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                    "
					                                                                                >
					                                                                                    '.$service.'
					                                                                                </td>
					                                                                            </tr>
					                                                                        </tbody>
					                                                                        <tfoot>
					                                                                            <tr>
					                                                                                <th style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;">
					                                                                                    Package:
					                                                                                </th>
					                                                                                <td class="td" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left;">Packaged</td>
					                                                                            </tr>
					                                                                        </tfoot>
					                                                                    </table>
					                                                                </div>

					                                                                <table id="addresses" cellspacing="0" cellpadding="0" border="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding: 0;">
					                                                                    <tr>
					                                                                        <td valign="top" width="50%" style="text-align: left; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; border: 0; padding: 0;">
					                                                                            <h2
					                                                                                style="
					                                                                                    color: #96588a;
					                                                                                    display: block;
					                                                                                    font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                    font-size: 18px;
					                                                                                    font-weight: bold;
					                                                                                    line-height: 130%;
					                                                                                    margin: 0 0 18px;
					                                                                                    text-align: left;
					                                                                                "
					                                                                            >
					                                                                                Sender
					                                                                            </h2>

					                                                                            <address class="address" style="padding: 12px; color: #636363; border: 1px solid #e5e5e5;">
					                                                                                '.$sender.'<br />
					                                                                                '.$senderAdd.'
					                                                                            </address>
					                                                                        </td>
					                                                                        <td valign="top" width="50%" style="text-align: left; font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif; padding: 0;">
					                                                                            <h2
					                                                                                style="
					                                                                                    color: #96588a;
					                                                                                    display: block;
					                                                                                    font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                                    font-size: 18px;
					                                                                                    font-weight: bold;
					                                                                                    line-height: 130%;
					                                                                                    margin: 0 0 18px;
					                                                                                    text-align: left;
					                                                                                "
					                                                                            >
					                                                                                Receiver
					                                                                            </h2>

					                                                                            <address class="address" style="padding: 12px; color: #636363; border: 1px solid #e5e5e5;">
					                                                                                '.$receiver.'<br />
					                                                                                '.$receiverAdd.'
					                                                                            </address>
					                                                                        </td>
					                                                                    </tr>
					                                                                </table>
					                                                                <p style="margin: 0 0 16px;">
					                                                                    Thank you for choosing Sme Courier
					                                                                </p>
					                                                            </div>
					                                                        </td>
					                                                    </tr>
					                                                </table>
					                                                <!-- End Content -->
					                                            </td>
					                                        </tr>
					                                    </table>
					                                    <!-- End Body -->
					                                </td>
					                            </tr>
					                            <tr>
					                                <td align="center" valign="top">
					                                    <!-- Footer -->
					                                    <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
					                                        <tr>
					                                            <td valign="top" style="padding: 0; border-radius: 6px;">
					                                                <table border="0" cellpadding="10" cellspacing="0" width="100%">
					                                                    <tr>
					                                                        <td
					                                                            colspan="2"
					                                                            valign="middle"
					                                                            id="credit"
					                                                            style="
					                                                                border-radius: 6px;
					                                                                border: 0;
					                                                                color: #c09bb9;
					                                                                font-family: \'Helvetica Neue\', Helvetica, Roboto, Arial, sans-serif;
					                                                                font-size: 12px;
					                                                                line-height: 125%;
					                                                                text-align: center;
					                                                                padding: 0 48px 48px 48px;
					                                                            "
					                                                        >
					                                                            <p>© 2021. Sme Courier.</p>
					                                                        </td>
					                                                    </tr>
					                                                </table>
					                                            </td>
					                                        </tr>
					                                    </table>
					                                    <!-- End Footer -->
					                                </td>
					                            </tr>
					                        </table>
					                    </td>
					                </tr>
					            </table>
					        </div>
					    </body>
					</html>
				';

				//Notify Receiver
	    		require '../vendor/autoload.php';

	    		$mail = new PHPMailer(true);                             
			    try {
			        //Server settings
			        $mail->isSMTP();                                     
			        $mail->Host = getenv('MAIL_HOST');                 
			        $mail->SMTPAuth = true;                               
			       $mail->Username = getenv('MAIL_USERNAME');    
			       $mail->Password = getenv('MAIL_PASSWORD');                  
			        $mail->SMTPOptions = array(
			            'ssl' => array(
			            'verify_peer' => false,
			            'verify_peer_name' => false,
			            'allow_self_signed' => true
			            )
			        );                         
			        $mail->SMTPSecure = 'ssl';                           
			        $mail->Port = 465;                                   

			        $mail->setFrom('support@komerec.com');
			        
			        //Recipients
			        $mail->addAddress($email);              
			        $mail->addReplyTo('info@komerec.com');
			       
			        //Content
			        $mail->isHTML(true);                                  
			        $mail->Subject = 'Sme Courier Shipment !';
			        $mail->Body    = $message;

			        $mail->send();
			    }
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
				}


				$_SESSION['success'] = 'Shipment added successfully';



			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up tracking form first';
	}

	header('location: tracking.php');

?>