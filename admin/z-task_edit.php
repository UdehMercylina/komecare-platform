<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	$errors = [];
    $success = [];

	if(isset($_POST['edit'])){
		$task_id = $_POST['task_id'];
		$pm_id = $_POST['pm_id'];
		$task_delegate_date = $_POST['task_delegate_date'];
		$task_submit_date = $_POST['task_submit_date'];
		$task_title = $_POST['task_title'];
		$slug = slugify($task_title);
		$task_description_summary = $_POST['task_description_summary'];
		$task_description = $_POST['task_description'];
		$task_status = $_POST['task_status'];

		if ($task_status == 'completed') {
			$task_completion_date = date('Y-m-d H:i:s');
		}else{
			$task_completion_date = NULL;
		}

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE task SET pm_id=:pm_id, task_delegate_date=:task_delegate_date, task_submit_date=:task_submit_date, task_completion_date=:task_completion_date, task_title=:task_title, task_description_summary=:task_description_summary, task_description=:task_description, task_status=:task_status WHERE task_id=:task_id");
			$stmt->execute(['pm_id'=>$pm_id, 'task_delegate_date'=>$task_delegate_date, 'task_submit_date'=>$task_submit_date, 'task_completion_date'=>$task_completion_date, 'task_title'=>$task_title, 'task_description_summary'=>$task_description_summary, 'task_description'=>$task_description, 'task_status'=>$task_status, 'task_id'=>$task_id]);
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		if (!empty($_FILES['task_file'])) {

			$task_file_name = $_POST['task_file_name'];

        
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

	                        $newfilename = 'edit'.$slug.'-'.$task_id.'-'.$i.'.'. end($extension);
	            			$filename = $newfilename;

	                        if (!$filename || empty($filename)) {
	                            array_push($errors,"Unknown Error Occured try again later");
	                        } else {

	                            if (move_uploaded_file($location, '../images/' . $filename)) {

						            if ($filesize < 1023) {
						                $filesize = $filesize.'B';
					                }elseif ($filesize < 1048575) {
					                	$filesize_calc = number_format($filesize / 1024, 1);
					                	$filesize = $filesize_calc.'KB';
					                }elseif ($filesize < 999999999) {
					                	$filesize_calc = number_format($filesize / 1048576, 1);
					                	$filesize = $filesize_calc.'MB';
					                }


	                                $stmt = $conn->prepare("INSERT INTO task_files (task_id, task_file_name, task_file, task_file_size) VALUES (:task_id, :file_name, :filename, :filesize)");
	                                $stmt->execute(['task_id'=>$task_id, 'file_name'=>$task_file_name, 'filename'=>$filename, 'filesize'=>$filesize]);

	                                array_push($success, $filename);
	                            } else {
	                                array_push($errors, "Could not upload your file. please try again later");
	                            }
	                        }
	                    }
	                }
	            }

	        }
	    }

	    $_SESSION['success'] = 'Task edited successfully';		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up task edit form first';
	}

	header('location: tasks.php');

?>