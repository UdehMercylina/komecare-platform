<?php
    include 'inc/session.php';

    $errors = [];
    $success = [];
    if(isset($_POST['submit_file'])){
        $task_id = $_POST['task_id'];
        $file_name = $_POST['file_name'];

        $conn = $pdo->open();

        if (!empty($_FILES['task_file'])) {
        
        $total = count($_FILES['task_file']['name']);
        for( $i=0 ; $i < $total ; $i++ ) {
                
            $filename = $_FILES['task_file']['name'][$i];
            $filesize = $_FILES['task_file']['size'][$i];
            $filetype = $_FILES['task_file']['type'][$i];
            $location = $_FILES['task_file']['tmp_name'][$i];
            $error = $_FILES['task_file']['error'][$i];



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
                                $stmt = $conn->prepare("INSERT INTO task_submit_files (task_id, task_submit_file_name, task_submit_file) VALUES (:task_id, :file_name, :fileName)");
                                $stmt->execute(['task_id'=>$task_id, 'file_name'=>$file_name, 'fileName'=>$fileName]);

                                array_push($success, $fileName);
                            } else {
                                array_push($errors, "Could not upload your file. please try again later");
                            }
                        }
                    }
                }
            }

        }
    }
        $_SESSION['success'] = 'Task submitted successfully and is pending approval by your team leader';        

        $pdo->close();
    }
    else{
        $_SESSION['error'] = 'Select a file to submit';
    }

    header('location: '. $_SERVER['HTTP_REFERER']);

?>