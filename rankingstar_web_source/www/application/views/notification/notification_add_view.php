<?php
//    print_r($contestantList);exit();
include(APPPATH . "views/includes/header.php"); ?>
<title><?php echo lang('LBL_SEND_NOTIFICATION'); ?></title>
<!-- Content Wrapper. Contains page content -->
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?php echo lang('LBL_SEND_NOTIFICATION'); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('LBL_SEND_NOTIFICATION'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- <div class="col-3"></div> -->
            <div class="col-10">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php if (!empty($this->session->flashdata('error'))) : ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> <?php echo lang('LBL_ERROR'); ?></h5>
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                        <?php endif; ?>
                        <?php
                        $attr = array('id' => 'sendNotificationForm');
                        echo form_open('', $attr);
                        ?>
                        <input type="hidden" name="senderId" value="<?php echo $userData['user_id'] ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="messageTitle"><?php echo lang('LBL_MESSAGE_TITLE'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="messageTitle" id="messageTitle"
                                        value="<?php echo set_value('messageTitle', ''); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="message"><?php echo lang('LBL_MESSAGE'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="message" id="message"
                                        value="<?php echo set_value('message', ''); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="multiContestant"><?php echo lang('LBL_SELECT_CONTESTANT'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card" id="selectedUserCard" style="display: none;">
                                    <div id="selectedUser" class="my-1"></div>
                                </div>
                                <table id="contestantList" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang("LBL_SELECT") ?></th>
                                            <th><?php echo lang("NAME") ?></th>
                                            <th><?php echo lang("EMAIL") ?></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9">
                                <input type="submit" class="btn btn-primary" name="submit"
                                    value="<?php echo lang('LBL_SEND_NOTIFICATION'); ?>">
                                    
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
$(document).ready(function() {
    var selectedUser = [];

    setContestDataTable();
          
    function setContestDataTable() {
        $('#contestantList').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "order": [2, 'asc'],
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
                    "orderable": false,
                    render: function ( data, type, row, meta ) {
                        var checked = selectedUser.indexOf(row['user_id']) !== -1 ? 'checked': '';
                        var select_contestant = '<input type="hidden" id="contestant-name" value="'+row['name']+'"><input type="hidden" id="contestant-email" value="'+row['email']+'"><input type="checkbox" class="selectContestantClass"  name="select_contestant" id="select_contestant" value="true" data-id="'+row['user_id']+'" data-value="true" '+checked+'>';
                        return select_contestant;
                    },
                },
                { data: 'name' },
                { data: 'email' },
            ],
            "info": true,
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "<?php echo base_url("notification/getListOfUser") ?>",
                type: 'POST',
                beforeSend:function() {
                    startLoader();
                },
                complete: function(response) {
                    stopLoader();
                },
               
            },
        });
    }

    $(document).on('click', '#select_contestant', function() {
        var contestantId  = $(this).attr('data-id');
        var contestantName = $(this).closest('td').find('#contestant-name').val();
        var contestantEmail = $(this).closest('td').find('#contestant-email').val();

        var itemIndex = selectedUser.indexOf(contestantId)
        if(itemIndex === -1){
            //create tag
            var tag = '<span id="contestantTagId-'+contestantId+'" class="badge badge-pill badge-dark mx-1">'+contestantEmail+'<span id="closeTag" class="mx-1" data-id="'+contestantId+'">&times;</span></span>'

            //add tag
            $("#selectedUser").append(tag);
            selectedUser.push(contestantId);
        }else{
            //remove tag and remove element from array
            $("#contestantTagId-"+contestantId).remove();
            selectedUser.splice(itemIndex, 1);
        }
    });

    // when "tagClose" button click ==> remove that tag from list and from array to 
    $(document).on('click', '#closeTag', function() {
        var contestantId  = $(this).attr('data-id');
        //uncheck checkbox in datatable
        $('[id="select_contestant"]').filter('[data-id="'+contestantId+'"]').prop('checked', false);

        var itemIndex = selectedUser.indexOf(contestantId)

        //remove tag
        $("#contestantTagId-"+contestantId).remove();
        selectedUser.splice(itemIndex, 1);
    });

    //show card if innerHtml exists
    $('#selectedUser').on('DOMSubtreeModified', function(){
        var htmlstring = this.innerHTML;
        // use the native .trim() if it exists
        //   otherwise use a regular expression  
        htmlstring = (htmlstring.trim) ? htmlstring.trim() : htmlstring.replace(/^\s+/,'');

        if(htmlstring !== '') {
            //show card
            $("#selectedUserCard").show();
        }else{
            // hide card
            $("#selectedUserCard").hide();
        }
    });

    $("#sendNotificationForm").submit(function(event) {
        event.preventDefault();
        var messageTitle = $("#messageTitle").val();
        var message = $("#message").val();        
        
        if (messageTitle !== "" && message !== "") {
            if(selectedUser.length > 0){
                $.ajax({
                    url: "<?php echo base_url("notification/sendPushNotification") ?>",
                    type: 'POST',
                    data: {
                        'messageTitle': messageTitle,
                        'message': message,
                        'senderId': <?php echo $userData['user_id'] ?> ,
                        'multiContestant': selectedUser
                    },
                    beforeSend: function() {
                        startLoader();
                    },
                    success: function(res) {},
                    complete: function(res) {
                        stopLoader();
                        $("#sendNotificationForm")[0].reset();
                        // $( "#multiContestant" ).val("");
                        $('.multiselect-selected-text').text('None selected');
                        toastr.success("<?php echo $this->lang->line('MSG_PUSH_NOTIFICATION_SUCCESS'); ?>");
                    },
                });
            }else{
                toastr.error("<?php echo $this->lang->line('MSG_SELECT_ATLEAST_ONE_CONTESTANT'); ?>");
            }
        } else {
            toastr.error("<?php echo $this->lang->line('MSG_ALL_FIELD_REQUIRED'); ?>");
        }
    });
});
</script>