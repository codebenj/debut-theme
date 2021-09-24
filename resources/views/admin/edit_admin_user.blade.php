@extends('layouts.admin')
@section('styles')
<style type="text/css">
  a.theme_dashboard button.btn.btn-primary {
    margin-bottom: 10px;
 }
</style>
@endsection

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

@section('content')
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
      <h4 class="card-header">Modify Admin User</h4>
      <div class="card-body">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
       </div>
       @endif

       <form method="POST" action="{{ route('edit_user', $admin_user->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="version">Admin User name</label>
            <input class="form-control" type="text" required name="admin_user_name" value="{{ $admin_user->name }}">

         </div>

         <div class="form-group">
            <label for="version">Admin User Email</label>
            <input class="form-control" type="text" name="admin_user_email" value="{{ $admin_user->email }}">
         </div>

         <div class="form-group">
            <label for="version">Admin User Password (Keep it Empty If you don't want to change current Password)</label>
            <input class="form-control" type="password" name="password" value="" readonly onfocus="this.removeAttribute('readonly');">
         </div>
         <div class="form-group">
            <label for="version">About User</label><small>(Short Description)</small>
            {{-- <input class="form-control" type="text" name="user_description" value="{{ request()->input('user_description', old('user_description')) }}"> --}}
            <textarea class="form-control" id="user_description" rows="2" name="user_description">{{ $admin_user->short_description }}</textarea>
         </div>
         <div class="form-group">
            <label for="version">Admin User Role</label>
            <small class="text-muted">(hold Ctrl or ⌘)</small>
            <select class="custom-select" multiple name="admin_user_role[]">
             @foreach($user_roles as $key => $user_role)
             @php $select = ""; @endphp
             @if(!empty($admin_user->user_role))
             @if(in_array($key, json_decode($admin_user->user_role, true)))
             @php $select = "selected"; @endphp
             @endif
             @endif
             <option value="{{ $key }}" {{ $select }}>{{ $user_role }}</option>
             @endforeach
          </select>
       </div>


       <div class="form-group">
         <label for="profile_image">Upload New profile(Will Delete Previous File Automatically)</label>
         <input type="file" class="form-control-file" id="image_file" name="profile_picture" accept="image/x-png,image/gif,image/jpeg">
      </div>
      <div class="form-group">
         <div class="filename">Last Used Image</div>
         <input type="hidden" value="{{ $admin_user->profile_image }}" name="last_used">
      </div>
      <div class="pekecontainer_prev">
         <ul></ul>
         <div class="row pkrw" rel="0">
           <div class="col-lg-2 col-md-2 col-xs-4">
             <img class="thumbnail" src="{{ $admin_user->profile_image }}" height="64">
          </div>
          <div class="col-lg-2 col-md-2 col-xs-2">
             <a href="javascript:void(0);" class="btn btn-danger pkdel">Will Get Deleted Automatically</a>
          </div>
       </div>
    </div>
    <button type="submit" class="btn btn-primary btn-lg">Submit Admin User</button>
 </form>
</div>
</div>

</div>
</div>
@endsection
@section("scripts")
<script type="text/javascript">

  var  src = "{{ route('upload_user_profile') }}";
  var image_uploaded;
  $(document).ready(function($) {
    /// add typehead input 

    }); // load jquery function

    /// add typehead input 

    image_uploaded=0;
    $("form").submit(function(e){
       if($(".progress-bar").length == 1){
        if($(".progress-bar").html() != '100%' && image_uploaded != 1){
           swal("Please Wait!", "Please wait while image is uploading!", "error");
           e.preventDefault(e);
        }

     }

  });

    $("#image_file").pekeUpload({
       notAjax:false,
       url:src,
       data:{ '_token' : '{{ csrf_token() }}','last_used': $("input[name='last_used']").val() },
       allowedExtensions:"jpeg|jpg|png|gif",
       showPreview:true,
       dragMode:true,
       onSubmit:false,
       bootstrap:true,
       delfiletext:"Delete",
       limit:'1',
       limitError:"File Uploaded Already",
       dragText:"Drag and Drop your file here",
       onFileSuccess:function(file,data){
         $("input[name='last_used']").val(data.url);
         image_uploaded = 1;
      }
   });
</script>
@endsection 