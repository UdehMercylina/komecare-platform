<?php
    include 'inc/session.php';

    $errors = [];
    $success = [];
    if(isset($_POST['submit_file'])){
        $user_id = $_POST['user_id'];
        $file_name = $_POST['file_name'];

        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id'=>$user_id]);
        $row = $stmt->fetch();
        $worker_name = $row['full_name'];

        if (!empty($_FILES['identity_file'])) {
        
        $total = count($_FILES['identity_file']['name']);
        for( $i=0 ; $i < $total ; $i++ ) {
                
            $filename = $_FILES['identity_file']['name'][$i];
            $filesize = $_FILES['identity_file']['size'][$i];
            $filetype = $_FILES['identity_file']['type'][$i];
            $location = $_FILES['identity_file']['tmp_name'][$i];
            $error = $_FILES['identity_file']['error'][$i];



            $whitelist = ['jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'pdf', 'epub'];
            $max_size = 2045242880;

            $extension = explode('.', $filename);

            if (!in_array(strtolower(end($extension)), $whitelist)) {
                array_push($errors, "Format Not Supported");
                
            } else {
                if ($filesize > $max_size) {
                    array_push($errors,"File too large");
                } else {
                    if ($error !== 0) {
                        array_push($errors,"Something went wrong while uploading your file try again later");
                    } else {
                        // $filename=uniqid($extension[0]).$extension[1];
                        $originalName = $extension[0];
                        $newName = uniqid($originalName);
                        $fileName = $newName . '.' . end($extension);
                        if (!$fileName || empty($fileName)) {
                            array_push($errors,"Unknown Error Occured try again later");
                        } else {

                            if (move_uploaded_file($location, '../images/' . $fileName)) {
                                $stmt = $conn->prepare("INSERT INTO identity_verification_file (user_id, id_verification_file_name, id_verification_file) VALUES (:user_id, :file_name, :fileName)");
                                $stmt->execute(['user_id'=>$user_id, 'file_name'=>$file_name, 'fileName'=>$fileName]);

                                array_push($success, $fileName);

                                //Notify Admin

                                $msg = $worker_name." just submitted verification file. Login to your admin panel and navigate to view full user profile to see files";

                                // use wordwrap() if lines are longer than 70 characters
                                $msg = wordwrap(); //$msg = wordwrap($msg,70)

                                // send email
                                mail(getenv('MAIL_ADMIN'),"New Identity Verification Alert",$msg);

                            } else {
                                array_push($errors, "Could not upload your file. please try again later");
                            }
                        }
                    }
                }
            }

        }
    }
        $_SESSION['success'] = 'Identity Verification Document submitted successfully and is pending approval';        

        $pdo->close();
    }
    else{
        $_SESSION['error'] = 'Select a file to submit';
    }

    header('location: '. $_SERVER['HTTP_REFERER']);

?>