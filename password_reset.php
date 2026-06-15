<?php
    include('inc/config.php');
    include('inc/session.php');
    if(isset($_SESSION['stakeholder'])){
      header('location: user_stakeholder/dashboard');
    }

    if(isset($_SESSION['staff'])){
      header('location: user_staff/dashboard');
    }

    if(isset($_SESSION['onboardee'])){
      header('location: user_onboarding/dashboard');
    }

    include('admin/includes/format.php');

    $page_name = 'Password Reset';
    $page_tagline = 'Change Password';
    $page_title = 'Welcome to the Official Website of '.$settings->siteTitle;
    $page_description = $settings->siteDescription;
    include('inc/head.php');

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

                                    <h2 class="title-3"> Password Reset</h2>
                                    <p> Enter your new password! </p>  

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
                                        <form class="login" role="form" method="post" action="password_new.php?code=<?php echo $_GET['code']; ?>&user=<?php echo $_GET['user']; ?>">
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="Password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="repassword" placeholder="Retype Password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn-1 " type="submit" name="reset"> Reset Password </button>
                                            </div>
                                        </form>                            
                                    </div>                        
                                </div>
                            </div>    
                        </div>
                    </div>
                </section>
                <!-- /.Tracking -->

            </article>
            <!-- /.Content Wrapper -->


        </main>
        <!-- / Main Wrapper -->

        <!-- Scripts -->
        <?php include('inc/scripts.php');  ?>
        <!-- /Scripts -->

    </body>

</html>