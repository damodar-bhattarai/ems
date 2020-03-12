<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
    
    <title><?php echo $title; ?></title>

    <?= link_tag('assets/css/alertify.min.css') ?>


    <!-- offline bootstrap -->
   <?= link_tag('assets/css/bootstrap.min.css') ?>

  <!-- offline jquery -->
   <script type="text/javascript" src="<?= base_url('assets/js/jquery-3.4.1.js') ?>"></script>

    <!-- Stylesheets -->
        <?= link_tag('assets/css/all.css') ?>
         <?= link_tag('assets/css/fontawesome.min.css') ?>


    <?= link_tag('assets/css/ems.css?version=51') ?>
   

    <!-- Script Files -->

<!-- offline file bootstrap js -->
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>



<!-- offline file bootstrap js -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery-3.3.1.slim.min.js') ?>"></script>

<!-- offline file bootstrap js -->
<script type="text/javascript" src="<?= base_url('assets/js/popper.min.js') ?>"></script>


 <script type="text/javascript" src="<?= base_url('assets/js/ems.js') ?>"></script>



<!-- for datatable -->
<!-- offline datatables css -->
 <?= link_tag('assets/css/datatables.min.css') ?>
 <script type="text/javascript" src="<?= base_url('assets/js/datatables.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/css/fstdropdown.css') ?> ">



</head>

<body>
  <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="<?= base_url('admin'); ?>">Logo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('admin'); ?>">
          <i class="fa fa-home"></i>
          Home
          <span class="sr-only">(current)</span>
          </a>
      </li> -->
     <!--  <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fa fa-envelope-o">
            <span class="badge badge-danger">11</span>
          </i>
          Link
        </a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link disabled" href="#">
          <i class="fa fa-envelope-o">
            <span class="badge badge-warning">11</span>
          </i>
          Disabled
        </a>
      </li> -->

      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-envelope-o">
            <span class="badge badge-primary">11</span>
          </i>
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin'); ?>/employee_manage" title="To add new staff">
          <i class="fa fa-user-plus" aria-hidden="true"></i>
          Add Staff
        </a>
      </li>

      <!-- add leave and package -->

       <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin'); ?>/leave_manage" title="To manage leave type and packages">
          <i class="fa fa-calendar-check" aria-hidden="true"></i>
          Leaves
        </a>
      </li>

      <!-- mail group -->
       <li class="nav-item">
          
         <a class="nav-link" href="<?= base_url('admin'); ?>/mailgroup" title="List of emails to send leave list everyday.">
          <i class="fa fa-envelope" aria-hidden="true"></i>
           Mail Group
        </a>
      </li>



    </ul>
    <ul class="navbar-nav">
      <!-- <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin'); ?>/manage_employee">
          <i class="fa fa-plus" aria-hidden="true"></i>
          Add Staff
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fa fa-bell">
            <span class="badge badge-info">11</span>
          </i>
          Test
        </a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fa fa-globe">
            <span class="badge badge-success">11</span>
          </i>
          Test
        </a>
      </li> -->
    </ul>
    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
    <div class="drop-down-item" id="show-profile">
      <div class="pro-file">

         <span><strong>Administrator</strong></span>
        <img src="<?= base_url(); ?>/assets/images/images.jpg" onclick="displayFunctionType();">
       
        <!-- <i class="fa fa-caret-down" aria-hidden="true"></i> -->
      </div>
      <div class="drop-down">
        <ul>
          <li><a href="<?= base_url('admin'); ?>/employee_detail/<?php echo $_SESSION['user_id'];?>"><i class="fa fa-address-card" aria-hidden="true"></i> &nbsp;&nbsp; My Profile</a></li>
             <li><a href="<?= base_url('admin'); ?>/employee_manage/<?php echo $_SESSION['user_id'];?>"><i class="fa fa-edit" aria-hidden="true"></i> &nbsp;&nbsp; Edit Profile</a></li>
          <li><a href="<?= base_url('admin'); ?>/employee_manage"><i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;&nbsp; Add Staff</a></li>
      <li><a href="<?= base_url('changePassword'); ?>"><i class="fa fa-edit" title="logout"></i> &nbsp;&nbsp; Change Password</a></li>
          <li><a href="<?= base_url('logout'); ?>"><i class="fa fa-power-off" title="logout"></i> &nbsp;&nbsp; Logout</a></li>
        </ul>
      </div>
    </div>

    
    <!-- <div class="log-out">
      <a href="<?= base_url('logout'); ?>">
        <i class="fa fa-power-off" title="logout"></i>
      </a>
    </div> -->


  </div>
