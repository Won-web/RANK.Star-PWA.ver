<div class="gallarycontent form-group">
  <!-- Dropzone -->
  <div class="dropzone fileupload" id="fileupload">
    <h1 class="dz-message"><?php echo lang("DROP_IMAGES") ?></h1>
  </div>
</div>
<script>
   $(document).ready(function() {
    var imageCountInitially = $('.fileuploads').length;
    if (imageCountInitially >= 12) {
      myDropzone.disable();
    }
  });

  Dropzone.autoDiscover = false;
  var myDropzone = new Dropzone("#fileupload", {
    url: "<?php echo BASE_URL . "contestant/gallaryImageUpload"; ?>",
    acceptedFiles: "image/*",
    maxFiles: 12,
    maxFilesize: 30, // MB
    addRemoveLinks: true,
    success:function(file,response){
      if(response.res_code == 1){
        file.upload.filename = response.data.file_name;

        var wrapper = $(".hiddenFields"); 
        $(wrapper).append('<input type="hidden" id="gallaryId" name="gallary[]" value="'+response.data.file_id+'">'); //add input box

        var initialImage = myDropzone.files.length;
        var imageCount = $('.fileuploads').length;
        var totalimages = initialImage + imageCount;
        if (totalimages >= 12) {
          myDropzone.disable();
        }
      }
      
    }, 
    removedfile: function(file) {
      var name = file.upload.filename;  
      var imageInBox = myDropzone.files.length; 
      $.ajax({
        url: "<?php echo BASE_URL . "contestant/removeImage"; ?>",
        method: "POST",
        data: { name: name},
        success: function(){
           // console.log(b);
           var imageCount = $('.fileuploads').length;
          // console.log(videoCount);
          var totalimages = imageInBox + imageCount;
          if (totalimages <= 12) {
            myDropzone.enable();
          }
        }
      });
      
      //  myDropzone.removeFile(file);
      var previewImageElement;
      return(previewImageElement = file.previewElement) != null ? (previewImageElement.parentNode.removeChild(file.previewElement)) : (void 0); 
    },
    // renameFile: function(file) {
    //   console.log(file);
    //   let newName = new Date().getTime() + '_' + file.name;
    //   return newName;
    // },
  });
</script>