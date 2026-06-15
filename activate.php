<?php
    include('inc/config.php');
    include('inc/session.php');

    include('admin/includes/format.php');

    $page_name = 'Activate';
    $page_tagline = 'Account Activation Page';
    $page_title = 'Welcome to the Official Website of '.$settings->siteTitle;
    $page_description = $settings->siteDescription;
    include('inc/head.php');

    $output = '';
    if (!isset($_GET['code'], $_GET['user'])){
        $output .= '
            <h1 class="font-size-sl-72 font-weight-light mb-3">Error!</h1>
            <p class="text-gray-90 font-size-20 mb-0 font-weight-light">Code to activate account not found. Please <a href="register">Register</a></p>
        '; 
    }
    else{
        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE activate_code=:code AND id=:id");
        $stmt->execute(['code'=>$_GET['code'], 'id'=>$_GET['user']]);
        $row = $stmt->fetch();

        if($row['numrows'] > 0){
            if($row['status']){
                $output .= '
                    <h1 class="font-size-sl-72 font-weight-light mb-3">Error!</h1>
                    <p class="text-gray-90 font-size-20 mb-0 font-weight-light">Account already activated. Please <a href="/">Login</a></p>
                ';
            }
            else{
                try{
                    $stmt = $conn->prepare("UPDATE users SET status=:status WHERE id=:id");
                    $stmt->execute(['status'=>1, 'id'=>$row['id']]);
                    $output .= '
                        <h1 class="font-size-sl-72 font-weight-light mb-3">Success!</h1>
                        <p class="text-gray-90 font-size-20 mb-0 font-weight-light">Account activated - Email: <b>'.$row['email'].'</b>. You may <a href="/">Login</a></p>
                    ';
                }
                catch(PDOException $e){
                    $output .= '
                        <h1 class="font-size-sl-72 font-weight-light mb-3">Error!</h1>
                        <p class="text-gray-90 font-size-20 mb-0 font-weight-light">'.$e->getMessage().' Please <a href="register">signup</a></p>
                    ';
                }

            }
            
        }
        else{
            $output .= '
                <h1 class="font-size-sl-72 font-weight-light mb-3">Error!</h1>
                <p class="text-gray-90 font-size-20 mb-0 font-weight-light">Cannot activate account. Wrong code. Please <a href="register">signup</a></p>
            ';
        }

        $pdo->close();
    }

?>
    <body id="home">

        <!-- Main Wrapper -->        
        <main class="wrapper auth-bg">

            <!-- Content Wrapper -->
            <article> 

                <!-- Login -->
                <section class="pt-50 pb-50 tracking-wrap">    
                    <div class="theme-container container ">  
                        <div class="row pad-10">
                            <div class="col-md-6 col-md-offset-3 king-form wow fadeInUp pb-50" data-wow-offset="50" data-wow-delay=".30s">
                                <div class="login-wrap text-center">
                                    <img src="assets/img/logo-dark.png" height="50" class="logo-dark mx-auto" alt="">

                                    <h2 class="title-3"> Activate Account </h2>

                                    <?php
                                        if(isset($_SESSION['error'])){
                                          echo "
                                            <div class='callout callout-danger text-center padding-top-10 padding-bottom-10'>
                                              <p>".$_SESSION['error']."</p> 
                                            </div>
                                          ";
                                          unset($_SESSION['error']);
                                        }
                                        if(isset($_SESSION['success'])){
                                          echo "
                                            <div class='callout callout-success text-center padding-top-10 padding-bottom-10'>
                                              <p>".$_SESSION['success']."</p> 
                                            </div>
                                          ";
                                          unset($_SESSION['success']);
                                        }
                                    ?>                      

                                    <div class="login-form clrbg-before">
                                        <?php echo $output; ?>                            
                                    </div>                        
                                </div>
                            </div>    
                        </div>
                    </div>
                </section>
                <!-- /.Activate -->

            </article>
            <!-- /.Content Wrapper -->


        </main>
        <!-- / Main Wrapper -->

        <!-- Scripts -->
        <?php include('inc/scripts.php');  ?>
        <!-- /Scripts -->

    </body>
</html>