<?php include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('LBL_ADD_PLAN'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('LBL_ADD_PLAN'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "plans"; ?>"><?php echo lang('PLANS'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('LBL_ADD_PLAN'); ?></li>
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
                    $attr = array('id'=>'addPlan');
                    echo form_open(BASE_URL.'plans/addPlan', $attr);
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="plan_name"><?php echo lang('LBL_PLAN_NAME');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="plan_name" id="plan_name" value="<?php echo set_value('plan_name', ''); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="description"><?php echo lang('LBL_DESCRIPTION');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="description" id="description" value="<?php echo set_value('description', ''); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="price"><?php echo lang('LBL_PRICE');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="price" id="price" value="<?php echo set_value('price', ''); ?>">
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="star"><?php echo lang('LBL_STAR');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="star" id="star" value="<?php echo set_value('star', ''); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="extra_star"><?php echo lang('LBL_EXTRA_STAR');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="extra_star" id="extra_star" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status"><?php echo lang('LBL_PLAN_TYPE');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <select class="form-control select2" name="plan_type">
                                <option value="Android"><?php echo lang("LBL_ANDROID") ?></option>
                                <option value="iOS"><?php echo lang("LBL_IOS") ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status"><?php echo lang('LBL_STATUS');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <select class="form-control select2" name="status">
                                <option value="active"><?php echo lang("LBL_ACTIVE") ?></option>
                                <option value="deactive"><?php echo lang("LBL_DEACTIVE") ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-7">
                        <input type="submit" class="btn btn-primary" name="submit" value="<?php echo lang('LBL_ADD_PLAN'); ?>">
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

<?php include(APPPATH . "views/includes/footer.php"); ?>
<script type="text/javascript">
    $(document).ready(function(){
    });

</script>


