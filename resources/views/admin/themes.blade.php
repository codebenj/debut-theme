@extends('layouts.admin')
@section('styles')
<style>
.btn-add-product{
  position: fixed;
  bottom: 30px;
  right: 30px;
}
</style>
@endsection
@section('content')
<div class="row">
  <div class="col">

    @if (session('status'))
      <div class="alert alert-success" role="alert">
        {{ session('status') }}
      </div>
    @endif

    <div class="form-group">
      <input type="text" id="search" name="q" class="search form-control form-control-lg" placeholder="Search themes.." >
    </div>

    <div class="table-responsive rounded">
            <div id="themes_search">
               @include("admin.theme_table")
            </div>
    </div>

  </div>
</div>

<a href="{{ route('addtheme') }}" class="btn btn-danger btn-lg rounded-circle shadow-lg btn-add-product">
  <span class="fas fa-plus"></span>
</a>
@endsection

@section("scripts")
  <script type="text/javascript">
    
      $(document).ready(function() {
          src = "{{ route('search_theme') }}";
          $("#search").autocomplete({
              source: function(request, response) {
                  $.ajax({
                      url: src,
                      dataType: "json",
                      data: {
                          query : request.term
                      },
                      success: function(result) {
                          $('#themes_search').html(result.html);
                      }
                  });
              },
              minLength: 0,
          });

          // is beta theme
          $('input.is_beta_theme').change(function() {
              if(this.checked) {
                 var is_beta_theme = 1;
              }else{
                 var is_beta_theme = 0;
              }

              var id = $(this).attr("data-id");
              var theme_version = $(this).attr("data-version");


               $.ajax({
                url: '{{ route('save_beta_theme')}}',
                type: 'POST',
                data: { _token: "{{ csrf_token() }}", is_beta_theme: is_beta_theme, id: id, save_beta_theme: "save_beta_theme",theme_version: theme_version},
                dataType: 'JSON',
                success: function(result) {
                    if(result.status == 'success'){
                          swal("Thanks", result.message, "success");
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  console.log("error");
                }
            });
          });
          // is beta theme

        });

    </script>
    @endsection
