@extends('layouts.admin')


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
      <h4 class="card-header">New Extend Feature</h4>
      <div class="card-body">
        <form method="POST" id="createCourse" action="{{ route('extend_trial_edit',$extendtrial_feature->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="d-block" for="name">Name</label>
            <input type="text" class="form-control" id="feature_name" name="feature_name" placeholder="name" value="{{ $extendtrial_feature->name}}">
          </div>
          <div class="form-group">
            <label class="d-block" for="name">Description</label>
            <textarea class="ckeditor-description form-control" id="feature_description" name="feature_description" rows="4">{{ $extendtrial_feature->description}}</textarea>
          </div>
          <div class="form-group">
            <label class="d-block" for="image">Extend Days</label>
            <input type="number" class="form-control" id="extend_days" name="extend_days" placeholder="extend days" value="{{$extendtrial_feature->extend_trial_days}}">
          </div>

          	<div class="form-group">
	            <button type="submit" class="btn btn-primary btn-lg" id="create-course">
	              <span class="btn-text">
	                Update feature
	              </span>
	              <span class="btn-loading" style="display:none;">
	                <span class="fas fa-spin fa-spinner"></span>
	              </span>
	            </button>
          	</div>
        </form>
      </div>
    </div>

  </div>
</div>


@endsection
@section("scripts")
<script>
  $(document).ready(function($) {    
    $('.ckeditor-description').ckeditor({
      allowedContent: true,
    }); 
  });
</script>
@endsection