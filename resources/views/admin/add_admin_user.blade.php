@extends('layouts.admin')
@section('styles')
<style type="text/css">
    a.theme_dashboard button.btn.btn-primary {
        margin-bottom: 10px;
    }
</style>
@endsection




@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="row">
    <div class="col">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <div class="card">
            <h4 class="card-header">Add new Admin User</h4>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <?php
                $user = auth()->user();
                ?>

                <form method="POST" action="{{ route('save-new-admin-user') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="version">Admin User name</label>
                        <input class="form-control" type="text" required name="admin_user_name" value="{{ request()->input('admin_user_name', old('admin_user_name')) }}">
                    </div>

                    <div class="form-group">
                        <label for="version">Admin User Password</label>
                        <input class="form-control" type="password" required name="password" value="{{ request()->input('password', old('password')) }}">
                    </div>
                    <div class="form-group">
                        <label for="version">Admin User Email</label>
                        <input class="form-control" type="text" name="admin_user_email" value="{{ request()->input('admin_user_email', old('admin_user_email')) }}">
                    </div>

                    <div class="form-group">
                        <label for="version">About User</label><small>(Short Description)</small>
                        {{-- <input class="form-control" type="text" name="user_description" value="{{ request()->input('user_description', old('user_description')) }}"> --}}
                        <textarea class="form-control" id="user_description" rows="2" name="user_description">{{ request()->input('user_description', old('user_description')) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="version">Admin User Role</label>
                        <select class="custom-select" multiple name="admin_user_role[]">
                                @foreach($user_roles as $key => $user_role)
                                    <option value="{{ $key }}">{{ $user_role }}</option>
                                @endforeach
                        </select>
                    </div>



                    <div class="form-group">
                        <label for="theme_file">Admin Profile Picture</label>
                        <input type="file" class="form-control-file" id="profile_picture" name="profile_picture" accept="image/x-png,image/gif,image/jpeg">
                    </div>

                    <input type="hidden" name="image_path">
                    <button type="submit" class="btn btn-primary btn-lg">Submit User</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section("scripts")
<script type="text/javascript">

    $(document).ready(function($) {

        $("form").submit(function(e){
          if($("input[name='image_path']").val() == ''){
            swal("Please Wait!", "Please wait while picture is uploading!", "error");
            e.preventDefault(e);
        }
    });

        $("#profile_picture").pekeUpload({
            notAjax:false,
            url:"{{ route('upload_user_profile') }}",
            data:{ '_token' : '{{ csrf_token() }}'},
            allowedExtensions:"jpeg|jpg|png|gif",
            showPreview:true,
            dragMode:true,
            onSubmit:false,
            bootstrap:true,
            delfiletext:"Delete",
            limit:'1',
            showPercent: true,
            limitError:"File Uploaded Already.",
            dragText:"Drag and Drop your file here",
            onFileSuccess:function(file,data){
                $("input[name='image_path']").val(data.url);
                $(':input[type="submit"]').show();

            }
        });


    });

</script>
@endsection 