<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">REPORTS</li>
      <li><a href="home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li class="header">MANAGE</li>
      <?php if (in_array($admin["admin_role"], ["global", "onboarding"])) { ?>
        <li><a href="onboarding"><i class="fa fa-building"></i> <span>Onboarding</span></a></li>
      <?php } ?>

      <?php if (in_array($admin["admin_role"], ["global", "compliance"])) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-check-circle"></i>
            <span>Compliance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="documents_list"><i class="fa fa-file"></i> <span>Compliance Documents</span></a></li>
          </ul>
        </li>
      <?php } ?>

      <?php if (in_array($admin["admin_role"], ["global", "recruitment"])) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-plus"></i>
            <span>Recruitment</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="recruitment_unassigned_shifts"><i class="fa fa-tasks text-yellow"></i> <span>Unassigned Shifts</span></a></li>
            <li><a href="recruitment_active_shifts"><i class="fa fa-calendar text-blue"></i> <span>Active Shifts</span></a></li>
            <li><a href="recruitment_completed_shifts"><i class="fa fa-check-circle text-green"></i> <span>Completed Shifts</span></a></li>
            <li><a href="recruitment_candidate_availability"><i class="fa fa-calendar text-green"></i> <span>Candidates Availability</span></a></li>
          </ul>
        </li>
      <?php } ?>

      <?php if (in_array($admin["admin_role"], ["global", "finance"])) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Finance</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="requested_payments"><i class="fa fa-hand-paper-o"></i> <span>Requests</span></a></li>
            <li><a href="completed_payments"><i class="fa fa-history"></i> <span>History</span></a></li>
          </ul>
        </li>
      <?php } ?>

      <?php if (in_array($admin["admin_role"], ["global", "recruitment", "compliance"])) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Candidates</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="candidates_active"><i class="fa fa-users text-blue"></i> <span>Active Candidates</span></a></li>
            <?php if (in_array($admin["admin_role"], ["global", "recruitment"])) { ?>
              <li><a href="candidates_revoked"><i class="fa fa-users text-red"></i> <span>Revoked Candidates</span></a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if (in_array($admin["admin_role"], ["global", "recruitment", "compliance"])) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-handshake-o"></i>
            <span>Stakeholders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="stakeholders_active"><i class="fa fa-handshake-o text-blue"></i> <span>Active Stakeholders</span></a></li>
            <?php if (in_array($admin["admin_role"], ["global", "recruitment"])) { ?>
              <li><a href="stakeholders_revoked"><i class="fa fa-handshake-o text-red"></i> <span>Revoked Stakeholders</span></a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <!---
      <li><a href="jobs.php"><i class="fa fa-briefcase"></i> <span>Jobs</span></a></li>
      <li><a href="review.php"><i class="fa fa-registered"></i> <span>Reviews</span></a></li>
      <li><a href="users.php"><i class="fa fa-users"></i> <span>Workers</span></a></li>
      <li><a href="tracking.php"><i class="fa fa-truck"></i> <span>Tracking</span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-tasks"></i>
          <span>Tasks</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="taskmanagers.php"><i class="fa fa-male"></i> <span>Project Managers</span></a></li>
          <li><a href="taskassign.php"><i class="fa fa-ravelry"></i> <span>Assign Task</span></a></li>
          <li><a href="tasks.php"><i class="fa fa-tasks"></i> <span>All Tasks</span></a></li>
        </ul>
      </li>
      <li><a href="news.php"><i class="fa fa-newspaper-o"></i> <span>News</span></a></li>
      --->
      <li><a href="admin_roles"><i class="fa fa-map-signs"></i> <span>Role Assignment</span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-anchor"></i>
          <span>Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a data-toggle="modal" href="#profile" id="admin_profile"><i class="fa fa-cogs"></i> <span>Update Profile</span></a></li>
          <li><a href="logout"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>