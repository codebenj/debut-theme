@extends('layouts.admin')

@section('styles')
<style>
.collapsed{
  border-bottom: 0;
}
.red-border {
    border: 1px solid #f00;
}
#accordionCourse .collapse.in {
    display: block;
}
.bootstrap-tagsinput {
    border: 1px solid #ced4da;
}
.swal2-modal h2 {
    font-size: 20px !important;
}
</style>
@endsection

@section('content')
<div class="row">
  <div class="col">
    <div class="alert alert-danger" style="display:none"></div>
    <div class="alert alert-success" style="display:none"></div>

    <div class="card">
      <h4 class="card-header d-flex align-items-center">
      <span>New course</span>
      <button type="button" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#uploadAssetsModal">
        Upload Assets
      </button>
      </h4>
      <div class="card-body">
        <form method="POST" id="createCourse" action="{{ route('createcourse') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="d-block" for="name">Title</label>
            <input type="text" class="form-control" id="course_title" name="course_title" placeholder="">
          </div>
          <div class="form-group">
            <label class="d-block" for="name">Description</label>
            <textarea class="form-control" id="course_desc" name="course_desc" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label class="d-block" for="image">Image</label>
            <input type="file" class="form-control-file" id="course_img" name="course_img" onchange="uploadImage(this);" accept="image/*">
          </div>
          <div class="form-group">
            <label class="d-block" for="Subscription plan">Subscription plan <small class="text-muted">(hold Ctrl or ⌘)</small></label>
            <select multiple name="plan[]" id="plan" class="form-control">
              <option value="freemium">Freemium</option>
              <option value="starter">Starter</option>
              <option value="hustler">Hustler</option>
              <option value="master">Master</option>
            </select>
          </div>

          <div class="accordion" id="accordionCourse"></div>

          <div class="form-group">
            <button type="button" class="btn btn-outline-primary btn-block" id="add_module">
              <span class="fas fa-plus"></span>
              Add new module
            </button>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg" id="create-course">
              <span class="btn-text">
                Submit course
              </span>
              <span class="btn-loading" style="display:none;">
                <span class="fas fa-spin fa-spinner"></span>
              </span>
            </button>
          </div>
          <input type="hidden" name="modules" id="videos" />
        </form>
      </div>
    </div>
    @include('admin.upload_assets')
  </div>
</div>


@endsection


@section("scripts")

<script>
$("#accordionCourse").sortable({
  items: ".module"
});
function deleteModule(event){
  swal({
        title: 'Are you sure you want to delete this module ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
  }).then(function() {
    $(event).parents('.module').remove();
    swal("Deleted!", "Module successfully Deleted!", "success");
  });
}

function getAssets() {
  $.ajax({
    url: '{{ route('get-assets')}}',
    type: 'GET',
    data: { _token: "{{ csrf_token() }}", type: "html" },
    dataType: 'JSON',
    success: function(result) {
      $("#assets-container").html(result.html)
    }
  });
}

function deleteStep(event){
  swal({
        title: 'Are you sure you want to delete this lesson ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
  }).then(function() {
    $(event).parents('.step').remove();
    swal("Deleted!", "Lesson successfully Deleted!", "success");
  });
}
function uploadImage(input){
    $('.alert-danger').hide();
    if (input.files && input.files[0]) {
      if(input.files[0].size > 8388608){
        $(input).val('');
        $('.alert-danger').show();
        $('.alert-danger').html('Image size you uploaded is greater than 8mb');
        $("html, body").animate({scrollTop : 0},700);
      }else{
          var reader = new FileReader();
          a = document.createElement("input");
          a.setAttribute("type", "hidden");
          reader.onload = function (e) {
              a.setAttribute("value", e.target.result);
          };
          a.setAttribute("data-ext", input.files[0].name.split('.').pop());
          reader.readAsDataURL(input.files[0]);

          input.after(a);
      }
    }
}
function uploadVideo(input){
    $('.alert-danger').hide();
    if (input.files && input.files[0]) {
      if(input.files[0].size > 15728640){
        $(input).val('');
        $('.alert-danger').show();
        $('.alert-danger').html('Video size you uploaded is greater than 15mb');
        $("html, body").animate({scrollTop : 0},700);
      }else{
          var reader = new FileReader();
          a = document.createElement("input");
          a.setAttribute("type", "hidden");
          reader.onload = function (e) {
              a.setAttribute("value", e.target.result);
          };
          a.setAttribute("data-ext", input.files[0].name.split('.').pop());
          reader.readAsDataURL(input.files[0]);
          input.after(a);
      }
    }
}

