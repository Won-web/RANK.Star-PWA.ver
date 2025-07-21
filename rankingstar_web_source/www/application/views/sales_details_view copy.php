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
            <h1 class="m-0 text-dark"><?php echo lang('SALES_DETAILS_PAGE_TITLE'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "sales"; ?>"><?php echo lang('SALES_PAGE_TITLE'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('SALES_DETAILS_PAGE_TITLE'); ?></li>
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
              <h3 class="card-title"><?php echo lang('LBL_SALES_DETAILS'); ?></h3>              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
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
                </div>
                <table id="salesdetailslist" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th><?php echo lang('SERIAL_NO'); ?></th>
                            <th><?php echo lang('LBL_NAME'); ?></th>
                            <th><?php echo lang('LBL_EMAIL'); ?></th>
                            <th><?php echo lang('LBL_DESCRIPTION'); ?></th>
                            <th><?php echo lang('LBL_STAR'); ?></th>
                            <th><?php echo lang('LBL_PURCHASE_DATE'); ?></th>
                            <th><?php echo lang('LBL_AMOUNT'); ?></th>
                            <th><?php echo lang('LBL_REFUND'); ?></th>
                            <th><?php echo lang('LBL_REFUND_DATE'); ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr class="total-star-row">
                            <td colspan="5" align="right"></td>
                            <td><?php echo lang('LBL_TOTAL'); ?></td>
                            <td class="total-amount"></td>
                            <td class="total-refund"></td>
                            <td></td>
                        </tr>
                    </tfoot>
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
            $('#salesdetailslist').dataTable().fnDestroy();
            $('#dateFilter').val('');
            from_date = "";
            to_date = "";
            setDataTable();
        });
        $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
            $('#salesdetailslist').dataTable().fnDestroy();
            from_date = picker.startDate.format('YYYY-MM-DD');
            to_date = picker.endDate.format('YYYY-MM-DD');
            setDataTable();
        });
        function setDataTable() {
            $('#salesdetailslist').DataTable({
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
                [5, 'desc']
            ],
                "columns": [
                    {'data': 'count'},
                  
                    {'data': 'userName'},
                    {'data': 'email'},
                    {'data': 'description'},
                    {'data': 'star'},
                    {'data': 'purchaseDate'},
                    {'data': 'amount'}, // "orderable": false
                    {'data': 'refund'},
                    {'data': 'refundDate'}
                ],
                "info": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url : "<?php echo base_url("sales/salesDetails") ?>",
                    type : 'POST',
                    data : {
                        'from_date' : from_date,
                        'to_date' : to_date
                    },
                    dataSrc: function (json) {
                        var salesDetailsList = json.data.sales_details_list;
                        var return_data = new Array();
                        var totalAmount = json.data.total_sales;
                        var totalRefund = json.data.total_refund;
                        for(var i=0;i< salesDetailsList.length; i++) {             
                            return_data.push({
                                'count' : salesDetailsList[i].count,
                                'userName': salesDetailsList[i].name,
                                'email' : salesDetailsList[i].email,
                                'description' : salesDetailsList[i].description,
                                'star': salesDetailsList[i].star,
                                'amount' : salesDetailsList[i].amount,
                                'purchaseDate': salesDetailsList[i].purchase_date,
                                'refund' : salesDetailsList[i].refund,
                                'refundDate': salesDetailsList[i].refund_date
                            }); 
                            // totalAmount = totalAmount + parseInt(salesDetailsList[i].amount);
                            // totalRefund = totalRefund + parseInt(salesDetailsList[i].refund);
                        }
                        $('.total-amount').html(totalAmount);
                        $('.total-refund').html(totalRefund);
                        return return_data;
                    }
                }
            });
        }
        setDataTable();
    });
</script>