</nav>
<div class="page-wrapper chiller-theme">
  <a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
    <i class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">

        <a href="#">EMS</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="<?= base_url(); ?>/assets/images/images.jpg"
            alt="User picture">
        </div>
        <div class="user-info">
          <span class="user-name">
            <strong>Administrator</strong>
          </span>
          <span class="user-role">Administrator</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      <!-- <div class="sidebar-search">
        <div>
          <div class="input-group">
            <input type="text" class="form-control search-menu" placeholder="Search...">
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="fa fa-search" aria-hidden="true"></i>
              </span>
            </div>
          </div>
        </div>
      </div> -->
      <!-- sidebar-search  -->
      <div class="sidebar-menu">

        <ul>
          <li class="header-menu">
            <span>Profile</span>
          </li>
          <li>
         <a href="<?= base_url('admin'); ?>/employee_detail/<?php echo $_SESSION['user_id'];?>"><i class="fa fa-address-card" aria-hidden="true"></i>
              <span>My Profile</span>
            </a>
          </li>
        </ul>

        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
          <li>
          <a href="<?= site_url(); ?>">
              <i class="fa fa-home" aria-hidden="true"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li>
            <a href="<?= site_url('admin/employee_manage'); ?>">
              <i class="fa fa-user-plus" aria-hidden="true"></i>
              <span>Add Staff</span>
            </a>
          </li>
          <li>
            <a href="<?= site_url('admin/employee_list'); ?>">
              <i class="fa fa-users" aria-hidden="true" style="font-size: 0.9em;"></i>
              <span>Employee List</span>
            </a>
          </li>
          <li>
            <a href="<?= site_url('admin/employee_list'); ?>">
              <i class="fas fa-edit" aria-hidden="true"></i>
              <span>Assign Employee</span>
            </a>
          </li>

         <!--  <li class="sidebar-dropdown">
          <a href="#">
              <i class="fa fa-tachometer-alt"></i>
              <span>Home Page</span>
              <span class="badge badge-pill badge-warning">New</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Home Page 1
                    <span class="badge badge-pill badge-success">Pro</span>
                  </a>
                </li>
                <li>
                  <a href="#">Home Page 2</a>
                </li>
                <li>
                  <a href="#">Home Page 3</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-shopping-cart"></i>
              <span>E-commerce</span>
              <span class="badge badge-pill badge-danger">3</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Products

                  </a>
                </li>
                <li>
                  <a href="#">Orders</a>
                </li>
                <li>
                  <a href="#">Credit cart</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="far fa-gem"></i>
              <span>Components</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">General</a>
                </li>
                <li>
                  <a href="#">Panels</a>
                </li>
                <li>
                  <a href="#">Tables</a>
                </li>
                <li>
                  <a href="#">Icons</a>
                </li>
                <li>
                  <a href="#">Forms</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-chart-line"></i>
              <span>Charts</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Pie chart</a>
                </li>
                <li>
                  <a href="#">Line chart</a>
                </li>
                <li>
                  <a href="#">Bar chart</a>
                </li>
                <li>
                  <a href="#">Histogram</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Maps</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="header-menu">
            <span>Extra</span>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-book"></i>
              <span>Documentation</span>
              <span class="badge badge-pill badge-primary">Beta</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-calendar"></i>
              <span>Calendar</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-folder"></i>
              <span>Examples</span>
            </a>
          </li> -->
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <!-- <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a> -->
       <!-- <a href="<?= base_url('logout'); ?>">
        <i class="fa fa-power-off"></i>
      </a> -->
    </div>
  </nav>

  <!-- sidebar-wrapper  -->

  <!-- page-content-starts" -->


<!-- <li><a href="<?php echo base_url(); ?>">Home</a></li> -->
