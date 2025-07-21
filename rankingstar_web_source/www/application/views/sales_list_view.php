<?php include "includes/header.php"?>
<title><?php echo lang('SALES_PAGE_TITLE'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('SALES_PAGE_TITLE'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('SALES_PAGE_TITLE'); ?></li>
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
              <h3 class="card-title"><?php echo lang('LBL_SALES_LIST'); ?></h3>              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="saleslist" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th><?php echo lang('NO'); ?></th>
                  <th><?php echo lang('LBL_RANKING'); ?></th>
                  <th><?php echo lang('LBL_CONTEST_NAME'); ?></th>
                  <th><?php echo lang('LBL_SALES'); ?></th>
                  <th><?php echo lang('LBL_PROFIT'); ?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr class="total-star-row">
                    <td colspan="2" align="right"></td>
                    <td class="total-sales"></td>
                    <td class="total-profit"></td>
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
    $(document).ready(function(){
      function setDataTable() {
        $('#saleslist').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          
          "columns": [
            {'data': 'count'},
            {'data': 'ranking'}, //, "orderable": false
            {'data': 'contest_name'},
            {'data': 'total_sales'},
            {'data': 'total_profit'}
          ],
          "info": true,
          "autoWidth": false,
          "processing": true,
          "serverSide": true,
          "ajax": {
            url : "<?php echo base_url("sales/saleslist") ?>",
            type : 'POST',
            dataSrc: function (json) {
              var salesList = json.data.sales_list;
              var return_data = new Array();
              var totalSales = json.data.total_sales;
              var totalProfit = json.data.total_profit;
              var ranking = 1;
              for(var i=0;i< salesList.length; i++){
                var details = '<a data-toggle="tooltip" title="Details" href="' + '<?php echo BASE_URL;?>' + 'sales/details/' + salesList[i].contest_id + '" data-id="' + salesList[i].contest_id + '">' + salesList[i].contest_name + '</a>';
                return_data.push({
                  'count' : count,
                  'ranking': ranking,
                  'contest_name'  : details,
                  'total_sales' : salesList[i].total_sales,
                  'total_profit' : parseInt(salesList[i].total_profit)
                });
                ranking++;
                // totalSales = totalSales + parseInt(salesList[i].total_sales);
                // totalProfit = totalProfit + parseInt(salesList[i].total_profit);
              }
              $('.total-sales').html(totalSales);
              $('.total-profit').html(totalProfit);
              return return_data;
            }
          }
        });
      }
      setDataTable();
    });

</script>


