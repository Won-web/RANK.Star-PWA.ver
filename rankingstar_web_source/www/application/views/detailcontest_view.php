<?php
// print_r($detail); exit();
include("includes/header.php");
?>
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
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "contest"; ?>"><?php echo lang('CONTENT_MANAGEMENT'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo lang('DETAIL_OF_CONTEST'); ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
  <section class="content">
    <div class="container-fluid">
      <!-- SELECT2 EXAMPLE -->
      <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title"><?php echo lang("DETAIL_OF_CONTEST") ?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <form action="<?php echo BASE_URL . "contest/editcontest"; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="contest_id" value="<?php echo $detail[0]['contest_id'] ?>">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("NAME_OF_CONTEST") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <input type="text" class="form-control" name="contest_name" value="<?php echo ($detail[0]['contest_name']) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("NAME_OF_CONTEST") ?>" required>
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang("CONTESTANT_STATUS") ?></label>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="total_contestant"  readonly="readonly" value="<?php echo ($totalcontestant[0]['Total_contestant'] ) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("NAME_OF_CONTEST") ?>" required>
                </div>
                <div class="col-md-3">
                    <a href="<?php echo BASE_URL . "contestant?id=".$detail[0]['contest_id']; ?>" id="contestantListId">
                        <button type="button" name="totalcontestant" class="btn btn-success col-md-12">
                            <?php echo lang("GO_LIST") ?>
                        </button>
                    </a>
                </div>
                <?php if ($userData['user_type'] == "admin") { ?>
                <div class="col-md-3">
                    <a href="<?php echo BASE_URL . "contestant/addcontestant/".$detail[0]['contest_id']; ?>" id="addContestantId">
                        <button type="button" class="btn btn-success col-md-12"><?php echo lang("ADD_CONTESTANT") ?>
                        </button>
                    </a>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                    <label><?php echo lang("STATUS") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <select class="form-control select2" name="status" value="<?php echo ($detail[0]['status']) ?>" style="width: 100%;">
                            <option value="open" <?php if ($detail[0]['status'] == "open") echo 'selected="selected"'; ?>><?php echo lang("OPEN") ?></option>
                            <option value="close" <?php if ($detail[0]['status'] == "close") echo 'selected="selected"'; ?>><?php echo lang("CLOSE") ?></option>
                            <option value="preparing" <?php if ($detail[0]['status'] == "preparing") echo 'selected="selected"'; ?>><?php echo lang("PREPARING") ?></option>
                        </select>
                        <input type="hidden" name="previousStatus" value="<?php echo ($detail[0]['status']) ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang("VOTE_OPEN_DATE") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <!-- <input type="date" class="form-control" name="vote_open_date" value="<?php //echo ($detail[0]['vote_open_date']) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_OPEN_DATE") ?>" required> -->
                        <!-- <input type="date" class="form-control" name="vote_open_date" value="<?php //echo ($detail[0]['vote_open_date']) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_OPEN_DATE") ?>" required> -->
                        <input type="datetime-local" class="form-control" name="vote_open_date" 
                            value="<?php $detail[0]['vote_open_date'] = preg_replace("/\s/",'T',$detail[0]['vote_open_date']); 
                            echo $detail[0]['vote_open_date']?>" 
                            id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_OPEN_DATE") ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang("VOTE_CLOSING_DATE") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <!-- <input type="date" class="form-control" name="vote_close_date" value="<?php //echo ($detail[0]['vote_close_date']) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_CLOSING_DATE") ?>" required>  -->
                        <!-- <input type="datetime-local" class="form-control" name="vote_close_date" value="<?php //echo ($detail[0]['vote_close_date']) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_CLOSING_DATE") ?>" required>  -->
                        <input type="datetime-local" class="form-control" name="vote_close_date" 
                            value="<?php $detail[0]['vote_close_date'] = preg_replace("/\s/",'T',$detail[0]['vote_close_date']); echo $detail[0]['vote_close_date']?>" 
                            id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_CLOSING_DATE") ?>" required> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="category_name"><?php echo lang('LBL_CATEGORY_NAME');?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <!-- <input type="text" name="category_name" placeholder="" value="<?php echo implode(",",$categoryArr); ?>"> -->
                        <input type="text" class="form-control" name="category_name" placeholder="" value="<?php echo implode(",",$categoryArr); ?>" id="category_name">
                        <!-- <input id="tagInput" name="category_name" type="text" class="tagator form-control" value="Manoj,Amit"> -->
                        <span class="cat-info-text"><b>Info:</b> <?php echo lang('info'); ?></span>
                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo lang("CONTEST_DESCRIPTION") ?></label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <div class="card card-outline card-info">
                                <div class="card-body pad">
                                    <div class="mb-3">
                                        <!-- <textarea class="textarea" name="description" value="<?php echo ($detail[0]['description']); ?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                        <textarea id="description" name="description" placeholder="<?php echo lang("CONTEST_DESCRIPTION") ?>">
                                        <?php echo ($detail[0]['description']); ?>
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputFile"><?php echo lang("MAIN_BANNER") ?></label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="main_banner" class="custom-file-input" id="exampleInputFile" accept="image/*">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mainbanner"><?php echo lang("PREVIEW") ?></button>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-lg" id="mainbanner" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                        <div class="modal_image">
                            <img src="<?php echo CON_CONTEST_URL . $detail[0]['main_banner'] ?>" style="width:100%">
                        </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="loginUserId" value="<?php echo $userData['user_id']; ?>">
                <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="main_banner"><?php echo lang("SHOW_MAIN_BANNER") ?></label>
                    </div>
                </div>
                <div class="col-md-7">
                <div class="form-group">
                            <input type="checkbox" name="show_main_banner" id="show_main_banner" value="true" <?php if($detail[0]['show_main_banner'] == 'true') { echo 'checked="checked"';} ?>>
                        </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="main_banner"><?php echo lang("HIDE_CONTEST") ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                                 <input type="checkbox" name="hide_contest"  data-bootstrap-switch data-on-text="<?php echo lang('HIDE')?>" data-off-text="<?php echo lang('SHOW')?>" value="Hide"  data-off-color="primary" data-on-color="danger" <?php if($detail[0]['hide_contest'] == 'Hide') { echo 'checked="checked"';} ?>>
                                 <!-- <label class="switch">
                    <input type="checkbox" id="togBtn" name="hide_contest" value="Hide" <?php if($detail[0]['hide_contest'] == 'Hide') { echo 'checked="checked"';} ?>>
                    <div class="slider round"><span class="on"><?php echo lang('HIDE')?></span>
                    <span class="off"><?php echo lang('SHOW')?></span></div>
                </label>    -->
                                </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                        <label for="exampleInputFile"><?php echo lang("SUB_BANNER") ?></label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                            <input type="file" name="sub_banner" class="custom-file-input" id="exampleInputFile" accept="image/*">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#subbanner"><?php echo lang("PREVIEW") ?></button>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-lg" id="subbanner" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                        <div class="modal_image">
                            <img src="<?php echo CON_CONTEST_URL . $detail[0]['sub_banner'] ?>" style="width:100%">
                        </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="home_page"><?php // echo lang("HOME_PAGE_BANNER") ?></label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="home_page" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    <input type="hidden" name="sub_banner" value="<?php // echo ($detail[0]['home_page_image']) ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#homeBanner"><?php // echo lang("PREVIEW") ?></button>
                        </div>
                    </div>
                    <div class="modal fade bd-example-modal-lg" id="homeBanner" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                        <div class="modal_image">
                            <img src="<?php // echo CON_CONTEST_URL . $detail[0]['home_page_image'] ?>" style="width:100%">
                        </div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="home_page"><?php echo lang("HOME_PAGE") ?></label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="text" name="home_page" value="<?php echo ($detail[0]['home_page']) ?>" class="form-control" id="home_page" placeholder="<?php echo lang("HOME_PAGE") ?>"> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo lang("PARTNER") ?></label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="text" name="partner" class="form-control" value="<?php echo ($detail[0]['partner']) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("PARTNER") ?>"> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo lang("FEES") ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="fees_percent" class="form-control" value="<?php echo ($detail[0]['fees_percent']) ?>" id="exampleInputEmail1" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="<?php echo lang("FEES") ?>" required>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo lang("COST") ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class=" form-group">
                            <input type="text" name="cost" class="form-control" value="<?php echo ($detail[0]['cost']) ?>" id="exampleInputEmail1" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="<?php echo lang("COST") ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><?php echo lang("MEMO") ?></label>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="text" name="memo" class="form-control" value="<?php echo ($detail[0]['memo']) ?>" id="exampleInputEmail1" placeholder="<?php echo lang("MEMO") ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php if ($userData['user_type'] == "admin") { ?>
                            <button type="submit" name="submit" class="btn btn-warning"><?php echo lang("EDIT") ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
          </form>
        </div>
     
    </div><!-- /.container-fluid -->
    <div>
    </div>
</section>
<!-- Main content -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include("includes/footer.php") ?>
<script type="text/javascript">
    function fileUploadError() {
        var toastmsg = "<?php echo $this->session->flashdata('file_upload_error'); ?>";
        if (toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.error(toastmsg);
        }
    }
    $(document).ready(function() {
        fileUploadError();
        bsCustomFileInput.init();
        localStorage.removeItem('contest_id');

        //$('#textarea-id').data("wysihtml5").editor.setValue('new content');
        $('#description').redactor({
            buttons: ['html', 'format', 'bold', 'italic', 'deleted', 'lists', 'image'],
            maxHeight: '800px',
            plugins: ['video'],
            imageUpload: "<?php echo BASE_URL . "contest/addDescriptionImage"; ?>",
            callbacks: {
                image: {
                    delete: function(image)
                    {
                        //console.log(image);
                        return true;
                    }
                }
            }
        });
        $('#contestantListId, #addContestantId').click(() => {
            console.log('contestantListId');
            activeSideMenu('contestant');
        });
    });
    $(function() {
    // Summernote
    //$('.textarea').summernote();
    // $('.textarea').summernote('code', content);

    //var HTMLstring = '<div><p>Hello, world</p><p>Summernote can insert HTML string</p></div>';
    // $('.textarea').summernote('code', content);
    });
    
    var input = document.querySelector('input[name="category_name"]'),
    // init Tagify script on the above inputs
    tagify = new Tagify(input, {
        whitelist: [],
        maxTags: 1000,
        dropdown: {
            maxItems: 20,           // <- mixumum allowed rendered suggestions
            classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: true    // <- do not hide the suggestions dropdown once an item has been selected
        }
    });    
    tagify.on('remove', function(e, tagName) {
        let categoryName = e['detail']['data']['value'];
        let contestId = <?php echo $detail[0]['contest_id']; ?>;
        deleteCategory(contestId, categoryName);
    });
    function deleteCategory(contestId, categoryName) {
        $.ajax({
            url: "<?php echo base_url(); ?>/Contest/deleteCategory",
            method: "POST",
            data: { 
                contestId : contestId,
                categoryName: categoryName
            },
            success:function(data)
            {
                if(data['res_code'] === 1) {
                    alert(data['res_message']);
                } else {
                    alert(data['res_message']);
                }
            }
        });
    }
</script>