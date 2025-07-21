<?php include "includes/header.php"?>
<title><?php echo lang('SALES_DETAILS_PAGE_TITLE'); ?></title>
<style>
    #salesdetailslist_wrapper {
        margin-top: -30px;
    }
    .date-control {
        z-index: 1;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('TRANSACTION_MANAGEMENT'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "transaction"; ?>"><?php echo lang('TRANSACTION_MANAGEMENT'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('TRANSACTION_LIST'); ?></li>
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
              <h3 class="card-title"><?php echo lang('TRANSACTION_LIST'); ?></h3>              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- <div class="row">
                    <div class="col-md-4">
                        <div class="input-group date-control">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" name="date" id="dateFilter">
                        </div>
                    </div>
                </div> -->
                <table id="transactiondetailslist" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th><?php echo lang('SERIAL_NO'); ?></th>
                            <th><?php echo lang('LBL_NAME'); ?></th>
                            <th><?php echo lang('LBL_EMAIL'); ?></th>
                            <th><?php echo lang('LBL_DESCRIPTION'); ?></th>
                            <th><?php echo lang('LBL_STAR'); ?></th>
                            <th><?php echo lang('LBL_AMOUNT'); ?></th>
                            <th><?php echo lang('LBL_TRANSACTION_ID'); ?></th>
                            <th><?php echo lang('LBL_APP_TYPE'); ?></th>
                            <th><?php echo lang('LBL_DATE'); ?></th>
                            <th><?php echo lang('LBL_ACTION'); ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <!-- <tfoot>
                        <tr class="total-star-row">
                            <td colspan="5" align="right"></td>
                            <td><?php echo lang('LBL_TOTAL'); ?></td>
                            <td class="total-amount"></td>
                            <td class="total-refund"></td>
                            <td></td>
                        </tr>
                    </tfoot> -->
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

<?php include "includes/footer.php"?>
<script type="text/javascript">
    $(document).ready(function() {
            // Date range picker
            var from_date = "";
            var to_date = "";
            $('#dateFilter').daterangepicker();
            $('#dateFilter').val('');
            $('#dateFilter').on('cancel.daterangepicker', function(ev, picker) {
            // do something, like clearing an input
            $('#transactiondetailslist').dataTable().fnDestroy();
            $('#dateFilter').val('');
            from_date = "";
            to_date = "";
            setDataTable();
        });
        $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
            $('#transactiondetailslist').dataTable().fnDestroy();
            from_date = picker.startDate.format('YYYY-MM-DD');
            to_date = picker.endDate.format('YYYY-MM-DD');
            setDataTable();
        });
        function setDataTable() {
            $('#transactiondetailslist').DataTable({
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
                    [8, 'desc']
                ],
                "columns": [
                    {"orderable": false},
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"orderable": false}
                ],
                "info": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url : "<?php echo base_url("transaction/transactionDetails") ?>",
                    type : 'POST',
                    data : {
                        'from_date' : from_date,
                        'to_date' : to_date
                    }
                }
            });
        }
        setDataTable();
        $(document).on('click','.mark-success', function(e){
        e.preventDefault();
        var url = $(this).data('url');
        $.confirm({
          title: '<?php echo lang('LBL_MARK_SUCCESS'); ?>',
          content: '<?php echo lang('LBL_SUCCESS_CONFITMATION'); ?>',
          buttons: {
            confirm: {
            text: '<?php echo lang('BTN_OK');?>',
              action: function () {
                $.ajax({
                  method: "POST",
                  url: url,
                  success: function(res){
                    if(res.res_code == 1){
                      $('#transactiondetailslist').dataTable().fnDestroy();
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
