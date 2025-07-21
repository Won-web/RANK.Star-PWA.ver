<?php include(APPPATH . "views/includes/header.php" ); ?>
<title><?php echo lang('PLANS'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('PLANS'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('PLANS'); ?></li>
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
              <h3 class="card-title"><?php echo lang('LBL_PLAN_LIST'); ?></h3>
              <?php if ($userData['user_type'] === "admin"): ?>
                <a class="btn btn-primary" style="float:right;" href="<?php echo BASE_URL . "plans/addPlan"; ?>"><?php echo lang('LBL_ADD_PLAN'); ?></a>
              <?php endif; ?>              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="planList" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo lang('SERIAL_NO'); ?></th>
                        <th><?php echo lang('LBL_PLAN_NAME'); ?></th>
                        <th><?php echo lang('LBL_DESCRIPTION'); ?></th>
                        <th><?php echo lang('LBL_PRICE'); ?></th>
                        <th><?php echo lang('LBL_STAR'); ?></th>
                        <th><?php echo lang('LBL_EXTRA_STAR'); ?></th>
                        <th><?php echo lang('LBL_STATUS'); ?></th>
                        <th><?php echo lang('LBL_PLAN_TYPE'); ?></th>
                        <th><?php echo lang('LBL_ACTION'); ?></th>
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
    $(document).ready(function(){
      function setDataTable() {
        $('#planList').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
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
          "columns": [
           {"oderable":false},
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            { "orderable": false }
          ],
          "info": true,
          "autoWidth": false,
          "processing": true,
          "serverSide": true,
          "ajax": {
            url : "<?php echo base_url("plans/getPlanList") ?>",
            type : 'POST'
          }
        });
      }
      setDataTable();
      $(document).on('click','.remove-plan', function(e){
        e.preventDefault();
        var url = $(this).data('url');
        $.confirm({
          title: '<?php echo lang('LBL_REMOVE_PLAN'); ?>',
          content: '<?php echo lang('LBL_CONFIRMATION'); ?>',
          buttons: {
            confirm: {
            text: '<?php echo lang('BTN_OK');?>',
              action: function () {
                $.ajax({
                  method: "POST",
                  url: url,
                  success: function(res){
                    if(res.res_code == 1){
                      $('#planList').dataTable().fnDestroy();
                      toastr.success(res.res_message);
                      setDataTable();
                    }else{
                      toastr.error(res.res_message);
                    }
                  }
                });
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


