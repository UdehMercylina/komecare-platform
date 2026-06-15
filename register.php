<?php
    include('inc/config.php');
    include('inc/session.php');
    include('admin/includes/format.php');

    $page_name = 'Join Us';
    $page_tagline = 'Start Your Journey';
    $page_title = 'Welcome to the Official Website of '.$settings->siteTitle;
    $page_description = $settings->siteDescription;
    include('inc/head.php');

?>
    <body id="home">

        <!-- Main Wrapper -->        
        <main class="wrapper auth-bg">

            <!-- Content Wrapper -->
            <article>

                <!-- register  -->
                <section class="contact-page pad-30">                    
                    <div class="theme-container container">               
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 contact-form king-form">
                                <div class="login-wrap text-center">
                                    <img src="assets/img/logo-dark.png" height="50" class="logo-dark mx-auto" alt="">

                                    <h2 class="title-3"> Register </h2>
                                    <p> Enter your basic information </p>
                                </div>

                                <div class="calculate-form">

                                    <?php
                                        if(isset($_SESSION['error'])){
                                          echo "
                                            <div class='callout callout-danger text-center'>
                                              <p>".$_SESSION['error']."</p> 
                                            </div>
                                          ";
                                          unset($_SESSION['error']);
                                        }
                                        if(isset($_SESSION['success'])){
                                          echo "
                                            <div class='callout callout-success text-center'>
                                              <p>".$_SESSION['success']."</p> 
                                            </div>
                                          ";
                                          unset($_SESSION['success']);
                                        }
                                    ?>

                                    <form class="row" id="contact-form" method="post" action="join_helper.php"  enctype="multipart/form-data">


                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Profile Picture </label></div>
                                            <div class="col-sm-9"> <input type="file" name="profilepic" id="profilepic" class="form-control" required> </div>
                                        </div>

                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> First Name: </label></div>
                                            <div class="col-sm-9"> <input type="text" name="firstname" id="Name" required placeholder="Enter Your First Name" class="form-control"> </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Last Name: </label></div>
                                            <div class="col-sm-9"> <input type="text" name="lastname" id="Name" required placeholder="Enter Your Last Name" class="form-control"> </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Email: </label></div>
                                            <div class="col-sm-9"> <input type="text" name="email" id="Email" required placeholder="Enter Your Accessible Email Address" class="form-control"> </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Phone Number: </label></div>
                                            <div class="col-sm-9"> <input type="text" name="phone_number" id="PhoneNumber" required placeholder="Enter Your Phone Number" class="form-control"> </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Gender: </label></div>
                                            <div class="col-sm-9"> 
                                                <select aria-required="true" class="form-control" aria-label="Gender" id="gender" name="gender" required>
            
                                                    <option value="" selected disabled>Select Your Gender*</option>
                                            
                                                    <option value="Male">Male</option>
                                            
                                                    <option value="Female">Female</option>
                                    
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Residential Address: </label></div>
                                            <div class="col-sm-9"> <input type="text" name="address" id="Address" required placeholder="Enter Your Full Residential Address" class="form-control"> </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Job Role: </label></div>
                                            <div class="col-sm-9"> <input type="text" name="career_path" id="career_path" required placeholder="Enter Your Job Role" class="form-control"> </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Town/City: </label></div>
                                            <div class="col-sm-3"> <input type="text" name="town_city" id="town_city" required placeholder="Enter Your Town or City" class="form-control"> </div>
                                            <div class="col-sm-3"> <label class="title-2"> Postcode: </label></div>
                                            <div class="col-sm-3"> <input type="text" name="postcode" id="postcode" required placeholder="Enter Your Postcode" class="form-control"> </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-3"> <label class="title-2"> Proof of address </label></div>
                                            <div class="col-sm-4"> <input type="file" name="poa" id="poa" class="form-control" required> </div>

                                            <div class="col-sm-1"> <label class="title-2"> CV </label></div>
                                            <div class="col-sm-4"> <input type="file" name="cv" id="cv" class="form-control" required> </div>
                                        </div>
                                        <div class="group-border">
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                                <div class="col-sm-3"> <label class="title-2"> Passport </label></div>
                                                <div class="col-sm-9"> <input type="file" name="passport" id="passport" class="form-control" required> </div>
                                            </div>
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">                                         
                                                <div class="col-sm-3"> <label class="title-2"> Issue Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="passport_issue_date" id="passport_issue_date"placeholder="Issue Date" class="form-control" required> </div>                                            
                                                <div class="col-sm-3"> <label class="title-2"> Expiry Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="passport_expiry_date" id="passport_expiry_date"placeholder="Expiry Date" class="form-control" required> </div>
                                            </div>
                                        </div>
                                        <div class="group-border">
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                                <div class="col-sm-3"> <label class="title-2"> DBS </label></div>
                                                <div class="col-sm-9"> <input type="file" name="dbs" id="dbs" class="form-control" required> </div>
                                            </div>
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">                                         
                                                <div class="col-sm-3"> <label class="title-2"> Issue Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="dbs_issue_date" id="dbs_issue_date"placeholder="Issue Date" class="form-control" required> </div>
                                                                                    
                                                <div class="col-sm-3"> <label class="title-2"> Expiry Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="dbs_expiry_date" id="dbs_expiry_date"placeholder="Expiry Date" class="form-control" required> </div>
                                            </div>
                                        </div>
                                        <div class="group-border">
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                                <div class="col-sm-3"> <label class="title-2"> Share code </label></div>
                                                <div class="col-sm-9"> <input type="file" name="share_code" id="share_code" class="form-control" required> </div>
                                            </div>
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">                                         
                                                <div class="col-sm-3"> <label class="title-2"> Issue Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="share_code_issue_date" id="share_code_issue_date"placeholder="Issue Date" class="form-control" required> </div>                                            
                                                <div class="col-sm-3"> <label class="title-2"> Expiry Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="share_code_expiry_date" id="share_code_expiry_date"placeholder="Expiry Date" class="form-control" required> </div>
                                            </div>
                                        </div>
                                        <div class="group-border">
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                                <div class="col-sm-3"> <label class="title-2"> Training certificate </label></div>
                                                <div class="col-sm-9"> <input type="file" name="training_cert" id="training_cert" class="form-control" required> </div>
                                            </div>
                                            <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">                                         
                                                <div class="col-sm-3"> <label class="title-2"> Issue Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="training_cert_issue_date" id="training_cert_issue_date"placeholder="Issue Date" class="form-control" required> </div>                                            
                                                <div class="col-sm-3"> <label class="title-2"> Expiry Date </label></div>
                                                <div class="col-sm-3"> <input type="date" name="training_cert_expiry_date" id="training_cert_expiry_date"placeholder="Expiry Date" class="form-control" required> </div>
                                            </div>
                                        </div>
                                        <div class="form-group wow fadeInUp" data-wow-offset="50" data-wow-delay=".30s">
                                            <div class="col-sm-9 col-xs-12 pull-right">
                                                <button type="submit" name="join" id="submit_btn" class="btn-1"> Apply </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /.register -->
                

            </article>
            <!-- /.Content Wrapper -->


        </main>
        <!-- / Main Wrapper -->

        <!-- Scripts -->
        <?php include('inc/scripts.php');  ?>
        <!-- /Scripts -->

    </body>
</html>