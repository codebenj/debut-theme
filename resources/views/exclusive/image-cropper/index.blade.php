<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#5600e3">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-capable" content="yes">
<meta name="author" content="Debutify">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.css" crossorigin="anonymous">
<link rel="stylesheet" href="{{ URL::asset('css/cropper.css') }}">
<style>
    #galleryImages, #cropper{
        width: 100%;
        float: left;
    }
    canvas{
        max-width: 100%;
        display: inline-block;
    }
    #ratiobtn{
        display: none;
    }
    #ratiofields{
        display: none;
    }
    #cropImageBtn{
        display: none;
    }
    #downloadimage{
        display: none;
    }
    #reselectimage{
        display: none;
    }
    img{
        width: 100%;
    }
    .img-preview{
        float: left;
    }
    .singleImageCanvasContainer{
        max-width: 300px;
        display: inline-block;
        position: relative;
        margin: 2px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-bottom: 15px;
    }
    .singleImageCanvasCloseBtn{
        position: absolute;
        top: 5px;
        right: 5px;
    }
    .uploadFiles {
        height: 75vh;
        display: flex;
    }
    .btn-primary {
        color: #fff;
        background-color: #5600e3;
        border-color: #5600e3;
    }
   .btn-primary:hover {
       color: #fff;
       background-color: #4800bd;
       border-color: #4300b0;
   }
    #cropping_section{
      display: none;
    }

</style>
</head>
<body>
<section class='debutify-section'>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="imageUploadDiv" class="justify-content-center align-items-start py-4 uploadFiles">
            <div class="border rounded d-flex justify-content-center align-items-center p-5 shadow bg-white">
              <input type="file" id="imageCropFileInput" multiple="" accept=".jpg,.jpeg,.png">
              <p id="fp"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class='debutify-section'   >
    <div class='container-fluid py-5'  >
      <div class="col-md-12">
        <input type="hidden" id="profile_img_data">
        <div class="row">
            <div class="col-md-2">
                <div id="galleryImages" class="d-flex flex-column mb-2"></div>
            </div>
            <div class="col-md-8 d-flex flex-column">
                <div id="cropper">
                    <canvas id="cropperImg" width="0" height="0"></canvas>
                </div>
            </div>
            <div class="col-md-2 docs-toggles" id="cropping_section">
              <div class="border p-2 rounded">
                <div class="img-preview"></div>
                <div class="docs-data" id="ratiofields">
                    <div class="input-group input-group-sm">
                        <span class="input-group-prepend">
                            <label class="input-group-text" for="dataWidth">Width</label>
                        </span>
                        <input type="text" class="form-control" id="dataWidth" placeholder="width">
                        <span class="input-group-append">
                            <span class="input-group-text">px</span>
                        </span>
                    </div>
                    <div class="input-group input-group-sm">
                        <span class="input-group-prepend">
                            <label class="input-group-text" for="dataHeight">Height</label>
                        </span>
                        <input type="text" class="form-control" id="dataHeight" placeholder="height">
                        <span class="input-group-append">
                            <span class="input-group-text">px</span>
                        </span>
                    </div>
                </div>
                <div class="mb-2" id="ratiobtn" data-toggle="buttons">
                  <div class="btn-group d-flex">
                    <label class="btn btn-primary mr-1">
                        <input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 16 / 9">
                            16:9
                        </span>
                    </label>
                    <label class="btn btn-primary mr-1">
                        <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 4 / 3">
                            4:3
                        </span>
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 1 / 1">
                            1:1
                        </span>
                    </label>
                    <label class="btn btn-primary ml-1">
                        <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="aspectRatio: 2 / 3">
                            2:3
                        </span>
                    </label>
                  </div>
                </div>
                  <div class="btn-group d-flex flex-wrap mb-2">
                    <button class="cropImageBtn btn btn-primary mr-1" id="cropImageBtn">Crop</button>
                    <button class="btn btn-primary" id="downloadimage" onclick="download()">Download</button>
                  </div>
                  <div class="btn-group d-flex flex-wrap mb-2 ">
                    <button class="btn btn-primary" id="reselectimage" onclick="reselectall()">Reselect Images</button>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  <input type="hidden" name="defaultdownloadformat" id="defaultdownloadformat">
