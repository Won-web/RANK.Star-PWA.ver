<?php include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('LBL_NOTICE_BOARD'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('LBL_SEND_NOTIFICATION'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('LBL_SEND_NOTIFICATION'); ?></li>
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
                <h3 class="card-title"><?php echo lang('LBL_NOTIFICATION_LIST'); ?></h3>
                <?php if ($userData['user_type'] === "admin"): ?>
                    <a class="btn btn-primary" style="float:right;" href="<?php echo BASE_URL . "notification/sendNotification"; ?>"><?php echo lang('LBL_SEND_NOTIFICATION'); ?></a>
                <?php endif; ?>             
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="noticeList" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo lang('SERIAL_NO'); ?></th>
                        <th><?php echo lang('LBL_MESSAGE_TITLE'); ?></th>
                        <th><?php echo lang('LBL_MESSAGE'); ?></th>
                        <th><?php echo lang('LBL_MESSAGE_TYPE'); ?></th>
                        <th><?php echo lang('DATE'); ?></th>

                    </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
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
    $(document).ready(function() {
      clearPageNO(); // clearing page no of user controller

        function setDataTable() {
            $('#noticeList').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "oLanguage": {
                  "sZeroRecords": "<?php echo lang('No matching records found'); ?>",
                  "sInfo": "<?php echo lang('Record'); ?> _TOTAL_ ",
                  "sInfoEmpty": "<?php echo lang('Record'); ?> 0",
                  "sSearch":  " <?php echo lang("Search") ?>",
                  "oPaginate": {
                    "sNext":    "<?php echo lang("Next");?>",
                    "sPrevious": "<?php echo lang("Previous");?>"
                  },
                },
                "order": [
                  [4, 'desc']
                ],
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                ],
                "info": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url : "<?php echo base_url("notification/getNotificationList") ?>",
                    type : 'POST'
                }
            });
        }
        setDataTable();
    });
</script>


