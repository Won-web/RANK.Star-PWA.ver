<?php
// echo '<pre>';
include("includes/header.php") ?>

<title><?php echo lang("CONTEST"); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"><?php echo lang('CONTENT_MANAGEMENT'); ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo lang('CONTENT_MANAGEMENT'); ?></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?php echo lang("CONTEST_LIST") ?></h3>
        <div class="add_button">
          <?php if ($userData['user_type'] == "admin") { ?>
            <a href="<?php echo BASE_URL . "contest/addcontest"; ?>"><button type="button" class="btn btn-primary"><?php echo lang("ADD_CONTEST") ?></button></a>
          <?php  }  ?>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="contestlist" class="table table-bordered table-striped">
          <thead>
            <tr>
            <th><?php echo lang("SERIAL_NO") ?></th>
                <th><?php echo lang("SHOW_MAIN_BANNER") ?></th>
              <th><?php echo lang("NAME_OF_CONTEST") ?></th>
              <th><?php echo lang("VOTE_OPEN_DATE") ?></th>
              <th><?php echo lang("VOTE_CLOSING_DATE") ?></th>
              <th><?php echo lang("CONTESTANT_COUNT") ?></th>
              <th><?php echo lang("VOTING_COUNT") ?></th>
              <th><?php echo lang("STATUS") ?></th>
              <th><?php echo lang("MAPPING") ?></th>
              <th><?php echo lang("HIDE_CONTEST")?></th>
              <th><?php echo lang("LBL_ACTION") ?></th>
            </tr>
          </thead>
          <tbody>
         
          </tbody>
        </table>
      </div>
      <div class="exampleModalLabel"></div>

      <!-- /.card-body -->
    </div>
    <!-- Main content -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include("includes/footer.php") ?>

<script type="text/javascript">
    function contestmsg() {
        var toastmsg = "<?php echo $this->session->flashdata('contest_msg'); ?>";
        if (toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.success(toastmsg);
        }
    }

    function contestupdatemsg() {
        var toastmsg = "<?php echo $this->session->flashdata('contest_update_msg'); ?>";
        if (toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.success(toastmsg);
        }
    }

    function setContestDataTable() {
        $('#contestlist').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "oLanguage": {
  "sZeroRecords": "<?php echo lang('No matching records found'); ?>",
  "sInfo": "<?php echo lang('Record'); ?> _TOTAL_ ",
  "sInfoEmpty": "<?php echo lang('Record'); ?> 0",
  "sSearch":  "<?php echo lang("Search");?>",
  "oPaginate": {
            "sNext":    "<?php echo lang("Next");?>",
            "sPrevious": "<?php echo lang("Previous");?>"
        },
},
            "columns": [
                {
                "orderable": false
                },
                {
                "orderable": false
                },
                null,
                null,
                null,
                null,
                null,
                {
                "orderable": false
                },
                {
                "orderable": false
                },
                null,
                {
                "orderable": false
                }
            ],
            "info": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo base_url("contest/contestList") ?>",
                type: 'POST',
                beforeSend:function() {
                    startLoader();
                },
                complete: function() {
                    stopLoader();
                },
               
            },
            "fnDrawCallback": function() {
                $("[name='hide_contest']").bootstrapSwitch({size: "small", onColor:"danger", offColor:"primary",  onText: '<?php echo lang("HIDE")?>', offText: '<?php echo lang("SHOW")?>'});
              }, 
              
              
        });
    }

    $(document).ready(function() {
    contestmsg();
    contestupdatemsg();
    setContestDataTable();
    $('#contestlist').on('switchChange.bootstrapSwitch', 'input[name="hide_contest"]', function(event, state) {
        var value = 'Show';
        var contestId  = $(this).attr('data-id');
        if ($(this).is(":checked")) {
            var value = $(this).val();
        }
        $.ajax({
                url: "<?php echo base_url("contest/hideContest") ?>",
                type: 'POST',
                data: {
                    'contestId': contestId,
                    'value' : value
                }
            });

});

    $(document).on('click', '.mappingContestant', function() {
        var id = $(this).attr('data-id');
        $(".exampleModalLabel").html('');
        $.ajax({
            url: "<?php echo base_url("contest/mapping") ?>",
            type: 'POST',
            data: {
                'contest_id': id
            },
            success: function(resp) {
                $(".exampleModalLabel").html(resp);
                $("#exampleModalLabel").modal('show');
                $("#contestId").val(id);
                // $("#selectAll").on('click', function() {
                //     if ($(this).hasClass('allChecked')) {
                //         $('input[type="checkbox"]', '.table').prop('checked', false);             
                //     } else {
                //         $('input[type="checkbox"]', '.table').prop('checked', true);
                //     } 
                //     $(this).toggleClass('allChecked');
                // }); 
                $("#selectAll").change(function() {
        if (this.checked) {
            $(".contestCheckbox").each(function() {
                this.checked=true;
            });
        } else {
            $(".contestCheckbox").each(function() {
                this.checked=false;
            });
        }
    });
    
            }
        });
    });
    $(document).on('click', '.deleteContest', function() {
        var isYes = confirm("Are you sure you want delete this contest?");
        console.log(isYes);
        if(isYes) {
            var contestId = $(this).attr('data-id');
            console.log(contestId);
            
            $.ajax({
                url: "<?php echo base_url("contest/deleteContest") ?>",
                type: 'POST',
                data: {
                    'contestId': contestId
                },
                success: function(res) {
                    if(res.res_code == 1){
                        $('#contestlist').dataTable().fnDestroy();
                        toastr.success(res.res_message);
                        setContestDataTable();
                    } else {
                        toastr.error(res.res_message);
                    }
                }
            });
        }
    });
    $(document).on('click', '#show_main_banner', function() {
        var value = 'false';
        var contestId  = $(this).attr('data-id');
        if ($(this).is(":checked")) {
            var value = $(this).val();
        }
        $.ajax({
                url: "<?php echo base_url("contest/selectMainBanner") ?>",
                type: 'POST',
                data: {
                    'contestId': contestId,
                    'value' : value
                }
            });
    });
   
  });
</script>