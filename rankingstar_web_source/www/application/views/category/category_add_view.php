<?php include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('LBL_ADD_CATEGORY'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('LBL_ADD_CATEGORY'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "category"; ?>"><?php echo lang('LBL_CATEGORY'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('LBL_ADD_CATEGORY'); ?></li>
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
                    $attr = array('id'=>'addCategory');
                    echo form_open(BASE_URL.'category/addCategory', $attr);
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label><?php echo lang("NAME_OF_CONTEST") ?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <select class="form-control select2" name="contest_id"  style="width: 100%;">
                            <option value=""><?php echo lang("SELECT_NAME_OF_CONTEST") ?></option>
                            <?php foreach($contestList as $list){ ?> 
                                <option value="<?php echo $list['contest_id']?>"><?php echo $list['contest_name'] ?></option>
                                <?php }?>
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_name"><?php echo lang('LBL_CATEGORY_NAME');?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" type="text" name="category_name" id="category_name" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_name"><?php echo lang('LBL_CATEGORY_NAME');?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input id="inputBox" type="text" class="tagator form-control" value="jQuery,Script,Net">
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status"><?php echo lang('LBL_STATUS');?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <select class="form-control select2" name="status">
                                <option value="active"><?php echo lang("LBL_ACTIVE") ?></option>
                                <option value="deactive"><?php echo lang("LBL_DEACTIVE") ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-8">
                        <input type="button" class="btn btn-primary" name="submit" value="<?php echo lang('LBL_ADD_CATEGORY'); ?>">
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
    $('#inputBox').tagator({
        showAllOptionsOnFocus: true,
        autocomplete: ['first', 'second', 'third', 'manoj', 'amit', 'bhavik']
    });    
</script>
