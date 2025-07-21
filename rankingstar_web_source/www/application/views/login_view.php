<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo lang('LBL_LOG_IN');?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo CON_DIST_PATH; ?>css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><?php echo lang('site_name_long') ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><?php echo lang('LBL_LOG_IN');?></p>
      <?php if ($this->session->flashdata('msg')) {?>
        <div class="alert alert-danger alert-dismissible"> <?php echo $this->session->flashdata('msg'); ?> </div>
      <?php }?>

      <form action="<?php echo BASE_URL . "login/userlogin"; ?>" method="post">
        <div class="input-group mb-3">
          <div class="col-sm-4"><?php echo lang('LBL_SELECT_AUTH'); ?></div>
          <div class="col-sm-8">
            <select name="user_type" class="form-control">
              <option value="admin"><?php echo lang('LBL_ADMIN');?></option>
              <option value="manager"><?php echo lang('LBL_MANAGER');?></option>
            </select>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-success btn-block "><?php echo lang('LBL_LOG_IN');?></button>
          </div>
        </div>
      </form>
      <div class="row mt-3">
      <!-- <div class="col-9"><a href="#" class="text-center">Forgot Password</a></div> -->
          <!-- <div class="col-3"><a href="register.html" class="text-center">Register</a></div> -->
      </div>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo CON_DIST_PATH; ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo CON_DIST_PATH; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo CON_DIST_PATH; ?>js/adminlte.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      localStorage.removeItem("active_menu");
      clearPageNO(); // clearing page no of user controller

    });
</script>
</body>
</html>