</section>

<!-- Modal -->
<div id="myModal" class="modal fade show" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h3 id="myModalLabel">Download Image Format</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <select class="form-control" name="downloadformat" id="downloadformat" onchange="downloadimage()">
                    <option value="image/jpeg">Choose Image Format</option>
                    <option value="image/jpeg">jpg</option>
                    <option value="image/png">png</option>
                    <option value="image/jpeg">jpeg</option>
                </select>
            </div>
            <div class="modal-footer">
                <div id="croppedimages" >
                    <a class="btn btn-primary " id="downloadall"  onclick="downloadZip()" >Download All</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.4.0/cropper.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip-utils/0.1.0/jszip-utils.min.js" crossorigin="anonymous"></script>

<script>
    var imagesArray = []; // more efficient than new Array()
    var c;
    var galleryImagesContainer = document.getElementById('galleryImages');
    var imageCropFileInput = document.getElementById('imageCropFileInput');
    var cropperImageInitCanvas = document.getElementById('cropperImg');
    var cropImageButton = document.getElementById('cropImageBtn');
    var downloadImage = document.getElementById('downloadimage');
    var ratiobtn = document.getElementById('ratiobtn');
    var ratiofields = document.getElementById('ratiofields');
    var imageUploadDiv = document.getElementById('imageUploadDiv');
    var reselectimage = document.getElementById('reselectimage');
    var cropping_section =document.getElementById('cropping_section');
    var selectedcanvas = "imageCanvas0";
    var defaultdownloadformat;
    // Crop Function On change
    function imagesPreview(input) {
        var cropper;
        galleryImagesContainer.innerHTML = '';
        var img = [];
        if (cropperImageInitCanvas.cropper) {
            cropperImageInitCanvas.cropper.destroy();
            cropImageButton.style.display = 'none';
            downloadImage.style.display = ' none';
            reselectimage.style.display = ' none';
            ratiofields.style.display = ' none';
            ratiobtn.style.display = 'none';
            imageUploadDiv.style.display = 'block';
            cropping_section.style.display = 'none';

            cropperImageInitCanvas.width = 0;
            cropperImageInitCanvas.height = 0;
        }
        if (input.files.length) {
            var i = 0;
            var index = 0;
            for (let singleFile of input.files) {

                var reader = new FileReader();
                reader.onload = function (event) {
                    var blobUrl = event.target.result;

                    img.push(new Image());
                    img[i].onload = function (e) {

                        // Canvas Container
                        var singleCanvasImageContainer = document.createElement('div');
                        singleCanvasImageContainer.id = 'singleImageCanvasContainer' + index;
                        singleCanvasImageContainer.className = 'singleImageCanvasContainer';
                        // Canvas Close Btn
                        var singleCanvasImageCloseBtn = document.createElement('button');
                        var singleCanvasImageCloseBtnText = document.createTextNode('Close');
                        singleCanvasImageCloseBtn.id = 'singleImageCanvasCloseBtn' + index;
                        singleCanvasImageCloseBtn.className = 'singleImageCanvasCloseBtn';
                        singleCanvasImageCloseBtn.onclick = function () {
                            removeSingleCanvas(this)
                        };
                        singleCanvasImageCloseBtn.appendChild(singleCanvasImageCloseBtnText);
                        singleCanvasImageContainer.appendChild(singleCanvasImageCloseBtn);
                        // Image Canvas
                        filename = singleFile.name;
                        var canvas = document.createElement('canvas');
                        canvas.id = 'imageCanvas' + index;
                        canvas.className = 'imageCanvas singleImageCanvas';
                        canvas.width = e.currentTarget.width;
                        canvas.height = e.currentTarget.height;
                        canvas.setAttribute("data-name", filename);
                        // console.log(canvas.id);

                        canvas.onclick = function () {
                            selectedcanvas = canvas.id;
                            cropInit(canvas.id);
                        };
                        singleCanvasImageContainer.appendChild(canvas)
                        // Canvas Context
                        var ctx = canvas.getContext('2d');
                        ctx.drawImage(e.currentTarget, 0, 0);
                        galleryImagesContainer.appendChild(singleCanvasImageContainer);
                        while (document.querySelectorAll('.singleImageCanvas').length == input.files.length) {
                            var allCanvasImages = document.querySelectorAll('.singleImageCanvas')[0].getAttribute('id');
                            cropInit(allCanvasImages);
                            break;
                        }
                        ;

                        cropInit(canvas.id);
                        selectedcanvas = canvas.id;
                        urlConversion();
                        geturls(canvas.id);
                        index++;
                    };
                    img[i].src = blobUrl;
                    i++;
                }

                reader.readAsDataURL(singleFile);

            }
        }
    }
    imageCropFileInput.addEventListener("change", function (event) {
        imagesPreview(event.target);
    });
    // Initialize Cropper
    function cropInit(selector, a = 9, b = 12, w = 0, h = 0) {
        c = document.getElementById(selector);
        if (cropperImageInitCanvas.cropper) {
            cropperImageInitCanvas.cropper.destroy();
        }
        var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
        for (let element of allCloseButtons) {
            element.style.display = 'block';
        }
        c.previousSibling.style.display = 'none';
        // c.id = croppedImg;
        var ctx = c.getContext('2d');
        var imgData = ctx.getImageData(0, 0, c.width, c.height);
        var image = cropperImageInitCanvas;

        image.width = c.width;
        image.height = c.height;
        if (w != 0 && w != '') {
            image.width = w;
        }
        if (h != 0 && h != '') {
            image.height = h;
        }
        var ctx = image.getContext('2d');
        ctx.putImageData(imgData, 0, 0);

        cropper = new Cropper(image, {
            aspectRatio: a / b,
            preview: '.img-preview',
            crop: function (event) {
                cropImageButton.style.display = 'block';
                downloadImage.style.display = 'block';
                reselectimage.style.display = 'block';
                ratiobtn.style.display = 'block';
                ratiofields.style.display = 'block';
                cropping_section.style.display = 'block';
                imageUploadDiv.style.display = 'none  ';


            }
        });

    }
    function image_crop() {
        if (cropperImageInitCanvas.cropper) {
            var cropcanvas = cropperImageInitCanvas.cropper.getCroppedCanvas();
            var ctx = cropcanvas.getContext('2d');
            var imgData = ctx.getImageData(0, 0, cropcanvas.width, cropcanvas.height);
            c.width = cropcanvas.width;
            c.height = cropcanvas.height;
            var ctx = c.getContext('2d');
            ctx.putImageData(imgData, 0, 0);
            var allCloseButtons = document.querySelectorAll('.singleImageCanvasCloseBtn');
            for (let element of allCloseButtons) {
                element.style.display = 'block';
            }
            cropInit(selectedcanvas);
            urlConversion();
            geturls(selectedcanvas);
        } else {
            alert('Please select any Image you want to crop');
        }
    }
    cropImageButton.addEventListener("click", function () {
        image_crop();
    });
    // Image Close/Remove
    function removeSingleCanvas(selector) {
        selector.parentNode.remove();
        urlConversion();
    }
    function urlConversion() {
        var allImageCanvas = document.querySelectorAll('.singleImageCanvas');
        var convertedUrl = '';
        for (let element of allImageCanvas) {
            convertedUrl += element.toDataURL('image/jpeg');
            convertedUrl += 'img_url';
        }
        document.getElementById('profile_img_data').value = convertedUrl;
    }

    // Options
    $('.docs-toggles').on('change', 'input', function () {

        var $this = $(this);
        var type = $this.prop('type');
        var id = $this.prop('id');

        if (cropperImageInitCanvas.cropper) {
            if (type === 'radio') {
                $(".btn-group").find("label").removeClass('active');
                $this.parent().addClass("active");
                if ($this.val() == 1.7777777777777777) {
                    cropInit(selectedcanvas, 16, 9);
                } else if ($this.val() == 1.3333333333333333) {
                    cropInit(selectedcanvas, 4, 3);
                } else if ($this.val() == 1) {
                    cropInit(selectedcanvas, 1, 1);
                } else if ($this.val() == 0.6666666666666666) {
                    cropInit(selectedcanvas, 2, 3);
                }
            } else if (type === 'text') {
                var a = $('#dataWidth').val();
                var b = $('#dataHeight').val();
                cropInit(selectedcanvas, 9, 12, a, b);
            }
        } else {
            alert('Please select any Image you want to crop');
        }
    });

    function download() {

        $('#myModal').modal('show');
        var downloadformat = $('#downloadformat').val();
        $('#download').attr('href', cropperImageInitCanvas.toDataURL(downloadformat));
    }
    // cropInit(canvas.id);


    function geturls(selectedcanvas) {
        var downloadformat = $('#downloadformat').val();
        var defaultdownloadformat = $('#downloadformat').val();
        $("#defaultdownloadformat").val(defaultdownloadformat);
        var dataname = document.getElementById(selectedcanvas).getAttribute('data-name');
        // console.log(dataname);
        if (imagesArray) {
            for (var i = imagesArray.length - 1; i >= 0; i--) {
                if (imagesArray[i]['canvasid'] == selectedcanvas) {
                    imagesArray.splice(i, 1);
                }
            }
        }
        imagesArray.push({url: cropperImageInitCanvas.toDataURL(downloadformat), canvasid: selectedcanvas, filename: dataname});
    }

    function downloadimage() {

        var downloadformat = $('#downloadformat').val();
        var imageformat = downloadformat.split('/');
        $('#download').attr('href', cropperImageInitCanvas.toDataURL(downloadformat));
        $('#download').attr('download', "cropped." + imageformat[1]);
    }


    /* Download an img */
    function downloadsingle(img, i) {

        var link = document.createElement("a");
        link.href = img;
        link.download = "cropped" + i;
        link.style.display = "none";
        var evt = new MouseEvent("click", {
            "view": window,
            "bubbles": true,
            "cancelable": true
        });
        // console.log(link);
        document.body.appendChild(link);
        link.dispatchEvent(evt);
        document.body.removeChild(link);

    }

    /* Download all images in 'imgs'.
     * Optionaly filter them by extension (e.g. "jpg") and/or
     * download the 'limit' first only  */

    function downloadAll() {

        var downloadformat = $('#downloadformat').val();
        var defaultdownloadformat = $("#defaultdownloadformat").val();
        /* If specified, filter images by extension */

        for (var i = 0; i < imagesArray.length; i++) {
            var img = imagesArray[i]['url'];
            img = img.replace(defaultdownloadformat, downloadformat);
            downloadsingle(img, i);
        }
        $('#myModal').modal('toggle');
    }
    function urlToPromise(url) {
        return new Promise(function (resolve, reject) {
            JSZipUtils.getBinaryContent(url, function (err, data) {
                if (err) {
                    reject(err);
                } else {
                    resolve(data);
                }
            });
        });
    }

    function downloadZip() {
        var zip = new JSZip();
        var imgData;
        var downloadformat = $('#downloadformat').val();
        var imageformat = downloadformat.split('/');
        var defaultdownloadformat = $("#defaultdownloadformat").val();
        console.log(imagesArray);
        // return false;
        for (var i = 0; i < imagesArray.length; i++) {
            imagename = imagesArray[i]['filename'];
            imagename = imagename.split(".");
            var filename = imagename[0] + '.' + imageformat[1];
            var img = imagesArray[i]['url'];
            var img = img.replace(defaultdownloadformat, downloadformat);
            zip.file(filename, urlToPromise(img), {binary: true});
        }
        zip.generateAsync({type: "blob"})
                .then(function callback(blob) {
                    saveAs(blob, "cropedfiles.zip");
                });
        $('#myModal').modal('toggle');
    }
    function reselectall() {
        $("#imageCropFileInput").val('');
        imagesPreview();
    }
</script>
</body>
</html>
