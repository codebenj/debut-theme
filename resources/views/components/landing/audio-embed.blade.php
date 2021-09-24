{{-- <div class='rounded overflow-hidden'>
    <script src="https://fast.wistia.com/embed/medias/{{ $audioURL }}.jsonp" async></script> 
    <div class="wistia_embed wistia_async_{{ $audioURL }} seo=false" style="width:100%;height:218px;position:relative"></div>
</div> --}}

<div class='lazyload_wistia rounded overflow-hidden {{$audioURL?'pointer':''}}' data-wistia-id="{{$audioURL}}" data-wistia-type="{{$type}}" data-wistia-autoplay='{{$autoplay??'True'}}'>
    <div style="padding:{{$padding??''}} 0 0 0;position:relative;">
        <div class='wistia_embed seo=false text-center' style="height:100%;width:100%; position:absolute; top:0;left:0;">
            
            @if ($img??0)
            <img class='pointer rounded lazyload' data-src='{{$img}}' style="max-width: 160px"/>
            @else
            <img class='wistia_image pointer rounded' data-wistia-id="{{$audioURL}}" style="max-width: 160px"/>
            @endif

        </div>
    </div> 
</div>