

<div class="left-sidenav">
    <!-- LOGO -->
    <div class="brand">
        <a href="<?php echo $baseurl ?>" class="logo">
            <span>
                <img src="../assets/img/logo-dark.png" alt="Kome Care" class="logo-md">
            </span>
        </a>
    </div>
    <!--end logo-->
    <div class="menu-content h-100" data-simplebar>
        <ul class="metismenu left-sidenav-menu">
            <li class="menu-label mt-0">Main</li>
            <li>
                <a href="dashboard"> <i data-feather="home" class="align-self-center menu-icon"></i><span>Dashboard</span></a>
            </li>

            <hr class="hr-dashed hr-menu">
            <li class="menu-label my-2">Info</li>

            <li class="mm-active">
                <a href="javascript: void(0);" aria-expanded="true"><i data-feather="bar-chart" class="align-self-center menu-icon"></i><span>Documents</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level mm-collapse mm-show" aria-expanded="false" style="">
                    <li class="nav-item"><a class="nav-link" href="documents_requested"><i class="ti-control-record"></i>Requested Documents</a></li>
                    <li class="nav-item"><a class="nav-link" href="documents_submitted"><i class="ti-control-record"></i>Submitted Documents</a></li>
                </ul>
            </li>

            <li>
                <a href="messages"><i data-feather="inbox" class="align-self-center menu-icon"></i><span>Inbox</span></a>
            </li>


            <hr class="hr-dashed hr-menu">
            <li class="menu-label my-2">Account & Settings</li>


            <li>
                <a href="profile"><i data-feather="user" class="align-self-center menu-icon"></i><span>Profile</span></a>
            </li>


            <li>
                <a href="password-update"><i data-feather="lock" class="align-self-center menu-icon"></i><span>Change Password</span></a>
            </li>       


            <li>
                <a href="../contact"><i data-feather="life-buoy" class="align-self-center menu-icon"></i><span>Support</span></a>
            </li>


            <li>
                <a href="logout_action"><i data-feather="log-out" class="align-self-center menu-icon"></i><span>Logout</span></a>
            </li>
        </ul>

        <div class="update-msg text-center">
            <h5 class="mt-3"><?php echo $settings->siteTitle; ?></h5>
            <p class="mb-3"><?php echo $settings->siteTagline; ?></p>
        </div>
    </div>
</div>