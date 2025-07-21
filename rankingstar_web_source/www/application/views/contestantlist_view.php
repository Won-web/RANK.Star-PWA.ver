<?php
// print_r($contest_id);exit();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (isset($_GET['contestid'])) {
    $contestantid = $_GET['contestid'];
}
include("includes/header.php") ?>
<style>
     .deleteicon { display:inline !important; }
       .thumb-img {
width : 30px;
height : 30px;
border-radius : 10px;

	}
	#contestantlist > tbody > tr > td:nth-child(4) {
		text-align : center;
	}
</style>
<title><?php echo lang("CONTESTANT"); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?php echo lang('CONTESTANT_MANAGEMENT'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('CONTESTANT_MANAGEMENT'); ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo lang("CONTESTANT_LIST") ?></h3>
                <div class="add_button">
                    <?php if ($userData['user_type'] == "admin") {  if (isset($_GET['contestid'])) { ?> 
                     <a href="<?php echo BASE_URL . "contestant/addcontestant/".$contestantid ?>"><button type="button" class="btn btn-primary"><?php echo lang("ADD_CONTESTANT") ?></button></a>
                     <?php }else if(isset($_GET['id'])){ ?>
                        <a href="<?php echo BASE_URL . "contestant/addcontestant/".$id ?>"><button type="button" class="btn btn-primary"><?php echo lang("ADD_CONTESTANT") ?></button></a>

                      <?php } else{?>
                        <a href="<?php echo BASE_URL . "contestant/addcontestant" ?>"><button type="button" class="btn btn-primary"><?php echo lang("ADD_CONTESTANT") ?></button></a>
                    <?php  } } ?>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="contestantlist" class="table table-bordered table-striped">
                    <div class="row">
                        <?php if (isset($_GET['contestid'])) { ?>
                            <div class="col-md-4">
                                <select id="contest_dropdown" name="contest_name" class="form-control">
                                    <option value=""><?php echo lang("SELECT_NAME_OF_CONTEST") ?></option>
                                    <?php foreach ($contestList as $contest) { ?>
                                        <option value="<?php echo $contest['contest_id'] ?>" <?php if ($contest['contest_id'] == $contestantid) echo 'selected="selected"'; ?>><?php echo ($contest['contest_name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else if (isset($_GET['id'])) { ?>
                            <div class="col-md-4">
                                <select id="contest_dropdown" name="contest_name" class="form-control">
                                    <option value=""><?php echo lang("SELECT_NAME_OF_CONTEST") ?></option>
                                    <?php foreach ($contestList as $contest) { ?>
                                        <option value="<?php echo $contest['contest_id'] ?>" <?php if ($contest['contest_id'] == $id) echo 'selected="selected"'; ?>><?php echo ($contest['contest_name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>  
                        <?php   } else if($contest_id){ ?>
                            <div class="col-md-4">
                            <select id="contest_dropdown" name="contest_name" class="form-control">
                                    <option value=""><?php echo lang("SELECT_NAME_OF_CONTEST") ?></option>
                                    <?php foreach ($contestList as $contest) { ?>
                                        <option value="<?php echo $contest['contest_id'] ?>" <?php if ($contest['contest_id'] == $contest_id) echo 'selected="selected"'; ?>><?php echo ($contest['contest_name']); ?></option>
                                    <?php } ?>
                                </select>
                                </div> 
                      <?php  } else { ?>
                            <div class="col-md-4">
                                <select id="contest_dropdown" name="contest_name" class="form-control">
                                    <option value=""><?php echo lang("SELECT_NAME_OF_CONTEST") ?></option>
                                    <?php foreach ($contestList as $contest) { ?>
                                        <option value="<?php echo $contest['contest_id'] ?>"><?php echo ($contest['contest_name']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                    </div>
                    <thead>
                        <tr>
                        <th><?php echo lang("SERIAL_NO") ?></th>
                            <th><?php echo lang("RANKING") ?></th>
                            <th><?php echo lang("NAME_OF_CONTEST") ?></th>
				<th class="text-center">이미지</th>
                            <th><?php echo lang("CONTESTANT_NAME") ?></th>
                            <th><?php echo lang("VOTE") ?></th>
                            <th><?php echo lang("REGISTRATION_DATE") ?></th>
                            <th><?php echo lang("LBL_MODIFIED_DATE") ?></th>
                            
                            <th class="deleteContestant"><?php echo lang("LBL_ACTION") ?></th>
                            </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- Main content -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="detail_title">Modal Header</h4>
      </div>
      <div class="modal-body text-center">
	<img id="detail_image" style="width : 100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<!-- /.content-wrapper -->

<?php include("includes/footer.php") ?>

<script type="text/javascript">
    function contestantmsg() {
        var toastmsg = "<?php echo $this->session->flashdata('contestant_msg'); ?>";
        if (toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.success(toastmsg);
        }
    }

    function contestantupdatemsg() {
        var toastmsg = "<?php echo $this->session->flashdata('contestant_update_msg'); ?>";
        if (toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.success(toastmsg);
        }
    }

    function errorMessage() {
        var toastmsg = "<?php echo $this->session->flashdata('error'); ?>";
        console.log(toastmsg);
        if (toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.error(toastmsg);
        }
    }
    function showImageModal(url, name, title){
	var html = name;
	if(title != "null" && title != ""){
                             html += " <small class='detail_small'>(" + title + ")</small>"
	}

	$("#detail_title").html(html);
	$("#detail_image").attr("src", url.replace("_thumb",""));
	$("#myModal").modal("show");
	}

    $(document).ready(function() {
        clearPageNO();
        contestantmsg();
        contestantupdatemsg();
        errorMessage();
        var contestId = $("#contest_dropdown").val();
        localStorage.setItem('contest_id', contestId);
       
        var isExecuted = false;
        function setDataTable(contest_id = '') {
            $('#contestantlist').DataTable({
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
                  [6, 'desc']
                ],
                "columns": [
                    {'orderable' : false},
                    null,
                    null,
		     {'orderable' : false, 'render':function(data, dis, row) {
			var url = window.location.href;
			var images = data.split("|");
			var src = url.split("/admin")[0] + "/assets/contestant_banner/" + images[0];
			var srcFull = url.split("/admin")[0] + "/assets/contestant_banner/" + images[1];
			return "<a href='javascript:void(0);' onclick='showImageModal(\"" + srcFull + "\", \"" + $(row[4]).text() +"\", \"" +  row[2]+ "\");'><img src='" + src + "' class='thumb-img'></a>";
		        }},
                    null,
                    null,
                    null,
                    null,
			
                    {'orderable' : false},
                ],
                "info": true,
                "autoWidth": false,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "<?php echo base_url("contestant/contestantlist") ?>",
                    type: 'POST',
                    data: {
                        'contest_id': contest_id
                    }
                },
            });
        }
        if (isExecuted == false) {
            var id = "<?php if (isset($id)) {  echo $id;} else if(isset($contestantid)){ echo $contestantid; }?>";
            setDataTable(id);
            isExecuted = true;
        }
        var contestId = $("#contest_dropdown").val();
        if($("#contest_dropdown").val().length != ''){
            $('#contestantlist').dataTable().fnDestroy();
            setDataTable(contestId);
        }
    
        $(document).on("change", "#contest_dropdown", function() {
            $('#contestantlist').dataTable().fnDestroy();
            var contestId = $(this).val();
                setDataTable(contestId);
                localStorage.setItem('contest_id', contestId);

        });

    
    //delete contestant
    $(document).on('click','.deleteContestant', function(e){
        var contestantId = $(this).attr('data-id');
        var contestId = $(this).attr('data-contestId');
        e.preventDefault();
        $.confirm({
            title: '<?php echo lang('LBL_DELETE_CONTESTANT'); ?>',
            content: '<?php echo lang('LBL_DELETE_CONTESTANT_CONFIRMATION'); ?>',
            buttons: {
            confirm: {
            text: '<?php echo lang('BTN_OK');?>',
                action: function () {
                    $.ajax({
                        url: "<?php echo base_url("contestant/deleteContestant") ?>",
                        method: 'POST',
                        data: {
                            'contestantId': contestantId,
                            'contestId': contestId,
                        },
                        success: function(res){
                            if(res.res_code == 1){
                                $('#contestantlist').dataTable().fnDestroy();
                                var contestId = $("#contest_dropdown").val();
                                if($("#contest_dropdown").val().length != ''){
                                    $('#contestantlist').dataTable().fnDestroy();
                                    setDataTable(contestId);
                                }else{
                                    setDataTable();
                                }
                                toastr.success(res.res_message);
                            } else {
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