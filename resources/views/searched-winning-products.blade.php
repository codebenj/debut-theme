@include("components.product-result")

<div class="mt text-center search-pagination">
  {{ $productspagination->appends(request()->except('page'))->links('components.product-pagination') }}
</div>

<script type="text/javascript">
  $('.search-pagination a').on('click', function(evt){
  // $(document).on('click','.search-pagination a', function(evt){
    evt.preventDefault();
    // console.log('page clicked');
    var src = $(this).attr('href');

    $(".loader").show();
    loadingBarCustom();


    $.ajax({
        url: src,
        dataType: "json",
        success: function(result) {
          if(result.status == 'success'){
            console.log("change page success");
            var html = result.html;
            $('.all-products').html(html);

            // remove loading
            $(".loader").hide();
            loadingBarCustom(false);

          }
        }
    });
  });
</script>
