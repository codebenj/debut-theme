@extends('layouts.admin')
@section('styles')
<style>
.results tr[visible='false'],
.no-result{
  display:none;
}
.results tr[visible='true']{
  display:table-row;
}
.pagination-shop .pagination{
  justify-content: center;
}
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

    <div class="form-group">
        <form class="form-inline" action="{{url()->current()}}">
                <!--@csrf-->
          <div class="form-group flex-fill">
            <input type="text" class="product_search form-control form-control-lg w-100" name="q" id="search" placeholder="Search product.." value="{{ $keyword }}">
          </div>
                <!-- <input type="Submit" value="Search" class="btn btn-primary btn-lg ml-2"> -->
            </form>
    </div>

    @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
    @endif

    <div class="all-products">
      <div class="mb-2 table-responsive rounded">
        <table class="table table-bordered table-hover mb-0 results">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Image</th>
              <th scope="col">Date</th>
              <th scope="col">Name</th>
              <th scope="col">Price</th>
              <th scope="col">AliExpress link</th>
              <th scope="col">Edit product</th>
            </tr>
            <tr class="warning no-result">
              <td colspan="7">No result</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $product)
            <tr>
              <th>{{ $product->id }}</th>
              <td><img src="{{ $product->image }}" alt="" width="50" class="rounded"></td>
              <td>{{ date('M d Y', strtotime($product->created_at)) }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->price }}</td>
              <td><a href="{{ $product->aliexpresslink }}" target="_blank">{{ $product->aliexpresslink }}</a></td>
              <td>
                <a href="{{ route('show_product', $product->id) }}" class="btn btn-primary btn-sm btn-block">
                  <span class="fas fa-pen"></span> edit
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mb-0 pagination-shop text-center">{{ $products->links() }}</div>
    </div>

  </div>
</div>

<a href="{{ route('addproduct') }}" class="btn btn-danger btn-lg rounded-circle shadow-lg btn-add-product">
  <span class="fas fa-plus"></span>
</a>
@endsection
@section('scripts')
<script>
  $(document).ready(function() {

    src = "{{ route('products_search') }}";
    $("#search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    q : request.term
                },
                success: function(result) {
                  if(result.status == 'success'){
                    var html = result.html;
                    $('.all-products').html(html);
                  }
                }
            });
        },
        minLength: 0,
    });

    // $(".search").keyup(function () {
    //   var searchTerm = $(".search").val();

    //   var listItem = $('.results tbody').children('tr');
    //   var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

    //   $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
    //         return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    //     }
    //   });

    //   $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
    //     $(this).attr('visible','false');
    //   });

    //   $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
    //     $(this).attr('visible','true');
    //   });

    //   var jobCount = $('.results tbody tr[visible="true"]').length;
    //   $('.counter').text(jobCount + ' item');

    //   if(jobCount == '0') {$('.no-result').show();}
    //   else {$('.no-result').hide();}
    // });
  });
</script>
@endsection
