<?php  include "includes/header.php"?>
<title><?php echo lang('LBL_ADMIN_MANAGER_DETAILS'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('LBL_ADMIN_MANAGER_DETAILS'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "manager"; ?>"><?php echo lang('ADMIN_MANAGER_MANAGEMENT'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('LBL_ADMIN_MANAGER_DETAILS'); ?></li>
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
            <div class="card-header">
              <a href="<?php echo BASE_URL . "manager"; ?>" class="btn btn-primary"><?php echo lang('BTN_BACK'); ?></a>
              <?php if ($userData['user_type'] === "admin"): ?>
              <!-- <a class="btn btn-warning" href="<?php //echo BASE_URL . "user/history/" . $userDetails['user_id']; ?>"><?php //echo lang('LBL_VIEW_HISTORY'); ?></a>  -->
                <!-- <button type="button" class="btn btn-warning scroll-me"><?php echo lang('LBL_VIEW_HISTORY'); ?></button> -->
              <?php endif; ?>
            </div>
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
                    $attr = array('id'=>'editUser');
                    echo form_open(BASE_URL.'manager/edituser', $attr);
                ?>
                <?php 
                    $delete = array('id'=>'deleteUserToUnsubscribe');
                    echo form_open(BASE_URL.'manager/deleteUserToUnsubscribe', $delete);
                ?>
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $userDetails['user_id']; ?>">
                <input type="hidden" name="previous_email" id="previous_email" value="<?php echo $userDetails['email']; ?>">
                <input type="hidden" name="login_type" id="login_type" value="<?php echo $userDetails['login_type']; ?>">
                <input type="hidden" name="username" id="username" value="<?php echo $userDetails['email']; ?>">
                <input type="hidden" name="user_type" id="user_type" value="<?php echo $userDetails['user_type']; ?>">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="name"><?php echo lang('LBL_NAME');?></label>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <input class="form-control" type="text" name="name" id="name" value="<?php echo set_value('name', $userDetails['name']); ?>">
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
                    <input class="form-control" type="text" name="email" id="email" value="<?php echo set_value('email', $userDetails['email']); ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email"><?php echo lang('PASSWORD');?></label>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <input class="form-control" type="password" name="password" id="password">
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
                            <input class="form-control" type="text" name="phone" id="phone" value="<?php echo set_value('phone', $userDetails['mobile']); ?>">
                        </div>
                    </div>
                </div>
<!-- 
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_type"><?php echo lang('USER_TYPE');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input class="form-control" type="text" readonly="readonly" name="user_type" id="user_type" value="<?php echo set_value('phone', $userDetails['user_type']); ?>">

                        </div>
                    </div>
                </div> -->

                <!-- <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                        <label for="nick_name"><?php echo lang('LBL_NICK_NAME');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                        <input class="form-control" type="text" name="nick_name" id="nick_name" value="<?php echo set_value('nick_name', $userDetails['nick_name']); ?>">
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status"><?php echo lang('LBL_STATUS');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <select class="form-control select2" name="user_status">
                                <option value="active" <?php if ($userDetails['user_status'] == "active") echo 'selected="selected"'; ?> ><?php echo lang("LBL_ACTIVE") ?></option>
                                <option value="deactive" <?php if ($userDetails['user_status'] == "deactive") echo 'selected="selected"'; ?>><?php echo lang("LBL_DEACTIVE") ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status"><?php echo lang('LBL_LOGIN_TYPE');?></label>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                          <label for="status">
                          <?php 
                            $login_type = $userDetails['login_type'];
                            if($userDetails['login_type'] == "auth"){
                              $login_type = "Email";
                            }
                            echo $login_type;
                          ?>
                          </label>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="name"><?php echo lang('LBL_DEVICE_INFO');?></label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <input class="form-control" type="text" readonly="readonly" name="deviceinfo" id="deviceinfo" value="<?php echo set_value('deviceinfo', $userDetails['device_id']); ?>">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="name"><?php echo lang('LBL_IP_ADDRESS');?></label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <input class="form-control" type="text" readonly="readonly" name="ipaddress" id="ipaddress" value="<?php echo set_value('ipaddress', $userDetails['ip_addr']); ?>">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="name"><?php echo lang('LBL_MEMBER_SINCE');?></label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <input class="form-control" type="text" readonly="readonly" name="regdate" id="regdate" value="<?php echo date('Y-m-d',strtotime(set_value('regdate', $userDetails['register_date_time']))); ?>">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="name"><?php echo lang('LBL_LAST_ACCESS_DATE');?></label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="form-group">
                      <?php 
                      $last_access_date = "";
                      if($userDetails['last_access_date'] != "0000-00-00 00:00:00"){
                        $last_access_date = date('Y-m-d', strtotime($userDetails['last_access_date']));
                      }
                      ?>
                      <input class="form-control" type="text" readonly="readonly" name="lastdate" id="lastdate" value="<?php echo $last_access_date; ?>">
                    </div>
                  </div>
                </div> -->

                <div class="row">
                    <div class="col-md-8">
                    <?php if ($userData['user_type'] === "admin" && $userDetails['user_type'] != "admin"): ?>                      
                      <button type="button" class="btn btn-danger deleteUser" name="deletebtn"><?php echo lang('Delete'); ?></button>
                    <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                    <?php if ($userData['user_type'] === "admin"): ?>
                        <button type="button" class="btn btn-primary editUser float-right" name="editbutton"><?php echo lang('EDIT'); ?></button>
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

<?php //include "user_history_view.php"?>
<?php include "includes/footer.php"?>
<script type="text/javascript">
    $(document).ready(function(){

      // Scroll page and show user history
      $('.scroll-me').click(function() {
        var x = $(window).scrollTop();
        $(window).scrollTop(x+800);
      });

      // $("#editUser").submit(function(){
      //   alert('<?php echo lang('LBL_EDIT_USER_CONFIRMATION');?>');
      //   // if($('#password').val()){
      //    //   alert("yes");
      //    // })
      //    if($('#password').val()){
      //      var pass = $('#password').val().length;
      //      if(pass <8 ){
      //        alert('<?php echo lang('PASSWORD_LENGTH');?>');
      //        return false;
      //      }
           
      //    }
      // });

      $(document).on('click','.deleteUser', function(event){
        console.log(event);
        event.preventDefault();
        // var userId = $userDetails['user_id'];
        $.confirm({
          title: '<?php echo lang('LBL_REMOVE_USER'); ?>',
          content: '<?php echo lang('LBL_CONFIRMATION'); ?>',
          buttons: {
            confirm: {
              text: '<?php echo lang('BTN_OK');?>',
              action: function () {
                $.ajax({
                  url: "<?php echo base_url("manager/deleteUserToUnsubscribe") ?>",
                  type: 'POST',
                  data: {
                        'user_id' : <?php echo $userDetails['user_id'] ?>
                  },
                  beforeSend: function() {
                    startLoader();
                  },
                  success: function(res) {
                    window.location.href = "<?php echo base_url().'user'; ?>";   
                  },
                  complete: function(res) {
                    stopLoader();
                  },
                });
                // console.log(res);
              }
            },
            cancel: {
              text: '<?php echo lang('BTN_CANCEL');?>',
              action: function () {}
            },
          }
        });
      });


      ///// edit  /////

      $(document).on('click','.editUser', function(event){
        console.log(event);
        event.preventDefault();
        // var userId = $userDetails['user_id'];
       
        if($('#password').val()){
          var pass = $('#password').val().length;
          if(pass <8 ){
            alert('<?php echo lang('PASSWORD_LENGTH');?>');
            return false;
          }
        }
        $.confirm({
          title: '<?php echo lang('LBL_EDIT_USER'); ?>',
          content: '<?php echo lang('LBL_EDIT_USER_CONFIRMATION'); ?>',
          buttons: {
            confirm: {
              text: '<?php echo lang('BTN_OK');?>',
              action: function () { 
                $.ajax({
                  url: "<?php echo base_url("manager/edituser") ?>",
                  type: 'POST',
                  data: $("#editUser").serialize(),
                  // dataType:'JSON',
                  beforeSend: function() {
                    startLoader();
                  },
                  success: function(res) {
                    window.location.href = "<?php echo base_url().'user'; ?>";   
                  },
                  complete: function(res) {
                    stopLoader();
                  },
                });
                // console.log(res);
              }
            },
            cancel: {
              text: '<?php echo lang('BTN_CANCEL');?>',
              action: function () {}
            },
          }
        });
      });
      
    });
</script>


