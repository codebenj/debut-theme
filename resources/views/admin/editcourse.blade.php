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

    <div class="alert alert-danger" style="display: none;">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>

    <div class="card">
      <h4 class="card-header d-flex align-items-center">
        <span>Edit course</span>
        <div class="ml-auto">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadAssetsModal">
            Upload Assets
          </button>
          <button type="button" class="btn" onclick="return deleteCourse();">
            <span class="fas fa-trash-alt"></span>
          </button>
        </div>
      </h4>
      <div class="card-body">
        <form method="POST" id="editCourse" action="{{ route('edit_course', $course->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="d-block" for="name">Title</label>
            <input type="text" class="form-control" id="course_title" name="course_title" value="{{ $course->title }}">
          </div>
          <div class="form-group">
            <label class="d-block" for="name">Description</label>
            <textarea class="form-control" id="course_desc" name="course_desc" rows="4">{{ $course->description }}</textarea>
          </div>
          <div class="form-group">
            <label class="d-block" for="image">Image</label>
            @if($course->image != '' && $course->image != null)
            <div class="attachment-wrap d-flex align-items-center">
              <img src="{{ $course->image }}" alt="course-img" width="200" class="img-fluid rounded">
              <button type="button" class="btn btn-outline-secondary ml-3 close-attachment">
                <span class="fas fa-times"></span>
              </button>
            </div>
            <input type="file" class="form-control-file" id="course_img" name="course_img" onchange="uploadImage(this);" accept="image/*" style="display: none;">
            <input type="hidden" name="" class="split_attachment" value="{{ $course->image }}">
            @else
            <input type="file" class="form-control-file" id="course_img" name="course_img" onchange="uploadImage(this);" accept="image/*">
            @endif
          </div>
          <div class="form-group">
            <label class="d-block" for="Subscription plan">Subscription plan <small class="text-muted">(hold Ctrl or ⌘)</small></label>
            <select multiple name="plan[]" id="plan" class="form-control">
              <?php
              foreach ($course->all_plans as $all_plan) {
                if(in_array( $all_plan ,$course->plans )){
                  echo '<option value="'.lcfirst($all_plan).'" selected="selected">'.$all_plan.'</option>';
                }else{
                  echo '<option value="'.lcfirst($all_plan).'">'.$all_plan.'</option>';
                }
              }
              ?>
            </select>
          </div>
          
          <datalist id="step_videos" class="video-list">
            @foreach($video_files as $file)
              <option value="{{ $file['name'] }}"></option>
            @endforeach
          </datalist>

          <div class="accordion" id="accordionCourse">
            <!-- module -->
            @foreach($course->modules as $key => $module)
            <div class="card module panel" data-id="{{ $module->id }}">
              <div class="card-header collapsed p-3" id="module-{{ $key }}" data-toggle="collapse" data-target="#mcollapse-{{ $key }}" aria-expanded="false" aria-controls="mcollapse-{{ $key }}">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-white">
                      <span class="fas fa-grip-vertical"></span>
                    </span>
                  </div>
                  <input type="text" class="form-control" name="module_title[]" id="module_title_{{ $key }}" placeholder="Module name" value="{{ $module->title }}">
                  <button type="button" onclick="return deleteModule(this,'{{ $module->id }}');" class="btn text-primary"><span class="fas fa-trash-alt"></span></button>
                </div>
              </div>
              <div id="mcollapse-{{ $key }}" class="card-body collapse" aria-labelledby="module-{{ $key }}" data-parent="#accordionCourse">
                <div class="form-group">
                  <label class="d-block" for="module_desc_{{ $key }}">Description</label><textarea rows="4" class="form-control" id="module_desc_{{ $key }}" name="module_desc[]">{{ $module->description }}</textarea>
                </div>
                <div class="form-group">
                  <div class="accordion accordion-steps" id="accordionSteps-{{ $key }}">
                    @foreach($module->steps as $index => $step)
                      <div class="card step panel" data-id="{{ $step->id }}">
                        <div class="card-header collapsed p-3" id="step-{{ $index }}" data-toggle="collapse" data-target="#scollapse{{ $key }}-{{ $index }}" aria-expanded="false" aria-controls="scollapse{{ $key }}-{{ $index }}">
                          <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text bg-danger text-white"><span class="fas fa-grip-vertical"></span></span></div>
                            <input type="text" class="form-control" name="step_title[]" id="step_title_{{ $index }}" value="{{ $step->title }}">
                            <button type="button" onclick="return deleteStep(this,'{{ $step->id }}');" class="btn text-danger"><span class="fas fa-trash-alt"></span></button>
                          </div>
                        </div>
                        <div id="scollapse{{ $key }}-{{ $index }}" class="card-body collapse" aria-labelledby="step-{{ $index }}" data-parent="#accordionSteps-{{ $key }}">
                          <div class="form-group">
                            <label class="d-block" for="step_desc_{{ $index }}">Description</label>
                            <textarea rows="4" class="form-control" id="step_desc_{{ $index }}" name="step_desc[]">{{ $step->description }}</textarea>
                          </div>
                          <div class="form-group">
                            <label class="d-block" for="step_tags_{{ $index }}">Tags</label>
                            <input type="text" data-role="tagsinput" class="form-control step-tags" id="step_tags_{{ $index }}" name="step_tags_{{ $index }}[]" value="{{ $step->tags }}">
                          </div>
                          <div class="form-group">
                            <label class="d-block" for="step_video1_{{ $index }}">Wistia Video ID</label>
                            <input type="text" name="step_video1_{{ $index }}[]" id="step_video1_{{ $index }}" class="form-control" list="step_videos" value="{{ $step->video1 }}">
                          </div>
                          <div class="form-group">
                            <label class="d-block" for="step_video2_{{ $index }}">Attachment</label>
                            <select name="step_video2_{{ $index }}[]" id="step_video2_{{ $index }}" class="form-control attachment-list" list="step_videos" value="{{ $step->video2 }}">
                              <option value="">No attachment</option>
                              @foreach ($assets as $asset)
                                <option value="{{ $asset['url'] }}" {{ $step->video2 == $asset['url'] ? 'selected' : '' }}>
                                  {{ $asset['name'] }}
                                </option>
                              @endforeach 
                            </select>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <button type="button" class="btn btn-outline-danger btn-block add_step mt-3"><span class="fas fa-plus"></span> Add new lesson</button>
                </div>
              </div>
            </div>
            @endforeach

          </div>
          <div class="form-group">
            <button type="button" class="btn btn-outline-primary btn-block mt-3" id="add_module"><span class="fas fa-plus"></span> Add new module</button>
          </div>

          <button type="button" class="btn btn-primary btn-lg" id="update-course" onclick="return updateCourse();">
              <span class="btn-text">
                Update course
              </span>
              <span class="btn-loading" style="display:none;">
                <span class="fas fa-spin fa-spinner"></span>
              </span>
          </button>
        </form>
      </div>
    </div>
    @include('admin.upload_assets')
  </div>
