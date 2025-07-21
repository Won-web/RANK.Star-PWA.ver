<?php  include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('BTN_UPDATE_NOTICE'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('BTN_UPDATE_NOTICE'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "notice"; ?>"><?php echo lang('LBL_NOTICE_BOARD'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('BTN_UPDATE_NOTICE'); ?></li>
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
        <div class="col-10">
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
                    $attr = array('id'=>'editNotice');
                    echo form_open(BASE_URL.'notice/editNotice', $attr);
                ?>
                <input type="hidden" name="noticeId" value="<?php echo $noticeDetails[0]['notice_id'] ?>">
                <input type="hidden" name="senderId" value="<?php echo $userData['user_id'] ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="messageTitle"><?php echo lang('LBL_MESSAGE_TITLE');?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" type="text" name="messageTitle" id="messageTitle" value="<?php echo set_value('messageTitle', $noticeDetails[0]['notice_title']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="message"><?php echo lang('LBL_MESSAGE');?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                    <div class="form-group">
                        <div class="mb-3">
                            <!-- <textarea class="textarea" name="message" id="message" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                            <textarea id="message" name="message" placeholder="" >
                            <?php echo $noticeDetails[0]['notice_description'];?>
                            </textarea>
                        </div>
                    </div>
                </div>
                    <!-- <div class="col-md-8">
                        <div class="form-group">
                            <input class="form-control" type="text" name="message" id="message" value="<?php // echo set_value('message', ''); ?>">
                        </div>
                    </div> -->
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sendNotice"><?php echo lang('LBL_SEND_NOTICE');?></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="checkbox" name="sendNotice" id="sendNotice" value="yes">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-warning" name="submit" value="<?php echo lang('BTN_UPDATE_NOTICE'); ?>">
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
    $(function() {
        $('.textarea').summernote();
    });
    $( "#editNotice" ).submit(function( event ) {
        event.preventDefault();
        var messageTitle = $( "#messageTitle" ).val();
        var tempMessageTitle = messageTitle;
        var message = $( "#message" ).val();
        var sendNotice = $("input[name='sendNotice']:checked").val();
        // form validation
        if(messageTitle !== "" && message !== "") {
            $.ajax({
                url: "<?php echo base_url("notice/editNotice") ?>",
                type: 'POST',
                data: {
                    'messageTitle': messageTitle,
                    'message' : message,
                    'sendNotice' : sendNotice,
                    'senderId' : <?php echo $userData['user_id']  ?>,
                    'noticeId' : <?php echo $noticeDetails[0]['notice_id'] ?>
                },
                beforeSend: function() {
                    startLoader();
                },
                success: function(res) {
                    window.location.href = "<?php echo base_url().'notice'; ?>";
                },
                complete: function(res) {
                    stopLoader();
                },
            });
        } else {
            toastr.error('All fields are required');
        }
    });
    $('#message').redactor({
        buttons: ['html', 'format', 'bold', 'italic', 'deleted', 'lists', 'image'],
        maxHeight: '800px',
        plugins: ['video'],
       
        imageUpload: "<?php echo BASE_URL . "contest/addDescriptionImage"; ?>",
        callbacks: {
            image: {
                delete: function(image)
                {
                    //console.log(image);
                    return true;
                }
            }
        }
    });
    $('#message').redactor('set', 'yes noeee' ,  { start: false });
</script>
