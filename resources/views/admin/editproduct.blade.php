@extends('layouts.admin')

@section('styles')
<style>
.swal2-modal h2 {
    font-size: 20px !important;
}
</style>
@endsection

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
    <h4 class="card-header d-flex align-items-center">
      <span>Edit product</span>
      <button type="button" class="btn ml-auto" onclick="return deleted();">
        <span class="fas fa-trash-alt"></span>
      </button>
    </h4>
    <div class="card-body">
      <form method="POST" action="{{ route('edit_product', $product->id) }}" id="updateform" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="name">Product name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}" placeholder="" autofocus>
            </div>
            <div class="col-md">
              <label class="d-block" for="price">Price</label>
              <input type="number" max="1000" class="form-control" id="price" name="price" value="{{$product->price}}" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="cost">Cost</label>
              <input type="number" max="1000" class="form-control" id="cost" name="cost" value="{{$product->cost}}" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="profit">Profit</label>
              <input type="number" max="1000" class="form-control" id="profit" name="profit" value="{{$product->profit}}" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="saturation">Oportunity level</label>
              <select name="saturationlevel" id="saturation" class="form-control">
                <option value="bronze" {{ ($product->saturationlevel=='bronze')?'selected':''}}>Bronze</option>
                <option value="silver" {{ ($product->saturationlevel=='silver')?'selected':''}}>Silver</option>
                <option value="gold" {{ ($product->saturationlevel=='gold')?'selected':''}}>Gold</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="aliexpress">AliExpress link</label>
              <input type="text" class="form-control" id="aliexpress" name="aliexpresslink" value="{{$product->aliexpresslink}}" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="facebook">Facebook ads link</label>
              <input type="text" class="form-control" id="facebook" name="facebookadslink" value="{{$product->facebookadslink}}" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="google">Google trends link</label>
              <input type="text" class="form-control" id="google" name="googletrendslink" value="{{$product->googletrendslink}}" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="youtube">Youtube link</label>
              <input type="text" class="form-control" id="youtube" name="youtubelink" value="{{$product->youtubelink}}" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="competitor">Shopify website link</label>
              <input type="text" class="form-control" id="competitor" name="competitorlink" value="{{$product->competitorlink}}" placeholder="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="age">Age <small class="text-muted">(hold Ctrl or ⌘)</small></label>
              <select multiple name="age[]" id="age" class="form-control">
              @foreach($product->age as $ages)
              @if($ages['selected'] =='selected')
              <option value="{{ $ages['age']}}" selected>{{ $ages['age']}}</option>
              @else
              <option value="{{ $ages['age']}}">{{ $ages['age']}}</option>
              @endif
              @endforeach
              </select>
            </div>
            <div class="col-md">
              <label class="d-block" for="gender">Gender <small class="text-muted">(hold Ctrl or ⌘)</small></label>
              <select multiple name="gender[]" id="gender" class="form-control">
              @foreach($product->gender as $genders)
              @if($genders['selected'] =='selected')
              <option value="{{$genders['gender']}}" selected>{{$genders['gender']}}</option>
              @else
              <option value="{{$genders['gender']}}">{{$genders['gender']}}</option>
              @endif
              @endforeach
              </select>
            </div>
            <div class="col-md">
              <label class="d-block" for="placement">Placement <small class="text-muted">(hold Ctrl or ⌘)</small></label>
              <select multiple name="placement[]" id="placement" class="form-control">
              @foreach($product->placement as $placements)
              @if($placements['selected'] =='selected')
              <option value="{{$placements['placement']}}" selected>{{$placements['placement']}}</option>
              @else
              <option value="{{$placements['placement']}}">{{$placements['placement']}}</option>
              @endif
              @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="category">Category</label>
              <select class="form-control" id="category" name="category">
                <option value="none" @if($product->category == null) selected="selected" @endif disabled>-</option>
                <option value="fashion" @if($product->category == 'fashion') selected="selected" @endif>Fashion</option>
                <option value="health-beauty" @if($product->category == 'health-beauty') selected="selected" @endif>Health & Beauty</option>
                <option value="home-garden" @if($product->category == 'home-garden') selected="selected" @endif>Home & Garden</option>
                <option value="pet-accessories" @if($product->category == 'pet-accessories') selected="selected" @endif>Pet Accessories</option>
                <option value="electronics" @if($product->category == 'electronics') selected="selected" @endif>Electronics</option>
                <option value="baby-kids" @if($product->category == 'baby-kids') selected="selected" @endif>Baby & Kids</option>
                <option value="kitchen-household" @if($product->category == 'kitchen-household') selected="selected" @endif>Kitchen & Household</option>
              </select>
            </div>
            <div class="col-md">
              <label class="d-block" for="interest">Interest targeting <small class="text-muted">(comma-separated)</small></label>
              <input type="text" class="form-control" id="interest" name="interesttarget" value="{{$product->interesttarget}}" placeholder="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="opinion">Expert opinion</label>
              <textarea class="form-control" id="opinion" name="opinion" rows="4">{{$product->opinion}}</textarea>
            </div>
            <div class="col-md">
              <label class="d-block" for="description">Product description</label>
              <textarea class="form-control" id="description" name="description" rows="4">{{$product->description}}</textarea>
            </div>
          </div>
        </div>


        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="image">Product image link</label>
              <input type="text" class="form-control" name="saveimage" value="{{$product->image}}">
            </div>
            <div class="col-md">
              <label class="d-block" for="video">Product video link</label>
              <input type="text" class="form-control" name="saveVideo" value="{{$product->video}}">
            </div>
          </div>
        </div>

        {{--
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <div class="image-container">
                <input type="hidden" name="saveimage" value="{{$product->image}}">
                <img src="/images/product/{{ $product->image}}" class="rounded" name="" alt="" height="100" width="100">
                <label class="ml-3 edit-image" for=""><span class="fas fa-pen"></span> Edit Image</label>
              </div>
              <div class="file-image" style="display:none;">
                <label class="d-block" for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
              </div>
            </div>

            <div class="col-md">
              <div class="video-container">
                <input type="hidden" name="saveVideo" value="{{$product->video}}">
                <video class="rounded product-video" width="100" height="100" controls>
                  <source src="/product_video/{{ $product->video}}" type="video/mp4">
                  <source src="/product_video/{{ $product->video}}" type="video/ogg">
                </video>
                <label class="ml-3 edit-video" for=""><span class="fas fa-pen"></span> Edit Video</label>
              </div>
              <div class="file-video" style="display:none;">
                <label class="d-block" for="video">Video</label>
                <input type="file" class="form-control-file" id="video" name="video">
              </div>
            </div>

          </div>
        </div>
        --}}

        <button type="submit" class="btn btn-primary btn-lg">Update product</button>
      </form>
    </div>
  </div>

  </div>
</div>
@endsection
@section('scripts')
<script>
  $(document).ready(function() {
    $('.edit-image').click(function(){
      $('.image-container').hide();
      $('.file-image').show();
      $('#image').trigger("click");
    });
    $('.edit-video').click(function(){
      $('.video-container').hide();
      $('.file-video').show();
      $('#video').trigger("click");
    });
  });

  function deleted(){
    swal({
      title: 'Are you sure you want to delete this product ?',
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then(function() {
        var form = document.getElementById('updateform');
        
        form.setAttribute("action","{{ route('delete_product', $product->id) }}");
        form.submit();
    });
  }
</script>
@endsection