</div>
@endsection
@section('scripts')

<script>

$("#accordionCourse").sortable({
  items: ".module"
});
$(".accordion-steps").sortable({
    items: ".step"
});
function deleteModule(event,id){
  $(event).addClass('testing');
  swal({
        title: 'Are you sure you want to delete this module ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
  }).then(function() {
    if(id != undefined){
      $.ajax({
        type: "post",
        url: "{{ route('delete_module')}}",
        data: { _token: "{{ csrf_token() }}", module_id: id },
        success: function(data) {
          swal("Deleted!", "Module successfully Deleted!", "success");
        },
        error: function(error){
          swal("Oops", "We couldn't connect to the server!", "error");
        }
      });
    }
    $(event).parents('.module').remove();
  });
}
function deleteStep(event,id){
  swal({
        title: 'Are you sure you want to delete this lesson ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
  }).then(function() {
    if(id != undefined){
      $.ajax({
        type: "post",
        url: "{{ route('delete_step')}}",
        data: { _token: "{{ csrf_token() }}", step_id: id },
        success: function(data) {
          swal("Deleted!", "Lesson successfully Deleted!", "success");
        },
        error: function(error){
          swal("Oops", "We couldn't connect to the server!", "error");
        }
      });
    }
    $(event).parents('.step').remove();
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
          // $('.course-img').css('display','block');
          reader.onload = function (e) {
              a.setAttribute("value", e.target.result);
              // $('.course-img').find('img').attr('src',e.target.result);
          };
          a.setAttribute("data-ext", input.files[0].name.split('.').pop());
          reader.readAsDataURL(input.files[0]);
          a.setAttribute("class", "attachment");
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
        $('.alert-danger').html('Image size you uploaded is greater than 15mb');
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
          // console.log('a', a);
          a.setAttribute("class", "attachment");
          input.after(a);
      }
    }
}
$(document).ready(function(){
  $('.close-attachment').click(function(){
    $(this).parent().next().css('display','block');
    $(this).parent().siblings('.split_attachment').remove();
    $(this).parent().remove();
  });
  $('#add_module').click(function(){
    var module_count = $('.module').length;
    var cur_module = module_count+1;
    var html = '<div class="card module panel"><div class="card-header collapsed p-3" id="module-'+cur_module+'" data-toggle="collapse" data-target="#mcollapse-'+cur_module+'" aria-expanded="false" aria-controls="mcollapse-'+cur_module+'"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-primary text-white"><span class="fas fa-grip-vertical"></span></span></div><input type="text" class="form-control" name="module_title[]" id="module_title_'+cur_module+'" placeholder="Module name"><button type="button" onclick="return deleteModule(this);" class="btn text-primary"><span class="fas fa-trash-alt"></span></button></div></div><div id="mcollapse-'+cur_module+'" class="card-body collapse" aria-labelledby="module-'+cur_module+'" data-parent="#accordionCourse"><div class="form-group"><label class="d-block" for="module_desc_'+cur_module+'">Description</label><textarea rows="4" class="form-control" id="module_desc_'+cur_module+'" name="module_desc[]"></textarea></div><div class="form-group"><div class="accordion accordion-steps" id="accordionSteps-'+cur_module+'"></div><button type="button" class="btn btn-outline-danger btn-block add_step mt-3"><span class="fas fa-plus"></span> Add new lesson</button></div></div></div>';
    $(".accordion-steps").sortable({
      items: ".step"
    });
    $('#accordionCourse').append(html);
  });
  $(document).on('click','.add_step',function(){
    var step_count = $('.step').length;
    var cur_step = step_count+1;
    var stepParent = $(this).prev('.accordion-steps').attr('id');
    var options = "<option value=''>No attachment</option>";

    $(".asset-list").children().each(function(index, asset) {
        options += "<option value='"+$(asset).attr('href')+"'>"+$(asset).text()+"</option>"
    })

    var html = '<div class="card step panel"><div class="card-header collapsed p-3" id="step-'+cur_step+'" data-toggle="collapse" data-target="#scollapse-'+cur_step+'" aria-expanded="false" aria-controls="scollapse-'+cur_step+'"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-danger text-white"><span class="fas fa-grip-vertical"></span></span></div><input type="text" class="form-control" name="step_title[]" id="step_title_'+cur_step+'" placeholder="Lesson name"><button type="button" onclick="return deleteStep(this);" class="btn text-danger"><span class="fas fa-trash-alt"></span></button></div></div><div id="scollapse-'+cur_step+'" class="card-body collapse" aria-labelledby="step-'+cur_step+'" data-parent="#'+stepParent+'"><div class="form-group"><label class="d-block" for="step_desc_'+cur_step+'">Description</label><textarea rows="4" class="form-control" id="step_desc_'+cur_step+'" name="step_desc[]"></textarea></div><div class="form-group"><label class="d-block" for="step_tags_'+cur_step+'">Tags</label><input type="text" data-role="tagsinput" class="form-control step-tags" id="step_tags_'+cur_step+'" name="step_tags_'+cur_step+'[]"></div><div class="form-group"><label class="d-block" for="step_video1_'+cur_step+'">Wistia Video ID</label><input type="text" class="form-control" id="step_video1_'+cur_step+'" list="step_videos" name="step_video1_'+cur_step+'[]"></div><div class="form-group"><label class="d-block" for="step_video2_'+cur_step+'">Attachment</label><select class="form-control attachment-list" id="step_video2_'+cur_step+'" list="step_videos" name="step_video2_'+cur_step+'[]">'+options+'</select></div></div></div>';
    $(this).prev().append(html);
    $("input.step-tags").tagsinput();
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
      $(".modal-body .alert").remove();
      swal({
        title: 'Successfully uploaded.',
        text: "",
        type: 'success',
      });
    }
  });
});

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

