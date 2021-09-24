
<div class='lazyload_wistia {{$embedId?'pointer':''}} {{$class??''}}' data-wistia-id="{{$embedId}}" data-wistia-type="{{$type}}" data-wistia-autoplay='{{$autoplay??'True'}}' style="{{$style??''}}">
    @if ($type=='slot')
    {{$slot}}
    @else
    <div style="padding:56.25% 0 0 0;position:relative;">
        <div class='wistia_embed' style="height:100%;width:100%; position:absolute; top:0;left:0;">
            <img class='wistia_image w-100 pointer' data-wistia-id="{{$embedId}}" />
        </div>
    </div> 
    @endif
</div>