<?php
    include('inc/config.php');
    include 'admin/includes/slugify.php';

    include 'inc/session.php';
    $timestamp = time();

    if(isset($_POST['join'])){
        $profilepic = $_FILES['profilepic']['name'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $full_name = $firstname." ".$lastname;
        $slug = slugify($full_name)."".$timestamp;
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $career_path = $_POST['career_path'];
        $town_city = $_POST['town_city'];
        $postcode = $_POST['postcode'];
        $poa = $_FILES['poa']['name'];
        $cv = $_FILES['cv']['name'];
        $passport = $_FILES['passport']['name'];
        $passport_issue_date = $_POST['passport_issue_date'];
        $passport_expiry_date = $_POST['passport_expiry_date'];
        $dbs = $_FILES['dbs']['name'];
        $dbs_issue_date = $_POST['dbs_issue_date'];
        $dbs_expiry_date = $_POST['dbs_expiry_date'];
        $share_code = $_FILES['share_code']['name'];
        $share_code_issue_date = $_POST['share_code_issue_date'];
        $share_code_expiry_date = $_POST['share_code_expiry_date'];
        $training_cert = $_FILES['training_cert']['name'];
        $training_cert_issue_date = $_POST['training_cert_issue_date'];
        $training_cert_expiry_date = $_POST['training_cert_expiry_date'];

        $_SESSION['lastname'] = $lastname;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['email'] = $email;
        
        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch();
        if($row['numrows'] > 0){
            $_SESSION['error'] = 'You are already in our database, proceed to login';
            header('location: register');
        }

        else{
            $now = date('Y-m-d');

            $six_months_plus_now = date('Y-m-d', strtotime('+6 months', strtotime($now)));

            $time_now = date('Y-m-d h:i A');

            //generate code
            $set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code=substr(str_shuffle($set), 0, 12);

            //generate code
            $pass_set='123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $password_plain=substr(str_shuffle($pass_set), 0, 8);

            $password = password_hash($password_plain, PASSWORD_DEFAULT);

            $username_set='123456789';
            $username_first = substr(slugify($firstname), 0, 3);
            $username_last = substr(slugify($lastname), 0, 3);
            $username_num = substr(str_shuffle($username_set), 0, 4);
            $username = $username_first."".$username_last."".$username_num;

            try{
                $profilepicext = pathinfo($profilepic, PATHINFO_EXTENSION);
                $profilepicfilename = 'profilepic'.$slug;
                $new_profilepicfilename = $profilepicfilename.'.'.$profilepicext;
                move_uploaded_file($_FILES['profilepic']['tmp_name'], 'admin/uploads/'.$new_profilepicfilename);

                $stmt = $conn->prepare("INSERT INTO users (full_name, firstname, lastname, email, uname, password, phone_no, gender, address, town_city, postcode, career_path, photo, activate_code, created_on) VALUES (:full_name, :firstname, :lastname, :email, :uname, :password, :phone_number, :gender, :address, :town_city, :postcode, :career_path, :photo, :code, :now)");
                $stmt->execute(['full_name'=>$full_name, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'uname'=>$username, 'password'=>$password, 'phone_number'=>$phone_number, 'gender'=>$gender, 'address'=>$address, 'town_city'=>$town_city, 'postcode'=>$postcode, 'career_path'=>$career_path, 'photo'=>$new_profilepicfilename, 'code'=>$code, 'now'=>$now]);
                $userid = $conn->lastInsertId();

                $poaext = pathinfo($poa, PATHINFO_EXTENSION);
                $poafilename = 'poa'.$slug;
                $new_poafilename = $poafilename.'.'.$poaext;
                move_uploaded_file($_FILES['poa']['tmp_name'], 'admin/uploads/'.$new_poafilename);

                $poastmt = $conn->prepare("INSERT INTO documents (user_id, file_id, file_name, date_requested, date_submitted, date_expiring, date_issued, file_status) VALUES (:user_id, :file_id, :file_name, :date_requested, :date_submitted, :date_expiring, :date_issued, :file_status)");
                $poastmt->execute(['user_id'=>$userid, 'file_id'=>19, 'file_name'=>$new_poafilename, 'date_requested'=>$time_now, 'date_submitted'=>$time_now, 'date_expiring'=>$six_months_plus_now, 'date_issued'=>$now, 'file_status'=>'submitted']);

                $cvext = pathinfo($cv, PATHINFO_EXTENSION);
                $cvfilename = 'cv'.$slug;
                $new_cvfilename = $cvfilename.'.'.$cvext;
                move_uploaded_file($_FILES['cv']['tmp_name'], 'admin/uploads/'.$new_cvfilename);

                $cvstmt = $conn->prepare("INSERT INTO documents (user_id, file_id, file_name, date_requested, date_submitted, date_expiring, date_issued, file_status) VALUES (:user_id, :file_id, :file_name, :date_requested, :date_submitted, :date_expiring, :date_issued, :file_status)");
                $cvstmt->execute(['user_id'=>$userid, 'file_id'=>20, 'file_name'=>$new_cvfilename, 'date_requested'=>$time_now, 'date_submitted'=>$time_now, 'date_expiring'=>NULL, 'date_issued'=>NULL, 'file_status'=>'submitted']);

                $passportext = pathinfo($passport, PATHINFO_EXTENSION);
                $passportfilename = 'passport'.$slug;
                $new_passportfilename = $passportfilename.'.'.$passportext;
                move_uploaded_file($_FILES['passport']['tmp_name'], 'admin/uploads/'.$new_passportfilename);

                $passportstmt = $conn->prepare("INSERT INTO documents (user_id, file_id, file_name, date_requested, date_submitted, date_expiring, date_issued, file_status) VALUES (:user_id, :file_id, :file_name, :date_requested, :date_submitted, :date_expiring, :date_issued, :file_status)");
                $passportstmt->execute(['user_id'=>$userid, 'file_id'=>18, 'file_name'=>$new_passportfilename, 'date_requested'=>$time_now, 'date_submitted'=>$time_now, 'date_expiring'=>$passport_expiry_date, 'date_issued'=>$passport_issue_date, 'file_status'=>'submitted']);

                $dbsext = pathinfo($dbs, PATHINFO_EXTENSION);
                $dbsfilename = 'dbs'.$slug;
                $new_dbsfilename = $dbsfilename.'.'.$dbsext;
                move_uploaded_file($_FILES['dbs']['tmp_name'], 'admin/uploads/'.$new_dbsfilename);

                $dbsstmt = $conn->prepare("INSERT INTO documents (user_id, file_id, file_name, date_requested, date_submitted, date_expiring, date_issued, file_status) VALUES (:user_id, :file_id, :file_name, :date_requested, :date_submitted, :date_expiring, :date_issued, :file_status)");
                $dbsstmt->execute(['user_id'=>$userid, 'file_id'=>18, 'file_name'=>$new_dbsfilename, 'date_requested'=>$time_now, 'date_submitted'=>$time_now, 'date_expiring'=>$dbs_expiry_date, 'date_issued'=>$dbs_issue_date, 'file_status'=>'submitted']);

                $share_codeext = pathinfo($share_code, PATHINFO_EXTENSION);
                $share_codefilename = 'share_code'.$slug;
                $new_share_codefilename = $share_codefilename.'.'.$share_codeext;
                move_uploaded_file($_FILES['share_code']['tmp_name'], 'admin/uploads/'.$new_share_codefilename);

                $share_codestmt = $conn->prepare("INSERT INTO documents (user_id, file_id, file_name, date_requested, date_submitted, date_expiring, date_issued, file_status) VALUES (:user_id, :file_id, :file_name, :date_requested, :date_submitted, :date_expiring, :date_issued, :file_status)");
                $share_codestmt->execute(['user_id'=>$userid, 'file_id'=>18, 'file_name'=>$new_share_codefilename, 'date_requested'=>$time_now, 'date_submitted'=>$time_now, 'date_expiring'=>$share_code_expiry_date, 'date_issued'=>$share_code_issue_date, 'file_status'=>'submitted']);

                $training_certext = pathinfo($training_cert, PATHINFO_EXTENSION);
                $training_certfilename = 'training_cert'.$slug;
                $new_training_certfilename = $training_certfilename.'.'.$training_certext;
                move_uploaded_file($_FILES['training_cert']['tmp_name'], 'admin/uploads/'.$new_training_certfilename);

                $training_certstmt = $conn->prepare("INSERT INTO documents (user_id, file_id, file_name, date_requested, date_submitted, date_expiring, date_issued, file_status) VALUES (:user_id, :file_id, :file_name, :date_requested, :date_submitted, :date_expiring, :date_issued, :file_status)");
                $training_certstmt->execute(['user_id'=>$userid, 'file_id'=>18, 'file_name'=>$new_training_certfilename, 'date_requested'=>$time_now, 'date_submitted'=>$time_now, 'date_expiring'=>$training_cert_expiry_date, 'date_issued'=>$training_cert_issue_date, 'file_status'=>'submitted']);

                $message = "
                    <div id='_rc_sig'>
                        <div id=':or' class='ii gt'>
                            <div id=':oq' class='a3s aiL msg4873022159957722792'>
                                <div id='m_4873022159957722792body' class='m_4873022159957722792body' style='background-color: #f3f2f1; margin: 0; padding: 0;'>
                                    <div style='font-family: Helvetica Neue, Helvetica, Roboto, Arial, sans-serif; direction: ltr;'>
                                        <table class='m_4873022159957722792main' border='0' width='100%' cellspacing='0' cellpadding='0' bgcolor='#F3F2F1'>
                                            <tbody>
                                                <tr>
                                                    <td class='m_4873022159957722792outer-box' style='padding: 0 8px;' align='center' bgcolor='#F3F2F1'>
                                                        <table style='max-width: 600px; padding: 0 0 15px 0;' border='0' width='100%' cellspacing='0' cellpadding='0'>
                                                            <tbody>
                                                                <tr>
                                                                    <td style='padding: 10px 0 13px 0;' align='left'>
                                                                        <a href='https://www.komerec.com'>
                                                                            <img
                                                                                class='m_4873022159957722792jecl-Icon-img CToWUd'
                                                                                style='display: block;'
                                                                                src='https://www.komerec.com/assets/img/logo/logo-black.png'
                                                                                alt='komecare-logo'
                                                                                width='200'
                                                                                height='52'
                                                                                border='0'
                                                                            />
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class='m_4873022159957722792width-600' style='max-width: 600px;' border='0' width='100%' cellspacing='0' cellpadding='0' bgcolor='#FFFFFF'>
                                                            <tbody>
                                                                <tr>
                                                                    <td class='m_4873022159957722792content-box' style='padding-bottom: 24px !important;'>
                                                                        <table border='0' width='100%' cellspacing='0' cellpadding='0'>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table border='0' width='100%' cellspacing='0' cellpadding='0'>
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style='padding: 16px 10px 0;'>
                                                                                                        <p style='font-size: 13px; line-height: 20px; color: #666666; margin: 0px; text-align: left;' align='center'>
                                                                                                            <span style='font-size: 12pt; font-family: arial black, sans-serif; color: #000000;'> <strong>Dear ".$firstname." ".$lastname.",</strong> </span>
                                                                                                        </p>
                                                                                                        <p style='font-size: 13px; line-height: 20px; color: #666666; margin: 0px; text-align: left;' align='center'>&nbsp;</p>
                                                                                                        <p style='font-size: 13px; line-height: 20px; color: #666666; margin: 0px; text-align: left;' align='center'>
                                                                                                            <span style='color: #000000;'>
                                                                                                                Thank you for your starting your onboarding process, please <a href='https://komerec.com/activate.php?code=".$code."&user=".$userid."'>Click Here</a> to activate your account.
                                                                                                            </span>
                                                                                                        </p>
                                                                                                        <p style='font-size: 13px; line-height: 20px; color: #666666; margin: 0px; text-align: left;' align='center'>
                                                                                                            <span style='color: #000000;'>
                                                                                                                Username: ".$username." <br/>
                                                                                                                Password: ".$password_plain."
                                                                                                            </span>
                                                                                                        </p>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table style='max-width: 550px; height: 264px; width: 114.979%;' border='0' width='573' cellspacing='0' cellpadding='0' bgcolor='#F2F2F2'>
                                                            <tbody>
                                                                <tr>
                                                                    <td style='padding: 24px 4px; width: 100%;'>
                                                                        <table style='max-width: 424px;' border='0' cellspacing='0' cellpadding='0' align='center'>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style='font-size: 12px; line-height: 16px; color: #4b4b4b; padding: 20px 0; margin: 0 auto;' align='center'>
                                                                                        *This email account is not monitored. Reply to <a href='mailto:info@komerec.com'>info@komerec.com</a> if you have any query.
                                                                                        
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table style='font-size: 12px; color: #2d2d2d; line-height: 22px; margin: 0px auto; height: 63px; width: 69.7305%;' border='0' width='100%' cellspacing='0' cellpadding='0' align='center'>
                                                                            <tbody>
                                                                                <tr style='height: 43px;'>
                                                                                    <td lang='en' style='padding: 0px; height: 43px;' align='center'>&copy; 2024 Kome Care Limited.</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ";


                //Notify Admin

                $msg = $lastname." ".$firstname." from ".$town_city." just registered, Log into the admin cennter to review and take necessary actions";

                // use wordwrap() if lines are longer than 70 characters
                $msg = wordwrap($msg,70);

                // send email
                mail($settings->email,"New Registrant Alert",$msg);

                try {
                    $to = $email;
                    $subject = $settings->siteTitle." Onboarding";

                    // Set content-type for KomeCare
                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                    // Additional headers
                    $headers .= 'From: '.$settings->siteTitle.' <noreply@'.$sweet_url.'>' . "\r\n";

                    // Send the email
                    mail($to, $subject, $message, $headers);

                    unset($_SESSION['firstname']);
                    unset($_SESSION['lastname']);
                    unset($_SESSION['email']);

                    $_SESSION['success'] = 'You information has been sent please check your email to activate your account and login, <a href="/">Click Here</a>';
                    header('location: register.php');

                } 
                catch (Exception $e) {
                    $_SESSION['success'] = 'You application has been sent and you will be contacted shortly.';
                    header('location: register.php');
                }


            }
            catch(PDOException $e){
                $_SESSION['success'] = $e->getMessage();
                header('location: register.php');
            }
            $pdo->close();

        }        

    }
    else{
        $_SESSION['error'] = 'Enter all required details first';
        header('location: register.php');
    }

?>