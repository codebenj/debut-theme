
<form id='{{$id}}'>  
  
  @if ($header??false)
    <h4 class='text-center my-4'>  {{$header}} </h4>  
  @endif

  <div class='form-group has-error'>
    <div class="input-group mt-2 ">
      <div class="input-group-prepend">
        <label class='input-group-text ' for="{{$id}}Name">
          <i class='far fa-user'></i>
        </label>
      </div>
      <input id="{{$id}}Name"  name="name" type="text" class="form-control border-left-0"  placeholder="{{$nameLabel}}" required>
    </div>
  </div> 

  <div class='form-group'>
    <div class="input-group mt-2">
      <div class="input-group-prepend">
        <label class='input-group-text' for="{{$id}}Email">
          <i class='far fa-envelope'></i>
        </label>
      </div> 
      <input  id="{{$id}}Email" name="email" type="email" class="form-control border-left-0" placeholder="{{$emailLabel}}" required>
    </div>
  </div>
  
  <button type="submit" class='btn btn-{{$color}} btn-block my-3'>
    {{$btnLabel}}
  </button>

  <div class="custom-control custom-checkbox {{$color=='secondary'?'text-white':''}}">
    <input type="checkbox" class="custom-control-input" id="{{$id}}Checkbox" name="" >

    <label class="custom-control-label " for="{{$id}}Checkbox">I agree to receive updates from Debutify. <a href="/privacy-policy" class='text-secondary'> Privacy Policy.</a> </label>
  </div>
  

  @if ($alert??false)
  <div class="alert alert-primary text-center rounded-pill mt-2" >
    🎁 BONUS: Recive 5 Free Winning Products
  </div>
  @endif

</form>