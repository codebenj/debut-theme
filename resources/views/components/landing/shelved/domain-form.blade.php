<form id='{{$id}}' action="{{$action}}"  target="_blank" style="{{$style??''}}">
    {{ csrf_field() }}
    <h4 class='text-center my-4'> Enter your shopify domain.</h4>
    <div class="form-group">
      <input class="form-control"  type="text" name="shop" placeholder="storename.myshopify.com" onkeyup="this.value = this.value.toLowerCase();" required>
    </div>

    <button type="submit" class="btn btn-primary btn-block">
      Try Debutify Free
    </button>

    @if ($alert??false)
        <div class="alert alert-success text-center small rounded-pill mt-3">
            To install Debutify theme, an active Shopify store is required. Don't have one yet?<br class="d-block d-sm-none">
            <a class="text-primary" target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website-modal-get-started">
            <u> Start your 14-Day free trial</u>
            </a>
        </div>  
    @endif
    
</form>