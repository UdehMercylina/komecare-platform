<div class="modal fade hide" id="request" tabindex="-1" aria-labelledby="exampleModalDefaultLogin" aria-modal="true" role="dialog" style="display: block;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Submit File</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->
            <div class="modal-body">
                <div class="card-body p-0 auth-header-box">
                    <div class="text-center">
                        <a href="index.html" class="logo logo-admin">
                            <img src="assets/images/logo-sm.png" height="50" alt="logo" class="auth-logo">
                        </a>
                        <h4 class="mt-3 mb-1 fw-semibold font-18">Let's Get Started Maxdot</h4>   
                        <p class="text-muted  mb-0">Sign in to continue to Maxdot.</p>  
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav-border nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold active" data-bs-toggle="tab" href="#LogIn_Tab" role="tab" aria-selected="true">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" data-bs-toggle="tab" href="#Register_Tab" role="tab" aria-selected="false">Register</a>
                        </li>
                    </ul>
                     <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane p-3 active" id="LogIn_Tab" role="tabpanel">                                        
                            <form class="form-horizontal auth-form" action="index.html">

                                <div class="form-group mb-2">
                                    <label class="form-label" for="username">Username</label>
                                    <div class="input-group">                                                                                         
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                                    </div>                                    
                                </div><!--end form-group--> 
    
                                <div class="form-group mb-2">
                                    <label class="form-label" for="userpassword">Password</label>                                            
                                    <div class="input-group">                                  
                                        <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password">
                                    </div>                               
                                </div><!--end form-group--> 
    
                                <div class="form-group row my-3">
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-switch switch-success">
                                            <input type="checkbox" class="custom-control-input" id="customSwitchSuccess">
                                            <label class="form-label text-muted" for="customSwitchSuccess">Remember me</label>
                                        </div>
                                    </div><!--end col--> 
                                    <div class="col-sm-6 text-end">
                                        <a href="auth-recover-pw.html" class="text-muted font-13"><i class="dripicons-lock"></i> Forgot password?</a>                                    
                                    </div><!--end col--> 
                                </div><!--end form-group--> 
    
                                <div class="form-group mb-0 row">
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="button">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                    </div><!--end col--> 
                                </div> <!--end form-group-->                           
                            </form><!--end form-->
                            <div class="m-3 text-center text-muted">
                                <p class="mb-0">Don't have an account ?  <a href="auth-register.html" class="text-primary ms-2">Free Resister</a></p>
                            </div>
                            <div class="account-social">
                                <h6 class="mb-3">Or Login With</h6>
                            </div>
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Facebook</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Twitter</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Google</button>
                            </div>
                        </div>
                        <div class="tab-pane px-3 pt-3" id="Register_Tab" role="tabpanel">
                            <form class="form-horizontal auth-form" action="index.html">

                                <div class="form-group mb-2">
                                    <label class="form-label" for="username">Username</label>
                                    <div class="input-group">                                                                                         
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                                    </div>                                    
                                </div><!--end form-group--> 

                                <div class="form-group mb-2">
                                    <label class="form-label" for="useremail">Email</label>
                                    <div class="input-group">                                                                                         
                                        <input type="email" class="form-control" name="email" id="useremail" placeholder="Enter Email">
                                    </div>                                    
                                </div><!--end form-group-->
    
                                <div class="form-group mb-2">
                                    <label class="form-label" for="userpassword">Password</label>                                            
                                    <div class="input-group">                                  
                                        <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password">
                                    </div>                               
                                </div><!--end form-group--> 

                                <div class="form-group mb-2">
                                    <label class="form-label" for="conf_password">Confirm Password</label>                                            
                                    <div class="input-group">                                   
                                        <input type="password" class="form-control" name="conf-password" id="conf_password" placeholder="Enter Confirm Password">
                                    </div>
                                </div><!--end form-group-->
                                
                                <div class="form-group mb-2">
                                    <label class="form-label" for="mo_number">Mobile Number</label>                                            
                                    <div class="input-group">                                 
                                        <input type="text" class="form-control" name="mobile number" id="mo_number" placeholder="Enter Mobile Number">
                                    </div>                               
                                </div><!--end form-group-->  
    
                                <div class="form-group row my-3">
                                    <div class="col-sm-12">
                                        <div class="custom-control custom-switch switch-success">
                                            <input type="checkbox" class="custom-control-input" id="customSwitchSuccess2">
                                            <label class="form-label text-muted" for="customSwitchSuccess2">You agree to the Dastone <a href="#" class="text-primary">Terms of Use</a></label>
                                        </div>
                                    </div><!--end col-->                                             
                                </div><!--end form-group--> 
    
                                <div class="form-group mb-0 row">
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="button">Register <i class="fas fa-sign-in-alt ms-1"></i></button>
                                    </div><!--end col--> 
                                </div> <!--end form-group-->                           
                            </form><!--end form-->
                            <p class="my-3 text-muted">Already have an account ?<a href="auth-login.html" class="text-primary ms-2">Log in</a></p>                                                    
                        </div>
                    </div>
                </div><!--end card-body-->
                <div class="card-body bg-light-alt text-center">
                    <span class="text-muted d-none d-sm-inline-block">Mannatthemes © <script>
                        document.write(new Date().getFullYear())
                    </script>2024</span>                                            
                </div>                                                 
            </div><!--end modal-body-->
            
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div>