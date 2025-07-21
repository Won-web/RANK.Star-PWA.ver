<?php include("includes/header.php") ?>
<title><?php echo lang("CONTEST"); ?></title>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?php echo lang('CONTENT_MANAGEMENT'); ?></h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "dashboard"; ?>"><?php echo lang('LBL_HOME'); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "contest"; ?>"><?php echo lang('CONTENT_MANAGEMENT'); ?></a></li>
                <li class="breadcrumb-item active"><?php echo lang('ADD_CONTEST'); ?></li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
   <!-- /.container-fluid -->
</div>
<section class="content">
   <div class="container-fluid">
   <!-- SELECT2 EXAMPLE -->
   <div class="card card-default">
      <div class="card-header">
         <h3 class="card-title"><?php echo lang("ADD_CONTEST") ?></h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <?php if (!empty($this->session->flashdata('error'))) : ?>
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-ban"></i> <?php echo lang('LBL_ERROR'); ?></h5>
        <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
         <form action="<?php echo BASE_URL . "contest/savecontest"; ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="contest_name"><?php echo lang("NAME_OF_CONTEST") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" class="form-control" name="contest_name" value="<?php echo set_value('contest_name', ''); ?>" id="exampleInputEmail1" placeholder="<?php echo lang("NAME_OF_CONTEST") ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="vote_open_date"><?php echo lang("VOTE_OPEN_DATE") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <!-- <input type="date" class="form-control" name="vote_open_date" value="<?php echo set_value('vote_open_date', ''); ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_OPEN_DATE") ?>"> -->
                        <input type="datetime-local" class="form-control" name="vote_open_date" value="<?php echo set_value('vote_open_date', ''); ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_OPEN_DATE") ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="vote_close_date"><?php echo lang("VOTE_CLOSING_DATE") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <!-- <input type="date" class="form-control" name="vote_close_date" value="<?php echo set_value('vote_close_date', ''); ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_CLOSING_DATE") ?>">  -->
                        <input type="datetime-local" class="form-control" name="vote_close_date" value="<?php echo set_value('vote_close_date', ''); ?>" id="exampleInputEmail1" placeholder="<?php echo lang("VOTE_CLOSING_DATE") ?>"> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label><?php echo lang("STATUS") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <select class="form-control select2" name="status" value="" style="width: 100%;">
                            <option value=""><?php echo lang("LBL_SELECT") ?></option>
                            <option value="open" <?php echo set_select('status','open', False); ?>><?php echo lang("OPEN") ?></option>
                            <option value="close"  <?php echo set_select('status','close', False); ?>><?php echo lang("CLOSE") ?></option>
                            <option value="preparing"  <?php echo set_select('status','preparing', False); ?>><?php echo lang("PREPARING") ?></option>
                        </select>
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
                        <!-- <input type="text" class="form-control" name="category_name" placeholder="" value="" id="tagInput"> -->
                        <input type="text" class="form-control" name="category_name" id="tagInput" placeholder="<?php echo lang('LBL_CATEGORY_NAME');?>" value="">
                        <span class="cat-info-text"><b>Info:</b><?php echo lang('info'); ?> </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="description"><?php echo lang("CONTEST_DESCRIPTION") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <div class="card card-outline card-info">
                            <div class="card-body pad">
                                <div class="mb-3">
                                    <!-- <textarea class="textarea" name="description" placeholder="<?php echo lang("CONTEST_DESCRIPTION") ?>" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                    <textarea id="description" name="description" placeholder="<?php echo lang("CONTEST_DESCRIPTION") ?>">
                                    <?php echo set_value('description'); ?> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="main_banner"><?php echo lang("MAIN_BANNER") ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                            <input type="file" name="main_banner" class="custom-file-input" id="exampleInputFile" accept="image/*">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="main_banner"><?php echo lang("SHOW_MAIN_BANNER") ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                            <input type="checkbox" name="show_main_banner" id="show_main_banner" value="true" <?php echo set_checkbox('show_main_banner', 'true', FALSE); ?>>
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
                <input type="checkbox" name="hide_contest"  data-bootstrap-switch data-on-text="<?php echo lang('HIDE')?>" data-off-text="<?php echo lang('SHOW')?>" value="Hide" data-off-color="primary" data-on-color="danger" <?php echo set_checkbox('hide_contest', 'Hide', FALSE); ?>>
               
            </div>
            </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sub_banner"><?php echo lang("SUB_BANNER") ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                            <input type="file" name="sub_banner" class="custom-file-input" id="exampleInputFile"  accept="image/*">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
               <!-- <div class="col-md-4">
                  <div class="form-group">
                    <button type="button" class="btn btn-primary"></button>
                  </div>
                  </div> -->
            </div>
            <!-- <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="home_page"><?php // echo lang("HOME_PAGE_BANNER") ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="home_page" class="custom-file-input">
                                <label class="custom-file-label" for="home_page">Choose file</label>
                            </div>
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
                        <input type="text" name="home_page" class="form-control" id="exampleInputEmail1" value="<?php echo set_value('home_page', ''); ?>" placeholder="<?php echo lang("HOME_PAGE") ?>"> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="partner"><?php echo lang("PARTNER") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" name="partner" class="form-control" id="exampleInputEmail1" value="<?php echo set_value('partner', ''); ?>" placeholder="<?php echo lang("PARTNER") ?>"> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fees_percent"><?php echo lang("FEES") ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="fees_percent" class="form-control" id="exampleInputEmail1" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="<?php echo set_value('fees_percent', '0'); ?>" placeholder="<?php echo lang("FEES") ?>">
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="cost"><?php echo lang("COST") ?></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" name="cost" class="form-control" id="exampleInputEmail1" value="<?php echo set_value('cost', '0'); ?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="<?php echo lang("COST") ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="memo"><?php echo lang("MEMO") ?></label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <input type="text" name="memo" class="form-control" id="exampleInputEmail1" value="<?php echo set_value('memo', ''); ?>" placeholder="<?php echo lang("MEMO") ?>">
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary"><?php echo lang("SUBMIT") ?></button>
                <!-- /.card-body -->
         </form>
         </div>
      </div>
      <!-- /.container-fluid -->
</section>
<!-- Main content -->
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include("includes/footer.php") ?>
<script type="text/javascript">
    function fileUploadError() {
        var toastmsg = "<?php echo $this->session->flashdata('file_upload_error'); ?>";
        console.log(toastmsg);
        if (toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.error(toastmsg);
        }
    }
    $(document).ready(function() {
        fileUploadError();
        bsCustomFileInput.init();
        // $R('#description', {
        //     buttons: ['html', 'format', 'bold', 'italic', 'deleted', 'lists', 'image'],
        //     maxHeight: '800px',
        //     plugins: ['video'],
        //     imageUpload: "<?php // echo BASE_URL . "contest/addDescriptionImage"; ?>"
        // });
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
    });
    // $(function() {
    //     $('.textarea').summernote()
    // });
    // $('#tagInput').tagator({
    //     showAllOptionsOnFocus: true,
    //     autocomplete: []
    // });
    var tagInput = document.querySelector('input[name="category_name"]'),
    tagify = new Tagify(tagInput, {
        whitelist: [],
        maxTags: 1000,
        dropdown: {
            maxItems: 5,           // <- mixumum allowed rendered suggestions
            classname: "tags-look", // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: true    // <- do not hide the suggestions dropdown once an item has been selected
        }
    });
</script>