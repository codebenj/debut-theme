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
    <h4 class="card-header">Upload new product</h4>
    <div class="card-body">
      <form method="POST" action="{{ route('new_product') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="name">Product name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="" autofocus>
            </div>
            <div class="col-md">
              <label class="d-block" for="price">Price</label>
              <input type="number" max="1000" class="form-control" id="price" name="price" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="cost">Cost</label>
              <input type="number" max="1000" class="form-control" id="cost" name="cost" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="profit">Profit</label>
              <input type="number" max="1000" class="form-control" id="profit" name="profit" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="saturation">Opotunity level</label>
              <select name="saturationlevel" id="saturation" class="form-control">
                <option value="bronze">Bronze</option>
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="aliexpress">AliExpress link</label>
              <input type="text" class="form-control" id="aliexpress" name="aliexpresslink" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="facebook">Facebook ads link</label>
              <input type="text" class="form-control" id="facebook" name="facebookadslink" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="google">Google trends link</label>
              <input type="text" class="form-control" id="google" name="googletrendslink" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="youtube">Youtube link</label>
              <input type="text" class="form-control" id="youtube" name="youtubelink" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="competitor">Shopify website link</label>
              <input type="text" class="form-control" id="competitor" name="competitorlink" placeholder="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="age">Age <small class="text-muted">(hold Ctrl or ⌘)</small></label>
              <select multiple name="age[]" id="age" class="form-control">
                <option value="18-24" selected>18-24</option>
                <option value="25-34">25-34</option>
                <option value="35-44">35-44</option>
                <option value="45-54">45-54</option>
                <option value="55-64">55-64</option>
                <option value="65+">65+</option>
              </select>
            </div>
            <div class="col-md">
              <label class="d-block" for="gender">Gender <small class="text-muted">(hold Ctrl or ⌘)</small></label>
              <select multiple name="gender[]" id="gender" class="form-control">
                <option value="Men" selected>Men</option>
                <option value="Women">Women</option>
                <!-- <option value="Men and Women">Men and Women</option> -->
              </select>
            </div>
            <div class="col-md">
              <label class="d-block" for="placement">Placement <small class="text-muted">(hold Ctrl or ⌘)</small></label>
              <select multiple name="placement[]" id="placement" class="form-control">
                <option value="Mobile" selected>Mobile</option>
                <option value="Desktop">Desktop</option>
                <!-- <option value="Mobile and Desktop">Mobile and Desktop</option> -->
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="category">Category</label>
              <select class="form-control" id="category" name="category">
                <option value="fashion">Fashion</option>
                <option value="health-beauty">Health & Beauty</option>
                <option value="home-garden">Home & Garden</option>
                <option value="pet-accessories">Pet Accessories</option>
                <option value="electronics">Electronics</option>
                <option value="baby-kids">Baby & Kids</option>
                <option value="kitchen-household">Kitchen & Household</option>
              </select>
            </div>
            <div class="col-md">
              <label class="d-block" for="interest">Interest targeting <small class="text-muted">(comma-separated)</small></label>
              <input type="text" class="form-control" id="interest" name="interesttarget" placeholder="">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="opinion">Expert opinion</label>
              <textarea class="form-control" id="opinion" name="opinion" rows="4"></textarea>
            </div>
            <div class="col-md">
              <label class="d-block" for="description">Product description</label>
              <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="image">Product image link</label>
              <input type="text" class="form-control" id="image" name="image" placeholder="">
            </div>
            <div class="col-md">
              <label class="d-block" for="video">Product video link</label>
              <input type="text" class="form-control" id="video" name="video" placeholder="">
            </div>
          </div>
        </div>
        <!-- <div class="form-group">
          <div class="form-row">
            <div class="col-md">
              <label class="d-block" for="image">Image</label>
              <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <div class="col-md">
              <label class="d-block" for="video">Video</label>
              <input type="file" class="form-control-file" id="video" name="video">
            </div>
          </div>
        </div> -->
        <button type="submit" class="btn btn-primary btn-lg">Submit product</button>
      </form>
    </div>
  </div>

  </div>
</div>
@endsection
