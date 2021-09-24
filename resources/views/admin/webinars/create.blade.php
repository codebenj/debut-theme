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
      <span>New Webinar</span>
      </h4>
      <div class="card-body">
        <form method="POST" id="createWebinar" action="{{ route('createcourse') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="d-block" for="title">Title</label>
            <input required type="text" class="form-control" id="title" name="title" placeholder="">
          </div>
          <div class="form-group">
            <label class="d-block" for="presenter">Presenter</label>
            <select id="presenter" class='form-control' name="presenter">
              @foreach ($admins as $admin) {
              <option value="{{$admin->id}}">{{$admin->name}}</option>
              @endforeach

            </select>
          </div>
          <div class="form-group">
            <label class="d-block" for="name">Webinar link</label>
            <input type="text" class="form-control" id="webinar_link" name="webinar_link" placeholder="">
          </div>
          <div class="form-group">Duration</label>
            <input type="text" class="form-control" id="duration" name="duration" placeholder="">
          </div>
          <div class="form-group">Release date</label>
            <input type="date" class="form-control" id="release_date" name="release_date" placeholder="">
          </div>
          <div class="form-group">
            <label class="d-block" for="image">Image</label>
            <input type="file" class="form-control-file" id="webinar_img" name="webinar_img" onchange="uploadImage(this);" accept="image/*">
          </div>
          <div class="accordion" id="accordionCourse"></div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg" id="create-webinar">
              <span class="btn-text">
                Submit webinar
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
  </div>
</div>


@endsection


@section("scripts")

<script>

function uploadImage(input){
    $('.alert-danger').hide();
    if (input.files && input.files[0])
    {
        if (input.files[0].size > 8388608)
        {
            $(input).val('');
            $('.alert-danger').show();
            $('.alert-danger').html('Image size you uploaded is greater than 8mb');
            $("html, body").animate({scrollTop : 0},700);
        }
        else
        {
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

$(document).ready(function()
{
    $('#createWebinar').submit(function(e)
    {
        e.preventDefault();
        $('.btn-text').hide();
        $('.btn-loading').show();
        var modules=[]; var steps=[]; var errors = false;
        var webinar_title = $('#title').val();
        var presenter = $('#presenter').val();
        var webinar_link = $('#webinar_link').val();
        var webinar_duration = $('#duration').val();
        var webinar_release_date = $('#release_date').val();
        var webinar_img = $('#webinar_img').next().val();
        var webinar_img_ext = $('#webinar_img').next().attr('data-ext');
        var webinar_img_name = $('#webinar_img').val();

        $("#create-webinar").attr("disabled", true);
        $.ajax(
            {
                url: '{{ route('admin.webinars.store') }}',
                type: 'POST',
                data: {
                _token: "{{ csrf_token() }}",
                title: webinar_title,
                presenter: presenter,
                webinar_link: webinar_link,
                duration: webinar_duration,
                release_date: webinar_release_date,
                image: webinar_img,
                image_ext: webinar_img_ext,
                image_name: webinar_img_name,
            },
            dataType: 'JSON',
            success: function(result)
            {
                var error = '';
                $.each(result.errors, function(key, value)
                {
                    $('.alert-danger').show();
                    error += '<p>'+value+'</p>';
                    $('.alert-danger').html(error);
                });

                if (result.status == 'ok')
                {
                    $('.alert-success').show();
                    $('.alert-success').html('Webinar created successfully !');
                }
                else
                {
                    $("html, body").animate({scrollTop : 0},700);
                }

                setTimeout(function()
                {
                    $('.alert-danger').hide();
                    $('.alert-success').hide();
                    if(result.status == 'ok')
                    {
                        window.location.href = result.redirect;
                    }
                }, 1500);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                if (jqXHR.status == 413)
                {
                    $('.alert-danger').html('Attachment size is too large.');
                }
                else if (jqXHR.status == 422)
                {
                    var errors = ""
                    for (var key in jqXHR.responseJSON.errors) {
                        errors += "<p>" + jqXHR.responseJSON.errors[key][0] + "</p>"
                    }
                    $('.alert-danger').html(errors)
                    $('.alert-danger').show()
                }
                else
                {
                    $('.alert-danger').html('Unexpected error. Please try again');
                }
                $("html, body").animate({scrollTop : 0},700);
                $("#create-webinar").attr("disabled", false);
                $('.btn-text').show();
                $('.btn-loading').hide();
            }
        });
    });
});
</script>
@endsection
