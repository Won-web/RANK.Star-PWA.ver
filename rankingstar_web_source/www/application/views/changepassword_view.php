<?php include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('CHANGEPASSWORD'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?php echo lang('CHANGEPASSWORD'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('CHANGEPASSWORD'); ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo lang('LBL_CHANGE_PASSWORD'); ?></h3>             
                    </div>
                    <!-- /.card-header -->
                    <!-- <form action="<?php echo BASE_URL . "changepassword/editPassword"; ?>" method="post" id="editpassword" class="editPassword" enctype="multipart/form-data">
                        <div class="card-body">
                            <input type="hidden" name="user_id" value="<?php echo $userData['user_id']?>">
                            <div class="row">
                               
                                <div class="col-md-4">
                                    <div class="form-group general-form-group">
                                        <label><?php echo lang("LBL_OLD_PASSWORD") ?><span class="mandatoryClass">*</span></label>
                                        <input type="password" class="form-control" name="old_password"
                                            value="<?php echo set_value('old_password','');?>" id="old_password"
                                            placeholder="<?php echo lang("LBL_OLD_PASSWORD") ?>">
                                    </div>
                                    <div class="old_password_validation form-error-section"></div>
                                </div>
                                   
                                <div class="col-md-4">
                                    <div class="form-group general-form-group">
                                        <label for="exampleInputEmail1"><?php echo lang("LBL_NEW_PASSWORD") ?><span class="mandatoryClass">*</span></label>
                                        <input type="password" class="form-control" name="new_password"
                                            value="<?php echo set_value('new_password',''); ?>" id="new_password"
                                            placeholder="<?php echo lang("LBL_NEW_PASSWORD") ?>">
                                    </div>
                                    <div class="new_password_validation form-error-section"></div>
                                </div>
                                    
                                <div class="col-md-4">
                                    <div class="form-group general-form-group">
                                        <label for="exampleInputEmail1"><?php echo lang("LBL_CONFIRM_NEW_PASSWORD") ?><span class="mandatoryClass">*</span></label>
                                        <input type="password" class="form-control" name="confirm_new_password"
                                            value="<?php echo set_value('confirm_new_password','') ?>" id="confirm_new_password"
                                            placeholder="<?php echo lang("LBL_CONFIRM_NEW_PASSWORD") ?>">
                                    </div>
                                    <div class="confirm_new_password_validation form-error-section"></div>
                                </div>
                            </div>
                
                                <div class=row>
                                    <div class="col-md-2">
                                        <?php if ($userData['user_type'] === "admin"): ?>
                                            <input type="submit" name="submit" class="btn btn-primary btn-block float-right"
                                                value="<?php echo lang("LBL_CHANGE_PASSWORD") ?>">
                                        <?php endif; ?>
                                    </div>
                                </div>
                           
                        </div>
                     
                    </form> -->
                    <!-- /form -->

                    <form action="<?php echo BASE_URL . "changepassword/editPassword"; ?>" method="post" id="editPassword" class="editPassword" enctype="multipart/form-data">
                    <div class="card-body">
                        <!-- <?php //if(!empty($this->session->flashdata('error'))): ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-ban"></i> <?php //echo lang('LBL_ERROR');?></h5>
                                <?php //echo $this->session->flashdata('error');?>
                            </div>
                        <?php //endif;?> -->
                        <!-- <?php 
                            //$attr = array('id'=>'editPassword');
                            //echo form_open(BASE_URL.'changepassword/editPassword', $attr);
                        ?> -->
                        <input type="hidden" name="user_id" value="<?php echo $userData['user_id'] ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="messageTitle"><?php echo lang('LBL_OLD_PASSWORD');?></label>
                                    <input type="password" class="form-control" name="old_password"
                                    id="old_password" value="<?php echo set_value('old_password', ''); ?>" 
                                    placeholder="<?php echo lang("LBL_OLD_PASSWORD") ?>">
                                </div>
                                <div class="old_password_validation form-error-section"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="messageTitle"><?php echo lang('LBL_NEW_PASSWORD');?></label>
                                    <input type="password" class="form-control" name="new_password"
                                    id="new_password" value="<?php echo set_value('new_password', ''); ?>" 
                                    placeholder="<?php echo lang("LBL_NEW_PASSWORD") ?>">
                                </div>
                                <div class="new_password_validation form-error-section"></div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="messageTitle"><?php echo lang('LBL_CONFIRM_NEW_PASSWORD');?></label>
                                    <input type="password" class="form-control" name="confirm_new_password"
                                    id="confirm_new_password" value="<?php echo set_value('confirm_new_password', ''); ?>" 
                                    placeholder="<?php echo lang("LBL_CONFIRM_NEW_PASSWORD") ?>">
                                </div>
                                <div class="confirm_new_password_validation form-error-section"></div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-4"></div> -->
                            <div class="col-md-7">
                                <input type="submit" class="btn btn-primary" name="submit" value="<?php echo lang('LBL_CHANGE_PASSWORD'); ?>">
                            </div>
                        </div>
                    </div>
                    </form>
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

<?php include "includes/footer.php"?>
<script type="text/javascript">
    $(document).ready(function(){
        clearPageNO(); 
        // $("#confirm_new_password").keypress(function() {
        //     removeValidation('confirm_new_password');
        // });
        // $("#old_password").keypress(function() {
        //     removeValidation('old_password');
        // });
        // $("#new_password").keypress(function() {
        //     removeValidation('new_password');
        // });
        
        $(document).on('submit', 'form.editPassword', function() {
            var count = 0;  
            var old_password = $.trim($("#old_password").val());
            var new_password = $.trim($("#new_password").val());
            var confirm_new_password = $.trim($("#confirm_new_password").val());

            if (old_password.length === 0) {
                // addValidation('#old_password');
                $(".old_password_validation").addClass('error_message');
                $(".old_password_validation").html('<?php echo lang('MSG_OLD_PASSWORD') ?>');
                count += 1;
            }
            if (new_password.length === 0) {
                $(".new_password_validation").addClass('error_message');
                $(".new_password_validation").html('<?php echo lang('MSG_NEW_PASSWORD') ?>');
                count += 1;
            }
            if (confirm_new_password.length === 0) {
                $(".confirm_new_password_validation").addClass('error_message');
                $(".confirm_new_password_validation").html('<?php echo lang('MSG_CONFIRM_NEW_PASSWORD') ?>');
                count += 1;
            }
            if (old_password.length < 4  && old_password.length !== 0) {
                $(".old_password_validation").addClass('error_message');
                $(".old_password_validation").html('<?php echo lang('MSG_PASSWORD_MAX') ?>');
                count += 1;
            }
            if (new_password.length < 8 && new_password.length !== 0) {
                $(".new_password_validation").addClass('error_message');
                $(".new_password_validation").html('<?php echo lang('MSG_NEW_PASSWORD_MAX') ?>');
                count += 1;
            }
            if(new_password !== confirm_new_password) {
                $(".confirm_new_password_validation").addClass('error_message');
                $(".confirm_new_password_validation").html('<?php echo lang('MSG_PASSWORD_SAME') ?>');
                count += 1;
            }
            return (count === 0) ? true : false; 
        });
    });
</script>