function updateCourse(){
  // e.preventDefault();
  $('.btn-text').hide();
  $('.btn-loading').show();
  var modules=[]; var steps=[]; var errors = false;
  var course_title = $('#course_title').val();
  var course_desc = $('#course_desc').val();
  var course_img = $('#course_img').next().val();
  var subscription_plan = $('#plan').val();
  var course_img_ext = $('#course_img').next().attr('data-ext');
  if($('#course_img').next().hasClass( "split_attachment" )){
    var filename = course_img.replace(/^.*[\\\/]/, '');
    var course_img_ext = filename.split('.').pop();
  }

  $('input').removeClass('red-border');
  $( ".module" ).each(function(index) {
    if($(this).find('[id^="module_title"]').val() != ''){
      var mod={};
      if($(this).attr('data-id')){
        mod['id'] =  $(this).attr('data-id');
      }else{
        mod['id'] =  "";
      }

      mod['title'] = $(this).find('[id^="module_title"]').val();
      mod['desc'] = $(this).find('[id^="module_desc"]').val();
      var steps=[];
      $(this).find('.step').each(function(index) {
        var step={};
        if($(this).find('[id^="step_title"]').val() != ''){
          if($(this).attr('data-id')){
            step['id'] =  $(this).attr('data-id');
          }else{
            step['id'] =  "";
          }
          step['title'] = $(this).find('[id^="step_title"]').val();
          step['desc'] = $(this).find('[id^="step_desc"]').val();
          step['tags'] = $(this).find('[id^="step_tags"]').val();
          step['video1'] = $(this).find('[id^="step_video1"]').val();
          step['video2'] = $(this).find('[id^="step_video2"]').val();
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
  // errors = true;

  if(!errors){
    $("#update-course").attr("disabled", true);
    $.ajax({
        url: '{{ route('edit_course',$course->id)}}',
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
              $('.alert-success').html('Course updated successfully !');
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
          $("#update-course").attr("disabled", false);
          $('.btn-text').show();
            $('.btn-loading').hide();
          // window.location.reload();
        }
    });
  }
}
function deleteCourse(){
  swal({
        title: 'Are you sure you want to delete this course ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
  }).then(function() {
      $.ajax({
        type: "post",
        url: "{{ route('delete_course', $course->id) }}",
        data: { _token: "{{ csrf_token() }}" },
        success: function(result) {
          // swal("Deleted!", "Course successfully Deleted!", "success");
          if(result.status == 'ok'){
            window.location.href = result.redirect;
          }
        },
        error: function(error){
          swal("Oops", "We couldn't connect to the server!", "error");
        }
      });
  });
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
</script>
@endsection
