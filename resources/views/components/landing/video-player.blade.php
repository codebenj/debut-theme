{{-- Experimental Player --}}

<style>
.play-button{
    width: 80px;  height: 80px;
    left: 50%; top: 50%;
    margin-left: -40px; margin-top: -40px;
    z-index: 1;
 }
 
</style>

<div class='position-relative {{$link?'video-player pointer':''}} ' data-link='{{$link}}' data-type='{{$type}}'>
   
    @if ($link)
    <div class='position-absolute h-100 w-100 debutify-animation-wrapper ' data-animation-target='video-{{$link}}' style="z-index: 2"> </div>
    
    <img class='play-button position-absolute lazyload ' data-src="/images/landing/debutify-play-button-animated.svg" alt="">
    {{-- <object class='play-button position-absolute lazyload debutify-hover'  data-object="/images/landing/debutify-play-button-animated.svg" type="image/svg+xml"></object>     --}}
    
    {{-- <object class='play-button position-absolute lazyload' id='video-{{$link}}' data-object="/images/landing/debutify-play-button-animated.svg" type="image/svg+xml"></object>     --}}
    {{-- <img class='play-button position-absolute lazyload ' data-src="/images/landing/debutify-play-button.svg"  alt="play button"> --}}
    
    @endif

    <div class='position-relative videoThumbnail'>
        <div class="img-responsive-16by9 bg-primary {{$imageClass??'rounded'}}">
            <img 
            class="position-relative w-100 lazyload {{$imageClass??'rounded'}} "
            data-src="{{$image??'https://img.youtube.com/vi/'.$link.'/'.($resolution??'maxresdefault').'.jpg'}}" 
            alt="player thumbnail"
            />
        </div>
    </div>
    
    <div class='position-relative videoInline' style="display: none">
        <div class="embed-responsive embed-responsive-16by9" >
            <iframe src="" class='{{$imageClass??'rounded'}} border-0'  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div> 
    </div>

</div>


