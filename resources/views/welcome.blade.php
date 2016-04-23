<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>TinyPNG Test</title>
 
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/sweetalert/dist/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="/dropzone/dropzone.css">
    <link rel="stylesheet" type="text/css" href="/cropper/cropper.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head><!--/head-->
<style>
    .image img{
        width:400px;
        height: auto;
    }
</style>
<body>

    <section>

        <div class="container">
         <div class="form-group">
         <button class="btn btn-danger button">Add picture</button>
        <textarea name="editor" id="editor" cols="30" rows="10" class="form-control"></textarea>
            </div>
             <form action="/post_images" method="POST" class="dropzone col-md-8 col-md-offset-2" id="my-dropzone" enctype="multipart/form-data">

    {!! csrf_field() !!}
    <input id="token" type="hidden" value="{{ csrf_token() }}">
   

    <div class="form-group">
      <div class="col-md-12">
         <div id="dropzonePreview" class="dz-default dz-message" style="cursor: pointer; border:1px solid black;padding:4%;">
            <span>Spauskite arba meskite failus čia, norėdami juos įkelt</span><br/>
        </div>
   </div>
    </div>

    <div class="form-group">
    <div class="col-md-12">
    <button class="btn btn-primary form-control" id="submit-all" type="button">Sukurti įrašą</button>
  </div>
    </div>
    
    </form>
    <div class="col-md-8 col-md-offset-2 image image-editor">
    </div>
        </div>
        <button class="btn btn-xs btn-danger button2">Info img</button>
        <button class="rotate-ccw">Rotate counterclockwise</button>
      <button class="rotate-cw">Rotate clockwise</button>
    </section>
    
    <footer id="footer"><!--Footer-->
      
        
    </footer><!--/Footer-->
  
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js'></script>
    <script src="https://code.jquery.com/jquery-2.2.3.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.17/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
    <script src="/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/sweetalert/dist/sweetalert-dev.js"></script>
    <script src="/dropzone/dropzone.js"></script>
    <script src="/cropper/cropper.js"></script>
    <script src="//cdn.ckeditor.com/4.5.8/standard/ckeditor.js"></script>
    <script>
            CKEDITOR.replace( 'editor' );

            $('.button').click(function(){
            var img = "<img src='http://i.kinja-img.com/gawker-media/image/upload/vkyxu4eql8175ugmyjgy.png' height='250px'/>";
          CKEDITOR.instances.editor.insertHtml(img);
        });
    </script>
    <script src="/cropit/jquery.cropit.js"></script>

    <script>
  Dropzone.options.myDropzone = {

  // Prevents Dropzone from uploading dropped files immediately
  autoProcessQueue: true,
  uploadMultiple: true,
  parallelUploads: 100,
  maxFiles: 10,
  acceptedFiles: "image/*",
  clickable: '#dropzonePreview',
  addRemoveLinks: true,
  previewsContainer: '#dropzonePreview',


  init: function() {
    //var submitButton = document.querySelector("#submit-all")
        myDropzone = this; // closure

    // submitButton.addEventListener("click", function() {
    //   if (myDropzone.getQueuedFiles().length > 0) {                        
            myDropzone.processQueue();  
        // } else {                       
        //     $("#my-dropzone").submit(); //send empty 
        // }  
      //myDropzone.processQueue(); // Tell Dropzone to process all queued files.
   // });

    // You might want to show the submit button only when 
    // files are dropped here:
    this.on("successmultiple", function(response, file) {
        console.log(response);
        console.log(file);
      //$('.image').prepend('<img id="" src=" '+file.path+' '+' '+file.name+' " />');
        
            getCropper(file);
      
    });

  }
};

function getCropper(file){

    $('<img />')
      .attr('src', "" + file.path + file.name + "")         // ADD IMAGE PROPERTIES.
        .attr('title', 'Some title')
        .attr('id', 'image')
            .appendTo($('.image'));

      var $image = $('#image');
      var minAspectRatio = 0.5;
      var maxAspectRatio = 1.5;
      var cropped = '';

      $image.cropper({
        built: function () {
          var containerData = $image.cropper('getContainerData');
          var cropBoxData = $image.cropper('getCropBoxData');
          cropped = $image.cropper('getCroppedData');
          var aspectRatio = cropBoxData.width / cropBoxData.height;
          var newCropBoxWidth;

          if (aspectRatio < minAspectRatio || aspectRatio > maxAspectRatio) {
            newCropBoxWidth = cropBoxData.height * ((minAspectRatio + maxAspectRatio) / 2);

            $image.cropper('setCropBoxData', {
              left: (containerData.width - newCropBoxWidth) / 2,
              width: newCropBoxWidth
            });
          }
        },
        cropmove: function () {
          var cropBoxData = $image.cropper('getCropBoxData');
          var aspectRatio = cropBoxData.width / cropBoxData.height;

          if (aspectRatio < minAspectRatio) {
            $image.cropper('setCropBoxData', {
              width: cropBoxData.height * minAspectRatio
            });
          } else if (aspectRatio > maxAspectRatio) {
            $image.cropper('setCropBoxData', {
              width: cropBoxData.height * maxAspectRatio
            });
          }
        }
      });

      $(".button2").click(function() {
        
        var data = $image.cropper('getCanvasData');
        var $_token = $('#token').val();
        console.log(cropped);
        $.ajax({
            type: "POST",
            url: '/images/cropped',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            data: cropped,
            success: function (result) {
                console.log(result);
            }
        });  
      });
}
  </script>

</body>
</html>