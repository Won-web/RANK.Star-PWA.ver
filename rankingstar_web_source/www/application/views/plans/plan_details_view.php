<?php include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('LBL_PLAN_DETAIL'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('LBL_PLAN_DETAIL'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "plans"; ?>"><?php echo lang('PLANS'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('LBL_PLAN_DETAIL'); ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-6">
          <div class="card">            
            <!-- /.card-header -->
            <div class="card-body">
                <?php if (!empty($this->session->flashdata('error'))): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> <?php echo lang('LBL_ERROR'); ?></h5>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php endif;?>
                <?php 
                    $attr = array('id'=>'editPlan');
                    echo form_open(BASE_URL.'plans/editPlan', $attr);
                ?>
                <input type="hidden" name="plan_id" id="plan_id" value="<?php echo $planDetails['plan_id']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="plan_name"><?php echo lang('LBL_PLAN_NAME');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="plan_name" id="plan_name" value="<?php echo set_value('plan_name', $planDetails['plan_name']); ?>">
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
                            <input class="form-control" type="text" name="description" id="description" value="<?php echo set_value('description', $planDetails['description']); ?>">
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
                            <input class="form-control" type="text" name="price" id="price" value="<?php echo set_value('price', $planDetails['price']); ?>">
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
                            <input class="form-control" type="text" name="star" id="star" value="<?php echo set_value('star', $planDetails['star']); ?>">
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
                            <input class="form-control" type="text" name="extra_star" id="extra_star" value="<?php echo set_value('extra_star', $planDetails['extra_star']); ?>">
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
                                <option value="Android" <?php if ($planDetails['plan_type'] == "Android") echo 'selected="selected"'; ?> ><?php echo lang("LBL_ANDROID") ?></option>
                                <option value="iOS" <?php if ($planDetails['plan_type'] == "iOS") echo 'selected="selected"'; ?>><?php echo lang("LBL_IOS") ?></option>
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
                                <option value="active" <?php if ($planDetails['status'] == "active") echo 'selected="selected"'; ?> ><?php echo lang("LBL_ACTIVE") ?></option>
                                <option value="deactive" <?php if ($planDetails['status'] == "deactive") echo 'selected="selected"'; ?>><?php echo lang("LBL_DEACTIVE") ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-7">
                        <?php if ($userData['user_type'] === "admin"): ?>
                            <input type="submit" class="btn btn-primary" name="submit" value="<?php echo lang('BTN_UPDATE_PLAN'); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
          </div>
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


