<?php
$profile2 = json_decode($detailOfContestant[0]['profile_2'], true);
include("includes/header.php") ?>
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
            <li class="breadcrumb-item active"><?php echo lang('CONTESTANT_DETAIL'); ?></li>
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
          <h3 class="card-title"><?php echo lang("CONTESTANT_DETAIL") ?></h3>
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
          <form action="<?php echo BASE_URL . "contestant/editcontestant"; ?>" method="post" id="editContestant" enctype="multipart/form-data">
            <input type="hidden" name="contestant_id" value="<?php echo $detailOfContestant[0]['contestant_id'] ?>">
            <input type="hidden" name="old_contest_id" value="<?php echo $detailOfContestant[0]['contest_id'] ?>">
            <input type="hidden" name="user_id" value="<?php echo $detailOfContestant[0]['user_id'] ?>">
            <div class="hiddenFields"></div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("CONTESTANT_NAME") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <input type="text" class="form-control" name="contestant_name" value="<?php echo $detailOfContestant[0]['name'] ?>" id="exampleInputEmail1" placeholder="<?php echo lang("CONTESTANT_NAME") ?>">
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
                    <?php foreach ($contestList as $list) {   ?>
                      <option value="<?php echo ($list['contest_id']) ?>" <?php if ($detailOfContestant[0]['contest_id'] == $list['contest_id']) echo 'selected="selected"'; ?>><?php echo $list['contest_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label><?php echo lang("LBL_CATEGORY") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <select class="form-control select2" name="contest_category_id" id="contest_category_id" style="width: 100%;">
                    <option value=""><?php echo lang("LBL_SELECT_CATEGORY") ?></option>
                    <?php foreach ($categoryList as $category) { ?>
                      <option value="<?php echo $category['contest_category_id'] ?>" <?php if ($detailOfContestant[0]['contest_category_id'] === $category['contest_category_id']) echo 'selected="selected"'; ?>><?php echo $category['category_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label><?php echo lang("CONTESTANT_STATUS") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <select class="form-control select2" name="status" value="<?php echo ($detail[0]['status']) ?>" style="width: 100%;">
                    <option value="active" <?php if ($detailOfContestant[0]['status'] == "active") echo 'selected="selected"'; ?>><?php echo lang("ACTIVE") ?></option>
                    <option value="deactive" <?php if ($detailOfContestant[0]['status'] == "deactive") echo 'selected="selected"'; ?>><?php echo lang("DEACTIVE") ?></option>
                    <option value="deleted" <?php if ($detailOfContestant[0]['status'] == "deleted") echo 'selected="selected"'; ?>><?php echo lang("DELETED") ?></option>
                  </select> </div>
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
                  <input type="text" class="form-control" name="mobile" value="<?php echo $detailOfUser[0]['mobile'] ?>" id="exampleInputEmail1" placeholder="<?php echo lang("PHONE_NO") ?>">
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
                  <input type="email" class="form-control" name="email" value="<?php echo $detailOfUser[0]['email'] ?>" id="exampleInputEmail1" placeholder="<?php echo lang("EMAIL") ?>"> </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputFile"><?php echo lang("MAIN_IMAGE") ?></label>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="main_image" class="custom-file-input" id="exampleInputFile" accept="image/*">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <input type="hidden" name="main_image" value="<?php echo $detailOfContestant[0]['main_image'] ?>">
                  </div>
                  <span class="cat-info-text"><b>Info:</b> <?php echo lang("MAX_WIDTH_INFO") ?></span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mainimage"><?php echo lang("PREVIEW") ?></button>
                </div>
              </div>
              <div class="modal fade bd-example-modal-lg" id="mainimage" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                  <div class="modal_image">
                    <img src="<?php echo CON_CONTESTANT_URL . $detailOfContestant[0]['main_image'] ?>" style="width: 100%;">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputFile"><?php echo lang("THUMB_IMAGE") ?></label>
                </div>
              </div>
              <div class="col-md-7">
                <div class="form-group">
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="thumb_image" class="custom-file-input" id="exampleInputFile" accept="image/*">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <!-- <input type="hidden" name="thumb_image" value="<?php echo $detailOfContestant[0]['main_image'] ?>"> -->
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#thumbimage"><?php echo lang("PREVIEW") ?></button>
                </div>
              </div>
              <div class="modal fade bd-example-modal-lg" id="thumbimage" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                  <div class="modal_image">
                    <img src="<?php echo CON_CONTESTANT_URL . $detailOfContestant[0]['thumb_image'] ?>" style="width: 100%;">
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
                            <input type="text" class="form-control" name="age" value="<?php echo $detailOfContestant[0]['age'] ?>" id="exampleInputEmail1" placeholder="<?php echo lang("AGE") ?>" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo lang("HEIGHT") ?></td>
                          <td>
                            <input type="text" class="form-control" name="height" value="<?php echo $detailOfContestant[0]['height'] ?>" id="exampleInputEmail1" placeholder="<?php echo lang("HEIGHT") ?>">
                          </td>
                        </tr>
                        <tr>
                          <td><?php echo lang("WEIGHT") ?></td>
                          <td>
                            <input type="text" class="form-control" name="weight" value="<?php echo $detailOfContestant[0]['weight'] ?>" id="exampleInputEmail1" placeholder="<?php echo lang("WEIGHT") ?>">
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
            <?php if (!empty($detailOfContestant[0]['profile_2'])) { ?>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><?php echo lang("PROFILE_DETAIL") ?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <?php if ($userData['user_type'] == "admin") { ?>
                    <div class="input_fields_wrap">
                      <button type="button" class=" btn btn-success add_field_button"><?php echo lang('ADD_MORE_FIELD'); ?></button>
                    </div>
                  <?php } ?>
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
                          <?php foreach ($profile2 as $name => $value) { ?>
                            <tr id="remove">
                              <td>
                                <input type="text" class="form-control" name="key[]" value="<?php echo $name ?>" id="exampleInputEmail1">
                              </td>
                              <td>
                                <input type="text" class="form-control" name="value[]" value="<?php echo $value ?>" id="exampleInputEmail1">
                              </td>
                              <?php if ($userData['user_type'] == "admin") { ?>
                                <td><a href="#" class="remove_field">x</a></td>
                              <?php } ?>
                            </tr>
                          <?php }  ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>

            <?php } else { ?>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="exampleInputEmail1"><?php echo lang("PROFILE_DETAIL") ?></label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="input_fields_wrap">
                    <button type="button" class=" btn btn-success add_field_button"><?php echo lang('ADD_MORE_FIELD'); ?></button>
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
                          <td>
                            <input type="text" class="form-control" name="key[]" id="key">
                          </td>
                          <td>
                            <input type="text" class="form-control" name="value[]" id="value">
                          </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                </div>
              </div>
            <?php } ?>

            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo lang("INTRODUCTION_MESSAGE") ?></label>
                </div>
              </div>
              <div class="col-md-10">
                <div class="form-group">
                  <input type="text" class="form-control" name="introduction" value="<?php echo $detailOfContestant[0]['introduction'] ?>" id="exampleInputEmail1" placeholder="<?php echo lang("INTRODUCTION_MESSAGE") ?>"> </div>
              </div>
            </div>

            <?php if ($userData['user_type'] == "admin") { ?>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="exampleInputFile"><?php echo lang("IMAGE_GALLERY") ?></label>
                  </div>
                </div>
                <div class="col-md-10">
                  <?php include("addgallary_view.php"); ?>
                </div>
              </div>
            <?php } ?>

            <?php if (!empty($detailOfImages)) { ?>
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                      <div class="card card-primary">
                        <div class="card-body">
                          <div class="row scroll">
                            <?php if ($detailOfImages) {
                              foreach ($detailOfImages as $gallary) { ?>
                                <div class="col-md-2 imagedisplay imageGallary fileuploads" id="<?php echo  $gallary['media_id'] ?>">
                                  <img data-toggle="modal" id="sample" data-target="#myModal" src="<?php echo CON_GALLARY_URL . $gallary['media_name'] ?>" height="100px" width="100px" />
                                  <?php if ($userData['user_type'] == "admin") { ?>
                                    <i class="fas fa-trash-alt delete deleteImages" data-id="<?php echo  $gallary['media_id'] ?>"></i>
                                  <?php } ?>
                                </div>
                              <?php } ?>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div><!-- /.container-fluid -->
              </section>
            <?php } ?>

            <!-- IMAGE MODAL -->
            <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-sm">
                <div class="modal_image">
                  <img class="img-responsive" src="" style="width:100%">
                </div>
              </div>
            </div>
            <!-- IMAGE MODEL -->
            <?php if ($userData['user_type'] == "admin") { ?>
              <div class="row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="exampleInputFile"><?php echo lang("VIDEO_GALLERY") ?></label>
                  </div>
                </div>
                <div class="col-md-10">
                  <?php include("addvideo_view.php"); ?>
                </div>
              </div></br>
            <?php } ?>
            <?php if (!empty($detailOfVideos)) { ?>
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                      <div class="card card-primary">
                        <div class="card-body">
                          <div class="row">
                            <?php if ($detailOfVideos) {
                              foreach ($detailOfVideos as $gallaryVideos) { ?>
                                <div class="col-md-2 imagedisplay videoGallary videoUploads" id="<?php echo  $gallaryVideos['media_id'] ?>">
                                  <video height="200px" width="200px" controls>
                                    <source src="<?php echo CON_GALLARY_URL . $gallaryVideos['media_name'] ?>" type="video/mp4"></video>
                                  <?php if ($userData['user_type'] == "admin") { ?>
                                    <i class="fas fa-trash-alt deletevideo" data-id="<?php echo  $gallaryVideos['media_id'] ?>"></i>
                                  <?php } ?>
                                </div>
                              <?php  } ?>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            <?php } ?>
            <div>
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
                 <?php if(array_key_exists(0,$detailOfYoutubeVideos)){ ?>
                  <input type="text" class="form-control" name="videourl[]" value="<?php echo $detailOfYoutubeVideos[0]['media_name']; ?>" id="videourl1" placeholder="<?php echo lang("VIDEO_URL") ?>">
                  <input type="hidden" class="form-control" name="videoId[]" value="<?php echo $detailOfYoutubeVideos[0]['media_id']; ?>">
                <?php } else{ ?>
                  <input type="text" class="form-control" name="videourl[]" value="<?php echo set_value('videourl', ''); ?>" id="videourl1" placeholder="<?php echo lang("VIDEO_URL") ?>">
                  <input type="hidden" class="form-control" name="videoId[]" value="">
              <?php  } ?>
                </div>
                <div class="form-group">
                <?php if(array_key_exists(1,$detailOfYoutubeVideos)){ ?>
                  <input type="text" class="form-control" name="videourl[]" value="<?php echo $detailOfYoutubeVideos[1]['media_name']; ?>" id="videourl2" placeholder="<?php echo lang("VIDEO_URL") ?>">
                  <input type="hidden" class="form-control" name="videoId[]" value="<?php echo $detailOfYoutubeVideos[1]['media_id']; ?>">
                  <?php } else { ?>
                    <input type="text" class="form-control" name="videourl[]" value="<?php echo set_value('videourl', ''); ?>" id="videourl2" placeholder="<?php echo lang("VIDEO_URL") ?>">
                    <input type="hidden" class="form-control" name="videoId[]" value="">
                <?php  } ?>
                </div>
                <div class="form-group">
                <?php if(array_key_exists(2,$detailOfYoutubeVideos)){ ?>
                  <input type="text" class="form-control" name="videourl[]" value="<?php echo $detailOfYoutubeVideos[2]['media_name']; ?>" id="videourl3" placeholder="<?php echo lang("VIDEO_URL") ?>">
                  <input type="hidden" class="form-control" name="videoId[]" value="<?php echo $detailOfYoutubeVideos[2]['media_id']; ?>">
                  <?php } else { ?>
                    <input type="text" class="form-control" name="videourl[]" value="<?php echo set_value('videourl', ''); ?>" id="videourl3" placeholder="<?php echo lang("VIDEO_URL") ?>">
                    <input type="hidden" class="form-control" name="videoId[]" value="">

                <?php  } ?>
                </div>
              </div>
            </div> <br>
            <?php if (!empty($detailOfYoutubeVideos)) { ?>
              <section class="content">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                      <div class="card card-primary">
                        <div class="card-body">
                          <div class="row">
                            <?php if ($detailOfYoutubeVideos) {
                              foreach ($detailOfYoutubeVideos as $youtubeVideos) { 
                                $a = preg_match(EQUATION, $youtubeVideos['media_path'], $matches);
                                if(!empty($matches)){
                                  $video_id = $matches[2];
                                 }
                                ?>
                                <div class="col-md-2 imagedisplay videoGallary videoUploads" id="<?php echo  $youtubeVideos['media_id'] ?>">
                                <iframe width="200px" height="200px" 
                                     src="http://www.youtube.com/embed/<?php echo $video_id ?>" frameborder="0" allowfullscreen></iframe> 
                                </div>
                              <?php  } ?>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            <?php } ?>
              <?php if ($userData['user_type'] == "admin") { ?>
                <button type="submit" name="edit" class="btn btn-primary"><?php echo lang("EDIT") ?></button>
              <?php } ?>
            </div>
            <!-- /.card-body -->
          </form>
        </div>

      </div><!-- /.container-fluid -->
  </section>
</div>
<!-- /.content-wrapper -->

<?php include("includes/footer.php") ?>
<script type="text/javascript">
  $(document).ready(function() {
    var videoCountInitially = $('.videoUploads').length;
    $('.deletevideo').on('click', function() {
      var mediaId = $(this).attr('data-id');
      $.ajax({
        url: '<?php echo base_url("contestant/deleteGallaryVideos") ?>',
        type: 'POST',
        data: {
          'media_id': mediaId
        },
        success: function() {
          $("#" + mediaId).remove();
          var c = videoCountInitially - 1;
          if (c <= 3) {
            myVideoDropzone.enable();
          }
        }
      })
    });

    $('.deleteImages').on('click', function() {
      var mediaId = $(this).attr('data-id');
      var imagesCountInitially = $('.fileuploads').length;
      $.ajax({
        url: '<?php echo base_url("contestant/deleteGallaryImages") ?>',
        type: 'POST',
        data: {
          'media_id': mediaId
        },
        success: function() {
          $("#" + mediaId).remove();
          var d = imagesCountInitially - 1;
          if (d <= 12) {
            myDropzone.enable();
          }
        }
      })
    });

    $('img').on('click', function() {
      var image = $(this).attr('src');
      //alert(image);
      $('#myModal').on('show.bs.modal', function() {
        $(".img-responsive").attr("src", image);
      });
    });

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

    $('#contestId').change(function() {
      var contestId = $('#contestId').val();
      if (contestId !== '') {
        $.ajax({
          url: "<?php echo base_url(); ?>/Contestant/getCategoryFromContest",
          method: "POST",
          data: {
            contestId: contestId
          },
          success: function(data) {
            if (data['res_code'] === 1) {
              let catArr = data['res_data']['categoryData'];
              let html = '';
              $('#contest_category_id').html('<option value="">Select Category</option>');
              for (let index = 0; index < catArr.length; index++) {
                const catEl = catArr[index];
                html = "<option value=" + catEl['contest_category_id'] + ">" + catEl['category_name'] + "</option>";
                $('#contest_category_id').append(html);
              }
            } else {
              $('#contest_category_id').html('<option value="">Select Category</option>');
            }
          }
        });
      } else {
        $('#contest_category_id').html('<option value="">Select Category</option>');
      }
    });
  });

  $(document).ready(function() {
    $("#editContestant").submit(function(){
      var urlarray=[];
      var url = $("#videourl1").val();
      var url2 = $("#videourl2").val();
      var url3 = $("#videourl3").val();
      if(url !== "") {
        urlarray.push(url);
      }
      if(url2 !== "") {
        urlarray.push(url2);
      }
      if(url3 !== "") {
        urlarray.push(url3);
      }
      //urlarray.push(url,url2,url3);
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
    bsCustomFileInput.init();
  });


  $(function() {
    // Summernote
    $('.textarea').summernote()

  })
</script>