<div class='text-center'>
    <h1 class="{{$color=='secondary'?'text-white':''}}"> {{$title}} </h1>
    <p class='lead mb-4'>{{$description}} </p>
</div>

<div class="row align-items-center my-3">
    <div class="col-lg-6  d-flex justify-content-end">
        <img class='w-100  lazyload my-3 debutify-dropshadow-sm' style="max-width: 533px" data-src="images/landing/template-16by9.png" alt="addon 1 video">
    </div>
    <div class="col-lg-6">
        <h2 class="{{$color=='secondary'?'text-white':''}}">
            <del class='text-decoration-color-{{$color}}'> ${{$price}}/yr.</del>  
            <span class="text-{{$color}}">FREE*</span>
        </h2>
        <div class="badge badge-pill badge-secondary mb-2 px-3">Increase Conversation Rate up to {{$increase}}% *</div>
        <p class="mb-4">
            <small>*Actual results may vary.  *Compared with app  
                <a class='text-{{$color}}' target="_blank" href="https://apps.shopify.com/{{$compareLink}}">
                    "{{$compareName}}"
                </a>
            </small> 
        </p>

        @foreach ($checkList  as $item)
        <div class='d-flex my-2' >
            <img class="lazyload mt-1 mr-2" data-src="images/landing/cta-check.svg" alt="cta check" width="20px" height="20px">
            <span><?=$item?></span>
        </div>
        @endforeach        
    </div>
</div>
