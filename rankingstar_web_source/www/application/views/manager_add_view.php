<?php include "includes/header.php"?>
<title><?php echo lang('LBL_ADD_ADMIN_MANAGER'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('LBL_ADD_ADMIN_MANAGER'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "MANAGER"; ?>"><?php echo lang('ADMIN_MANAGER_MANAGEMENT'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('LBL_ADD_ADMIN_MANAGER'); ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- <div class="col-3"></div> -->
        <div class="col-6">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <?php if(!empty($this->session->flashdata('error'))): ?>
              <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> <?php echo lang('LBL_ERROR');?></h5>
                  <?php echo $this->session->flashdata('error');?>
               </div>
              <?php endif;?>
              <?php 
                $attr = array('id'=>'addUser');
                echo form_open(BASE_URL.'manager/adduser', $attr);
              ?>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="name"><?php echo lang('LBL_NAME');?></label>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo set_value('name', ''); ?>">
                  </div>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email"><?php echo lang('LBL_EMAIL');?></label>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <input class="form-control" type="text" name="email" id="email" value="<?php echo set_value('email', ''); ?>">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="phone"><?php echo lang('LBL_PHONE');?></label>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <input class="form-control" type="text" name="phone" id="phone" value="<?php echo set_value('phone', ''); ?>">
                  </div>
                </div>
              </div>

              <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_type"><?php echo lang('USER_TYPE');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <select class="form-control select2" name="user_type">
                                <option value="manager"><?php echo lang("MANAGER") ?></option>
                                <option value="admin"><?php echo lang("ADMIN") ?></option>
                            </select>
                        </div>
                    </div>
                </div>
<!-- 
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="nick_name"><?php echo lang('LBL_NICK_NAME');?></label>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <input class="form-control" type="text" name="nick_name" id="nick_name" value="<?php echo set_value('nick_name', ''); ?>">
                  </div>
                </div>
              </div> -->

              <div class="row">
                <div class="col-md-5">
                </div>
                <div class="col-md-7">
                  <input type="submit" class="btn btn-primary" name="submit" value="<?php echo lang('BTN_ADD_MANAGER_ADMIN'); ?>">
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <?php echo form_close(); ?>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php include "includes/footer.php"?>
<script type="text/javascript">
    $(document).ready(function(){
    });

</script>


