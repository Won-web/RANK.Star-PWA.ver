<?php include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('LBL_ADVERTISE_DETAIL'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?php echo lang('LBL_ADVERTISE_DETAIL'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "advertise"; ?>"><?php echo lang('LBL_ADVERTISE'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('LBL_ADVERTISE_DETAIL'); ?></li>
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
                    $attr = array('id'=>'editAdvertise');
                    echo form_open(BASE_URL.'advertise/editAdvertise', $attr);
                ?>
                <input type="hidden" name="ad_id" id="ad_id" value="<?php echo $advertiseDetails['ad_id']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ad_name"><?php echo lang('LBL_ADVERTISE_NAME');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="ad_name" id="ad_name" value="<?php echo set_value('ad_name', $advertiseDetails['ad_name']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ad_path"><?php echo lang('LBL_AD_PATH');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" name="ad_path" id="ad_path" value="<?php echo set_value('ad_path', $advertiseDetails['ad_path']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ad_type"><?php echo lang('LBL_AD_TYPE');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <select class="form-control select2" name="ad_type">
                                <option value="image" <?php if ($advertiseDetails['ad_type'] === "image") echo 'selected="selected"'; ?>><?php echo lang("LBL_IMAGE") ?></option>
                                <option value="video" <?php if ($advertiseDetails['ad_type'] === "video") echo 'selected="selected"'; ?>><?php echo lang("LBL_VIDEO") ?></option>
                            </select>
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
                            <input class="form-control" type="text" name="star" id="star" value="<?php echo set_value('star', $advertiseDetails['star']); ?>">
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
                                <option value="active" <?php if ($advertiseDetails['status'] === "active") echo 'selected="selected"'; ?>><?php echo lang("LBL_ACTIVE") ?></option>
                                <option value="deactive" <?php if ($advertiseDetails['status'] === "deactive") echo 'selected="selected"'; ?>><?php echo lang("LBL_DEACTIVE") ?></option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-7">
                        <?php if ($userData['user_type'] === "admin"): ?>
                            <input type="submit" class="btn btn-primary" name="submit" value="<?php echo lang('BTN_UPDATE_ADVERTISE'); ?>">
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
