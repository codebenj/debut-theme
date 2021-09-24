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
<div class="mb-0 pagination-shop text-center ajax-pagination">{{ $products->appends(request()->except('page'))->links() }}</div>

<script type="text/javascript">
  $('a.page-link').click(function(evt){
      evt.preventDefault();
      var src = $(this).attr('href');
      $.ajax({
          url: src,
          dataType: "json",
          success: function(result) {
            if(result.status == 'success'){
              var html = result.html;
              $('.all-products').html(html);
            }
          }
      });
    });
</script>