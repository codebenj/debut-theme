@extends('layouts.admin')

<style type="text/css">
  a.theme_dashboard button.btn.btn-primary {
      margin-bottom: 10px;
  }
</style>

@section('content')
<div class="row">
  <div class="col">

    <div class="card">
      <h4 class="card-header">Upload new theme version</h4>
      <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('new_theme') }}" enctype="multipart/form-data">
             {{ csrf_field() }}
          <!-- <div class="form-group">
            <label for="formGroupExampleInput">Theme Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="">
          </div> -->
          <div class="form-group">
            <label for="version">Theme Version</label>
            <input required type="text" class="form-control" id="version" name="version" placeholder="">
          </div>

        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="is_beta_theme" id="is_beta_theme" name="is_beta_theme">
          <label class="form-check-label" for="is_beta_theme">
            Beta Theme
          </label>
        </div>


          <div class="form-group">
            <label for="theme_file">Upload File</label>
            <input required type="file" class="form-control-file" id="theme_file" name="theme_file" accept="application/zip">
          </div>
          <button type="submit" class="btn btn-primary btn-lg">Submit theme</button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
