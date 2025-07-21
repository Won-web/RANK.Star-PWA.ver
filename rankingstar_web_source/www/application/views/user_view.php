<?php include "includes/header.php"?>
<title><?php echo lang('USER_MANAGEMENT'); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo lang('USER_MANAGEMENT'); ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
              <li class="breadcrumb-item active"><?php echo lang('USER_MANAGEMENT'); ?></li>
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
              <h3 class="card-title"><?php echo lang('LBL_USER_LIST'); ?></h3>
              <?php if ($userData['user_type'] === "admin"): ?>
                <a class="btn btn-primary" style="float:right;" href="<?php echo BASE_URL . "user/adduser"; ?>"><?php echo lang('BTN_ADD_USER'); ?></a>
              <?php endif; ?>
             
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="userlist" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th><?php echo lang('SERIAL_NO'); ?></th>
                  <th><?php echo lang('LBL_NAME'); ?></th>
                  <th><?php echo lang('LBL_EMAIL'); ?></th>
                  <th><?php echo lang('LBL_PHONE'); ?></th>
                  <th><?php echo lang('LBL_REGISTER_DATE'); ?></th>
                  <th><?php echo lang('LBL_STATUS'); ?></th>
                  <th><?php echo lang('LBL_ACTION'); ?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>
               
              </table>
              <!-- <div class="searPage">
              <label for="exampleInputFile" class="labelRight"><?php echo lang('PAGE_NO'); ?> :</label>
              <input type="text" name="page"  class="pageDy" id="pag" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
              <button class="btn btn-secondary btn-sm pageButton btnRight" id="searchPage"><?php echo lang('GO'); ?></button>
              </div> -->
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
    
      function setDataTable(page_no) {
        var pageNumber =  1;
        
          if(page_no === ''){
            pageNumber = 1;
            clearPageNO();
          }
          if(localStorage.getItem('draw')){
            pageNumber = localStorage.getItem('draw')
          }
          if(page_no){
            pageNumber = page_no
          }
        
            table = $('#userlist').DataTable({
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
                  { "orderable": false },
                  null,
                  null,
                  null,
                  null,
                  { "orderable": false },
                  { "orderable": false }
                ],
                "info": true,
                "stateSave" : true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "bDestroy": true,
                "displayStart":(pageNumber - 1) * 10,
                "ajax": {
                  url : "<?php echo base_url("user/userlist") ?>",
                  type : 'POST',
                
                },
                "drawCallback" :function(settings){

                  var current_page = Math.ceil(settings._iDisplayStart / settings._iDisplayLength) + 1
                  localStorage.setItem('draw',current_page)
                
                }
              });
          
      }

      setDataTable()

      $("#searchPage").click(function(){
       var page_no = $("#pag").val();              
       if( page_no !== '0' && page_no !== ''){
         setDataTable(page_no)

       }      
      });
     
   
      $(document).on('click','.remove-user', function(e){
        e.preventDefault();
        var url = $(this).data('url');
        $.confirm({
          title: '<?php echo lang('LBL_REMOVE_USER'); ?>',
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
                      $('#userlist').dataTable().fnDestroy();
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


