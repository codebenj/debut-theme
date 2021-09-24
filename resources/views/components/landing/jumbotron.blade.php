
<section>
    <div class='container text-center py-5'>
       <p class='lead mb-5'> <span class='{{($id??1)==1?'text-black display-3 ':''}}'>{!!$title!!}</span></p>
        @if ($description)
        <p class='mt-2'><span class='{{($id??1)==2?'text-black display-3 ':''}}'> {!!$description!!}</span></p>
        @endif
    </div>
</section>
