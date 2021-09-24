
@if ($link??0)
<a role='button' class="download-cta {{$class??''}} text-decoration-none" data-cta-tracking="cta-{{$cta??'X'}}"  data-toggle="modal" data-target="#downloadModal">
    {!!$label??'Try Debutify Free'!!}
    @if ($arrow??0)
    <img class="lazyload  d-inline-block"  data-src="/images/landing/icons/icon-right-arrow-blue.svg" alt="arrow blue" width="15" height="15">
    @endif
</a>
@else
<button type="button" class='download-cta btn {{$class??''}}' data-cta-tracking="cta-{{$cta??'X'}}" data-toggle="modal" data-target="#downloadModal">
    {!!$label??'Try Debutify Free '!!}
    @if ($arrow??0)
        <img class="lazyload  d-inline-block" data-src="/images/landing/icons/icon-right-arrow.svg"  alt="right-arrow" width="30" height="30"/>
    @endif
    @if ($subscribe??0)
        <img class="lazyload ml-2  d-inline-block" data-src="/images/landing/icons/icon-subscribe-white.svg"  alt="right-arrow" width="20" height="20"/>
    @endif
</button>
@endif