function deleteAsset(path, url, name) {
  swal({
        title: 'Warning',
        text: "This asset might be attached to any courses, are you sure you want to delete this asset?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
  }).then(function() {
      $.ajax({
        type: "post",
        url: "{{ route('delete_asset') }}",
        data: { _token: "{{ csrf_token() }}", path: path, url: url },
        success: function(result) {
          swal("Deleted!", "Asset successfully Deleted!", "success");
          getAssets();
          $(".attachment-list option:contains('"+name+"')").remove()
        },
        error: function(error){
          swal("Oops", "We couldn't connect to the server!", "error");
        }
      });
  });
}

$(document).ready(function(){

  $('#add_module').click(function(){
    var module_count = $('.module').length;
    var cur_module = module_count+1;
    var html = '<div class="card mb-3 module panel"><div class="card-header collapsed p-3" id="module-'+cur_module+'" data-toggle="collapse" data-target="#mcollapse-'+cur_module+'" aria-expanded="false" aria-controls="mcollapse-'+cur_module+'"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-primary text-white"><span class="fas fa-grip-vertical"></span></span></div><input type="text" class="form-control" name="module_title[]" id="module_title_'+cur_module+'" placeholder="Module name"></div></div><div id="mcollapse-'+cur_module+'" class="card-body collapse" aria-labelledby="module-'+cur_module+'" data-parent="#accordionCourse"><div class="form-group"><label class="d-block" for="module_desc_'+cur_module+'">Description</label><textarea rows="4" class="form-control" id="module_desc_'+cur_module+'" name="module_desc[]"></textarea></div><div class="form-group"><div class="accordion-steps" id="accordionSteps-'+cur_module+'"></div><button type="button" class="btn btn-outline-danger btn-block add_step"><span class="fas fa-plus"></span>Add new lesson</button></div><button type="button" onclick="return deleteModule(this);" class="btn btn-outline-primary btn-block mt-3"><span class="fa fa-trash"></span> Delete Module</button></div></div>';
    $(".accordion-steps").sortable({
      items: ".step"
    });
    $('#accordionCourse').append(html);
    // delModule();
  });
  $(document).on('click','.add_step',function(){
    var step_count = $('.step').length;
    var cur_step = step_count+1;
    var stepParent = $(this).prev('.accordion-steps').attr('id');
    var options = "<option value=''>No attachment</option>";

    $(".asset-list").children().each(function(index, asset) {
        options += "<option value='"+$(asset).attr('href')+"'>"+$(asset).text()+"</option>"
    })

    var html = '<div class="card mb-3 step panel"><div class="card-header collapsed p-3" id="step-'+cur_step+'" data-toggle="collapse" data-target="#scollapse-'+cur_step+'" aria-expanded="false" aria-controls="scollapse-'+cur_step+'"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-danger text-white"><span class="fas fa-grip-vertical"></span></span></div><input type="text" class="form-control" name="step_title[]" id="step_title_'+cur_step+'" placeholder="Lesson name"></div></div><div id="scollapse-'+cur_step+'" class="card-body collapse" aria-labelledby="step-'+cur_step+'" data-parent="#'+stepParent+'"><div class="form-group"><label class="d-block" for="step_desc_'+cur_step+'">Description</label><textarea rows="4" class="form-control" id="step_desc_'+cur_step+'" name="step_desc[]"></textarea></div><div class="form-group"><label class="d-block" for="step_tags_'+cur_step+'">Tags</label><input type="text" data-role="tagsinput" class="form-control step-tags" id="step_tags_'+cur_step+'" name="step_tags_'+cur_step+'[]"></div><div class="form-group"><label class="d-block" for="step_video1_'+cur_step+'">Wistia Video ID</label><input type="text" class="form-control" id="step_video1_'+cur_step+'" name="step_video1_'+cur_step+'[]"></div><div class="form-group"><label class="d-block" for="step_video2_'+cur_step+'">Attachment</label><select class="form-control attachment-list" id="step_video2_'+cur_step+'" name="step_video2_'+cur_step+'[]">'+options+'</select></div><button type="button" onclick="return deleteStep(this);" class="btn btn-outline-danger btn-block mt-3"><span class="fa fa-trash"></span> Delete Lesson</button></div></div>';
    $(this).prev().append(html);
    $("input.step-tags").tagsinput();
  });

  $('#createCourse').submit(function(e){
    e.preventDefault();
    $('.btn-text').hide();
    $('.btn-loading').show();
    var modules=[]; var steps=[]; var errors = false;
    var course_title = $('#course_title').val();
    var course_desc = $('#course_desc').val();
    var course_img = $('#course_img').next().val();
    var course_img_ext = $('#course_img').next().attr('data-ext');
    var subscription_plan = $('#plan').val();
    $( ".module" ).each(function(index) {
      if($(this).find('[id^="module_title"]').val() != ''){
        var mod={};
        mod['title'] = $(this).find('[id^="module_title"]').val();
        mod['desc'] = $(this).find('[id^="module_desc"]').val();
        var steps=[];
        $(this).find('.step').each(function(index) {
          var step={};
          if($(this).find('[id^="step_title"]').val() != ''){
            step['title'] = $(this).find('[id^="step_title"]').val();
            step['desc'] = $(this).find('[id^="step_desc"]').val();
            step['tags'] = $(this).find('[id^="step_tags"]').val();
            step['video1'] = $(this).find('[id^="step_video1"]').val();
            // step['video1_ext'] = $(this).find('[id^="step_video1"]').next().attr('data-ext');
            step['video2'] = $(this).find('[id^="step_video2"]').val();
            // step['video2_ext'] = $(this).find('[id^="step_video2"]').next().attr('data-ext');
            steps.push(step);
            mod['steps'] = steps;
          }else{
            errors = true;
            $(this).find('[id^="step_title"]').addClass('red-border');
          }
        });
        modules.push(mod);
      }else{
        errors = true;
        $(this).find('[id^="module_title"]').addClass('red-border');
      }
    });

    var modules = JSON.stringify(modules);
    // console.log('plans', subscription_plan);

    if(!errors){
      $("#create-course").attr("disabled", true);
      $.ajax({
          url: '{{ route('createcourse')}}',
          type: 'POST',
          data: { _token: "{{ csrf_token() }}", Title: course_title, Description: course_desc, image: course_img, image_ext: course_img_ext, modules: modules, plans: subscription_plan },
          dataType: 'JSON',
          success: function(result) {
              var error = '';
              $.each(result.errors, function(key, value){
                $('.alert-danger').show();
                error += '<p>'+value+'</p>';
                $('.alert-danger').html(error);
              });

              if(result.status == 'ok'){
                $('.alert-success').show();
                $('.alert-success').html('Course created successfully !');
              }else{
                $("html, body").animate({scrollTop : 0},700);
              }

              setTimeout(function(){
                 $('.alert-danger').hide();
                 $('.alert-success').hide();
                 if(result.status == 'ok'){
                   window.location.href = result.redirect;
                 }
              }, 1000);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log('error='+ jqXHR.responseText, jqXHR.status);
            $('.alert-danger').show();
            if(jqXHR.status == 413){
              $('.alert-danger').html('Attachment size is too large.');
            }else {
              $('.alert-danger').html('Unexpected error. Please try again');
            }
            $("html, body").animate({scrollTop : 0},700);
            $("#create-course").attr("disabled", false);
            $('.btn-text').show();
            $('.btn-loading').hide();
            // window.location.reload();
          }
      });
    }

  });

  $("#asset-file").pekeUpload({
    notAjax: false,
    url: "{{ route('upload-asset') }}",
    data:{ '_token': '{{ csrf_token() }}' },
    showPreview: false,
    dragMode: true,
    onSubmit: false,
    bootstrap: true,
    limit: 1,
    delfiletext: "Close",
    allowedExtensions:"jpeg|jpg|png|gif|pdf|mp4",
    limitError: "Please upload assets one at a time.",
    dragText: "Drag and Drop your assets here",
    onFileSuccess: function(file, data) {
      getAssets();
      $(".attachment-list").append("<option value='"+data.url+"'>"+data.name+"</option>");
      swal({
        title: 'Successfully uploaded.',
        text: "",
        type: 'success',
      });
    }
  });
});
</script>
@endsection
