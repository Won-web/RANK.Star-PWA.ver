<div class='gallarycontent'>
  <!-- Dropzone -->
  <div class="dropzone videoupload" id="videoupload">
    <h1 class="dz-message"><?php echo lang("DROP_VIDEOS") ?></h1>
  </div>
</div>
<script>
  $(document).ready(function() {
    var videoCountInitially = $('.videoUploads').length;
    // console.log(videoCountInitially);
    if (videoCountInitially >= 3) {
      myVideoDropzone.disable();
    }
  });
  Dropzone.autoDiscover = false;
  var myVideoDropzone = new Dropzone("#videoupload", {
    url: "<?php echo BASE_URL . "contestant/gallaryVideoUpload"; ?>",
    paramName: "video",
    acceptedFiles: ".mkv,.mp4,.wmv",
    maxFiles: 3,
    maxFilesize: 700, // MB
    addRemoveLinks: true,
    success: function(file, response) {
      if(response.res_code == 1){
        file.upload.filename = response.data.file_name;
        
        var wrapper = $(".hiddenFields");
        $(wrapper).append('<input type="hidden" id="gallaryId" name="gallary[]" value="' + response.data.file_id + '">'); //add input box
        var a = myVideoDropzone.files.length;
        var videoCount = $('.videoUploads').length;
        var totalVideos = a + videoCount;
        if (totalVideos >= 3) {
          myVideoDropzone.disable();
        }
      }
      
    },
    removedfile: function(file) {
      var videoName = file.upload.filename;
      var b = myVideoDropzone.files.length; 
      $.ajax({
        url: "<?php echo BASE_URL . "contestant/removeVideo"; ?>",
        method: "POST",
        data: {
          videoName: videoName
        },
        success: function() {
          // console.log(b);
          var videoCount = $('.videoUploads').length;
          // console.log(videoCount);
          var totalVideos = b + videoCount;
          if (totalVideos <= 3) {
            myVideoDropzone.enable();
          }
        }
      });
      var previewElement;
      return (previewElement = file.previewElement) != null ? (previewElement.parentNode.removeChild(file.previewElement)) : (void 0);
    },
    // renameFile: function(file) {
    //   let NewvideoName = new Date().getTime() + '_' + file.name;
    //   return NewvideoName;
    // },

  });
</script>