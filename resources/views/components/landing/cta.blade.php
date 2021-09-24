<div class="{{$class??''}}">
      <div class='w-100' style="max-width: 500px;">

         @if ($widget??'true')
         <div class='row my-4 no-gutters'>
            <div class='col-4'>
               <div class='w-100 debutify-badge1' data-rw-badge1="22396"></div>
            </div>
            <div class='col-4'>
               <div class='w-100 debutify-badge1' data-rw-badge1="22415"></div>
            </div>
            <div class='col-4'>
               <div class='w-100 debutify-badge1' data-rw-badge1="22416"></div>
            </div>
         </div>
         @endif

         <button type="button" class='download-cta debutify-hover btn btn-lg btn-sm-block align-items-center mr-md-3 mb-3 {{$download}}' data-cta-tracking="cta-{{$cta}}" data-toggle="modal" data-target="#downloadModal">
            Try Debutify Free
              <img class='d-inline-block' src="/images/landing/icons/icon-right-arrow.svg" alt="icon right arrow" width="30" height="30">
         </button>

         <a role="button"  class='btn btn-lg debutify-hover  btn-sm-block mb-3 {{$demo}}' href='https://debutifydemo.myshopify.com/' target="_blank" >
            View Demo
         </a>

         @if ($checklist??'true')
         @php
         $cta_text = [
         'Get up and running in minutes',
         'No credit card required',
         ];
         @endphp

     <div class='text-mid-light'>
        @foreach ($cta_text as $item)
        <div>
           <img class='d-inline-block' src="/images/landing/icons/icon-check-grey.svg" alt="icon check" width="15" height="15"> {{$item}}
        </div>
        @endforeach
     </div>
     @endif
  </div>
</div>
