<?php
$contest_id = $this->uri->segment(4);
// print_r($contestList);exit();
include("includes/header.php"); ?>
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
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL . "contestant"; ?>"><?php echo lang('CONTESTANT_MANAGEMENT'); ?></a></li>
            <li class="breadcrumb-item active"><?php echo lang('ADD_CONTESTANT'); ?></li>
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
          <h3 class="card-title"><?php echo lang("ADD_CONTESTANT") ?></h3>
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
          <form action="<?php echo BASE_URL . "contestant/savecontestant"; ?>" method="post" id="addContestant" enctype="multipart/form-data">
          <!-- <input type="hidden" id="gallaryId" name="gallary" value="1"> -->
            <div class="hiddenFields"></div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("CONTESTANT_NAME") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <input type="text" class="form-control" name="contestant_name" value="<?php echo set_value('contestant_name', ''); ?>" id="contestant_name" placeholder="<?php echo lang("CONTESTANT_NAME") ?>">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label><?php echo lang("NAME_OF_CONTEST") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <select class="form-control select2" name="contest_id" id="contestId" style="width: 100%;">
                    <option value=""><?php echo lang("SELECT_NAME_OF_CONTEST") ?></option>
                    <?php foreach ($contestList as $list) { ?>
                      <option value="<?php echo $list['contest_id'] ?>" <?php echo set_select('contest_id', $list['contest_id'], False); ?> <?php if($contest_id){ if($contest_id == $list['contest_id']){echo 'selected="selected"'; } }  ?>><?php echo $list['contest_name']  ?></option>
                    <?php } ?>
                  </select> </div>
              </div>
            </div>
            <input type="hidden" name="contestName" id="contestName">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>
                            <?php echo lang("LBL_CATEGORY"); ?>
                        </label>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <select class="form-control select2" id="contest_category_id" name="contest_category_id"  style="width: 100%;">
                            <option value=""><?php echo lang("LBL_SELECT_CATEGORY") ?></option>
                            <?php foreach($categoryList as $category){ ?> 
                            <option value="<?php echo $category['contest_category_id']?>" <?php echo set_select('contest_category_id', $category['contest_category_id'], False); ?>><?php echo $category['category_name'] ?></option>
                            <?php } ?>
                        </select> 
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("PHONE_NO") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <input type="text" class="form-control" name="mobile" value="<?php echo set_value('mobile', ''); ?>" id="mobile" placeholder="<?php echo lang("PHONE_NO") ?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("EMAIL") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <input type="email" class="form-control" name="email" value="<?php echo set_value('email', ''); ?>" id="email" placeholder="<?php echo lang("EMAIL") ?>">
                   </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputFile"><?php echo lang("MAIN_IMAGE") ?></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="main_image" class="custom-file-input" id="main_image" accept="image/*">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
                  <span class="cat-info-text"><b>Info:</b> <?php echo lang("MAX_WIDTH_INFO") ?></span>
                </div>
              </div>
            </div>               
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputFile"><?php echo lang("THUMB_IMAGE") ?></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="thumb_image" class="custom-file-input" id="thumb_image" accept="image/*">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label> 
                    </div>
                  </div>
                </div>
              </div>
            </div>
           
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("PROFILE") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="card">
                  <i class="fas fa-map"></i>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table table-condensed">
                      <thead>
                        <tr>
                          <th><?php echo lang("KEY") ?></th>
                          <th><?php echo lang("VALUE") ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><?php echo lang("AGE") ?></td>
                          <td>
                            <input type="text" class="form-control" name="age" value="<?php echo set_value('age', ''); ?>" id="age" placeholder="<?php echo lang("AGE") ?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo lang("HEIGHT") ?></td>
                          <td>
                            <input type="text" class="form-control" name="height" value="<?php echo set_value('height', ''); ?>" id="height" placeholder="<?php echo lang("HEIGHT") ?>">
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo lang("WEIGHT") ?></td>
                          <td>
                            <input type="text" class="form-control" name="weight" value="<?php echo set_value('weight', ''); ?>" id="weight" placeholder="<?php echo lang("WEIGHT") ?>">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("PROFILE_DETAIL") ?></label>
                </div>
              </div>
              <div class="col-md-5">

                <div class="input_fields_wrap">
                  <button type="button" name="addmore" value="submit" class=" btn btn-success add_field_button"><?php echo lang('ADD_MORE_FIELD'); ?></button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
              </div>
              <div class="col-md-10">
                <div class="card">
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <table class="table table-condensed dynamic_field">
                      <thead>
                        <tr>
                          <th><?php echo lang("KEY") ?></th>
                          <th><?php echo lang("VALUE") ?></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <input type="text" class="form-control" name="key[]" id="key">
                          </td>
                          <td>
                            <input type="text" class="form-control" name="value[]" id="value">
                          </td>
                          <td></td>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("INTRODUCTION_MESSAGE") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <input type="text" class="form-control" name="introduction" id="introduction" value="<?php echo set_value('introduction', ''); ?>" placeholder="<?php echo lang("INTRODUCTION_MESSAGE") ?>"> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputFile"><?php echo lang('IMAGE_GALLERY') ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <?php include("addgallary_view.php"); ?>
               
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputFile"><?php echo lang("VIDEO_GALLERY") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <?php include("addvideo_view.php"); ?>
                <!-- <div class="form-group">
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="media_name" class="custom-file-input" id="fileupload">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                  </div>
                </div> -->
              </div>
            </div>
           
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputFile"><?php echo lang("YOUTUBE") ?>
                  <div><h6>(<?php echo lang("UPTO_3") ?>)</h6></div>
                </label>
                 
                </div>
                
              </div>
              <div class="col-md-10 youtubeVideo">
               <div class="form-group">
                  <input type="text" class="form-control" name="videourl[]"  id="videourl1" placeholder="<?php echo lang("VIDEO_URL") ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="videourl[]"  id="videourl2" placeholder="<?php echo lang("VIDEO_URL") ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="videourl[]"  id="videourl3" placeholder="<?php echo lang("VIDEO_URL") ?>">
                </div>
              </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary"><?php echo lang("SUBMIT") ?></button>
            <!-- /.card-body -->
          </form>
        </div>

      </div><!-- /.container-fluid -->
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
    function dropdown() {
      var contestId = $('#contestId').val();
      console.log(contestId);
      
        var contestName = $('#contestId option:selected').text();
        $("#contestName").val(contestName);
        if(contestId !== '') {
            $.ajax({
                url:"<?php echo base_url(); ?>/Contestant/getCategoryFromContest",
                method:"POST",
                data:{ contestId : contestId },
                success:function(data)
                {
                    if(data['res_code'] === 1) {
                        let catArr = data['res_data']['categoryData'];
                        let html = '';
                        $('#contest_category_id').html("<option value=''><?php echo lang('LBL_SELECT_CATEGORY') ?></option>");
                        for (let index = 0; index < catArr.length; index++) {
                            const catEl = catArr[index];
                            html = "<option value="+catEl['contest_category_id']+">"+catEl['category_name']+"</option>";
                            $('#contest_category_id').append(html);
                        }
                    } else {
                        $('#contest_category_id').html("<option value=''><?php echo lang('LBL_SELECT_CATEGORY') ?></option>");
                    }
                }
            });
        }
        else {
            $('#contest_category_id').html("<option value=''><?php echo lang('LBL_SELECT_CATEGORY') ?></option>");
        }
    }
  $(document).ready(function() {
    // localStorage.removeItem('contest_id');
    var a = localStorage.getItem('contest_id'); 
    if(a){
      if(a.length !== 0){
      $("#contestId").val(a);
    }
    }
    
    localStorage.removeItem('contest_id');
    fileUploadError();
    bsCustomFileInput.init();
    dropdown();

    // adding mmore text fields

    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $(".dynamic_field"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var remove_button = $(".remove_field_button");
    var x = 1; //initlal text box count
    $(add_button).click(function(e) { //on add input button click
      e.preventDefault();
      if (x < max_fields) { //max input box allowed
        x++; //text box increment
        $(wrapper).append('<tbody><tr id="remove"><td class="add_fields_main"><input type="text" class="form-control" name="key[]" id="key"></td><td><input type="text" class="form-control" name="value[]" id="value"><td><a href="#" class="remove_field">x</a></td></tr></tbody>'); //add input box
      }
    });
    $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
        e.preventDefault();
        $('#remove').remove();
        x--;
    });
     
 
  /* add more video url ends here */

    $('#contestId').change(dropdown);

    $("#addContestant").submit(function(){      
      var urlarray=[];
      url = $("#videourl1").val();
      url2 = $("#videourl2").val();
      url3 = $("#videourl3").val();
      if(url !== "") {
        urlarray.push(url);
      }
      if(url2 !== "") {
        urlarray.push(url2);
      }
      if(url3 !== "") {
        urlarray.push(url3);
      }
      if(urlarray.length > 0) {
        for ( var i = 0, l = urlarray.length; i < l; i++ ) {
          var urleach= urlarray[ i ];
          if(urleach !== "") {
            var matches = urleach.match(<?php echo EQUATION ?>);
          }
          if(matches) {
            
          } else {
            var toastmsg = "<?php echo lang('INVALID_URL'); ?>";
            toastr.error(toastmsg);
            return false;
          }
        } 
      } 
    }); 
  });
  $(function() {
    // Summernote
    $('.textarea').summernote()
  })
</script>