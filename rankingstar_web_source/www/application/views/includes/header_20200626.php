<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Load CSS -->
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>fonts/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/ekko-lightbox/ekko-lightbox.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/jquery-confirm.min.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/tagify.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/custom.css">
    <link rel="stylesheet" href="<?php echo CON_DROPZONE_URL ?>dropzone.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH ?>css/loading.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH ?>css/bootstrap-multiselect.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/redactor/redactor.min.css">
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css">


    <!-- Load JS -->
    <script src="<?php echo CON_DIST_PATH ?>js/tagify.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>jquery/jquery.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/toastr/toastr.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>js/adminlte.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/datatables/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/ekko-lightbox/ekko-lightbox.min.js">
    <script src="<?php echo CON_DIST_PATH ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/summernote/summernote-bs4.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/select2/js/select2.full.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>js/jquery-confirm.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>js/jQuery.tagify.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo CON_DROPZONE_URL ?>dropzone.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>js/loading.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>js/bootstrap-multiselect.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/redactor/redactor.min.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/video/video.js"></script>
    <script src="<?php echo CON_DIST_PATH ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

    
</head>
<?php 
    $userData = $this->auth->getUserSession();
?>
<body class="hold-transition sidebar-mini" >
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-pink">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-pink elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BASE_URL."dashboard";?>" class="brand-link">
        <img src="<?php echo CON_DIST_PATH; ?>img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo lang('site_name_long') ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo CON_CONTESTANT_URL.$userData['main_image']; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $userData['name']; ?></a>
            </div>
        </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?php echo BASE_URL."dashboard";?>" id="dashboard" class="nav-link menu">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                <?php echo lang('DASHBOARD') ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo BASE_URL."contest";?>" id="contest" class="nav-link menu">
              <i class="nav-icon fas fa-table"></i>
              <p>
                <?php echo lang('CONTENT_MANAGEMENT') ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo BASE_URL."contestant";?>" id="contestant" class="nav-link menu">
              <i class="nav-icon fas fa-file"></i>
              <p>
                <?php echo lang('CONTESTANT_MANAGEMENT') ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?php echo BASE_URL."user";?>" id="user" class="nav-link menu">
              <i class="nav-icon fas fa-users"></i>
              <p>
                <?php echo lang('USER_MANAGEMENT') ?>
              </p>
            </a>
          </li>
            <li class="nav-item">
                <a href="<?php echo BASE_URL."sales";?>" id="sales" class="nav-link menu">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                    <?php echo lang('SALES_MANAGEMENT') ?>
                    </p>
                </a>
            </li>  
            <li class="nav-item">
                <a href="<?php echo BASE_URL."transaction";?>" id="transaction" class="nav-link menu">
                    <i class="nav-icon fas fa-chart-pie"></i>
                    <p>
                    <?php echo lang('TRANSACTION_MANAGEMENT') ?>
                    </p>
                </a>
            </li>          
            <!-- <li class="nav-item">
                <a href="<?php echo BASE_URL."advertise";?>" id="advertise" class="nav-link menu">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                    <?php echo lang('ADVERTISE_MANAGEMENT') ?>
                    </p>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="<?php echo BASE_URL."plans";?>" id="plans" class="nav-link menu">
                    <i class="nav-icon fas fa-map"></i>
                    <p>
                    <?php echo lang('PLANS') ?>
                    </p>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="<?php //echo BASE_URL."category";?>" id="category" class="nav-link menu">
                    <i class="nav-icon fab fa-buffer"></i>
                    <p>
                    <?php //echo lang('CATEGORY') ?>
                    </p>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="<?php echo BASE_URL."notice";?>" id="notice" class="nav-link menu">
                    <i class="nav-icon far fa-clipboard"></i>
                    <p>
                    <?php echo lang('NOTICE_BOARD') ?>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo BASE_URL."notification";?>" id="sendNotification" class="nav-link menu">
                    <i class="nav-icon far fa-bell"></i>
                    <p>
                    <?php echo lang('LBL_SEND_NOTIFICATION') ?>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#none" id="shoppingAdmin"  class="nav-link menu">
                    <i class="nav-icon fa fa-shopping-cart"></i>
                    <p>
                    쇼핑관리
                    </p>
                </a>
            </li>
            
            <form name="flogin" action="<?php echo CON_SHOPPING_PATH?>shopping/bbs/login_check.php"  method="post" id="flogin" target="_blank">
			<!-- <input type="hidden" name="url" value="http%3A%2F%2Frankingstar.cafe24.com%2Fshopping%2Fadm%2F"> -->
            <input type="hidden" name="url" value="http://ranking-star.com/shopping/adm/">
			<input type="hidden" name="mb_id" value="admin">
			<input type="hidden" name="mb_password" value="Test123!@#">
            </form>
            
            <script>
	         $(document).ready(function(){
		        $("#shoppingAdmin").click(function(e){
			        e.preventDefault();
			        $("#flogin").submit();
		        });
	         });
            </script>
            <li class="nav-item">
                <a href="<?php echo BASE_URL."login/logout";?>" id="logout" class="nav-link menu">
                    <i class="nav-icon far fa-circle text-danger"></i>
                    <p>
                    <?php echo lang('LOG_OUT') ?>
                    </p>
                </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>