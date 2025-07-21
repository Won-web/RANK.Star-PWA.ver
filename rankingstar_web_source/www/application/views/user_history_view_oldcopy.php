<?php include "includes/header.php"?>
<title><?php echo lang('HISTORY_PAGE_TITLE'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('HISTORY_PAGE_TITLE'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "user"; ?>"><?php echo lang('USER_MANAGEMENT'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('HISTORY_PAGE_TITLE'); ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <span class="star-count"></span> <i class="fas fa-star bg-star"></i>
              </div>
              <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true"><?php echo lang('LBL_PURCHASE_DETAILS');?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false"><?php echo lang('LBL_USAGE_DETAILS');?></a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <div class="card-body">
                      <table id="purchaselist" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                        <th><?php echo lang('SERIAL_NO'); ?></th>
                          <th><?php echo lang('LBL_DESCRIPTION'); ?></th>
                          <th><?php echo lang('Type'); ?></th>
                          <th><?php echo lang('LBL_STAR'); ?></th>
                          <th><?php echo lang('LBL_PURCHASE_DATE'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr class="total-star-row">
                        <td></td>
                          <td colspan="2" align="right"><?php echo lang('total'); ?></td>
                          <td class="total-star"></td>
                         
                          <td></td>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                    <div class="card-body">
                      <table id="usagelist" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th><?php echo lang('SERIAL_NO'); ?></th>
                          <th><?php echo lang('LBL_DESCRIPTION'); ?></th>
                          <th><?php echo lang('LBL_CONTEST_NAME'); ?></th>
                          <th><?php echo lang('LBL_CONTESTANT_NAME'); ?></th>
                          <th><?php echo lang('LBL_STAR'); ?></th>
                          <th><?php echo lang('LBL_VOTE_DATE'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr class="total-star-row">
                        <td></td>
                          <td colspan="3" align="right"><?php echo lang('total'); ?></td>
                          <td class="total-vote"></td>
                          <td></td>
                         
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
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
      var a = "<?php echo BASE_URL ?>User";
      var userList = "<?php echo lang('LBL_USER_LIST') ?>";
      function setPurchaseTableData(){
        $('#purchaselist').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
//           "sDom": '<"top"f>rt<"bottom"pi><"bottom" <"#taskbuttonfilternew">><"clear">',
// "fnDrawCallback": function(oSettings) {
// $('#taskbuttonfilternew').html('');
// $('#taskbuttonfilternew').append('<button type="button" role="button" class="btn btn-primary" style="margin-top:5px;margin-left:10px;"><?php echo "list";?></button>');
// },

          "oLanguage": {
  "sZeroRecords": "<?php echo lang('No matching records found'); ?>",
  "sInfo": "<?php echo lang('Record'); ?> _TOTAL_ ",
  "sInfoEmpty": "<?php echo lang('Record'); ?> 0",

  "sSearch":   " <?php echo lang("Search") ?>",
  "oPaginate": {
            "sNext":    "<?php echo lang("Next");?>",
            "sPrevious": "<?php echo lang("Previous");?>"
        },
},dom: '<"toolbar">Blfltip',
fnDrawCallback: function(){
     
    $('.paginate_button.previous').before('<a href="'+a+'" class="btn btn-primary btn-small" id="any_button">'+userList+'</a>');
      // $(".pagination")
      //    .append('<a href="'+a+'" class="btn btn-primary btn-small" id="any_button">User List!</a>'); 
              
   }   ,

          "columns": [
            {'data': 'count'},
            {'data': 'description'},
            {'data': 'purchase_type'},
            {'data': 'star'},
            {'data': 'purchase_date'}
          ],
          "info": true,
          "autoWidth": false,
          "processing": true,
          "serverSide": true,
          "ajax": {
            url : "<?php echo base_url("user/purchasehistory/".$user_id) ?>",
            type : 'POST',
            dataSrc: function (json) {
              var purchaseList = json.data.purchase_list;
              var remainingStarCount = json.data.remaining_star;
              var totalPurchase = json.data.total_purchase;
              $('.star-count').html(remainingStarCount);
              $('.total-star').html(totalPurchase);
              var return_data = new Array();
              var totalStar = json.data.total_purchase;
              for(var i=0;i< purchaseList.length; i++){
                return_data.push({
                  'count': purchaseList[i].count,
                  'description': purchaseList[i].description,
                  'purchase_type'  : purchaseList[i].type,
                  'star' : purchaseList[i].star,
                  'purchase_date' : purchaseList[i].purchase_date
                });
                // totalStar = totalStar + parseInt(purchaseList[i].star);
              }
              return return_data;
            }
          }
        });
      }
      
      function setUsageTableData(){
        $('#usagelist').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          // },
dom: 'l<"toolbar">lfrtip',
fnDrawCallback: function(){
    $('.paginate_button.previous').before('<a href="'+a+'" class="btn btn-primary btn-small" id="any_button">User List!</a>');           
   }   ,
          "oLanguage": {
  "sZeroRecords": "<?php echo lang('No matching records found'); ?>",
  "sInfo": "<?php echo lang('Record'); ?> _TOTAL_ ",
  "sInfoEmpty": "<?php echo lang('Record'); ?> 0",

  "sSearch":  " <?php echo lang("Search"); ?>",
  "oPaginate": {
            "sNext":    "<?php echo lang("Next");?>",
            "sPrevious": "<?php echo lang("Previous");?>"
        },
},
         
          "columns": [
            {'data': 'count'},
            {'data': 'description'},
            {'data': 'contest_name'},
            {'data': 'receiver_name'},
            {'data': 'vote'},
            {'data': 'vote_date'}
          ],
          "info": true,
          "autoWidth": false,
          "processing": true,
          "serverSide": true,
          "ajax": {
            url : "<?php echo base_url("user/usagehistory/".$user_id) ?>",
            type : 'POST',
            dataSrc: function (json) {
              var votingList = json.data.voting_list;
              var remainingStarCount = json.data.remaining_star;
              var totalVote = json.data.total_usage;
              $('.star-count').html(remainingStarCount);
              var return_data = new Array();
              var totalVote = json.data.total_usage;
              for(var i=0;i< votingList.length; i++){
                return_data.push({
                  'count': votingList[i].count,
                  'description': votingList[i].description,
                  'contest_name'  : votingList[i].contest_name,
                  'receiver_name'  : votingList[i].receiver_name,
                  'vote' : votingList[i].vote,
                  'vote_date' : votingList[i].vote_date
                });
                // totalVote = totalVote + parseInt(votingList[i].vote);
              }
              $('.total-vote').html(totalVote);
              return return_data;
            }
          }
        });
      }
      
      setPurchaseTableData();
      $('#custom-tabs-three-home-tab').click(function(){
        $('#purchaselist').dataTable().fnDestroy();
        setPurchaseTableData();
      });
      $('#custom-tabs-three-profile-tab').click(function(){
        $('#usagelist').dataTable().fnDestroy();
        setUsageTableData();
      });
    });
</script>


