<div class='card h-100 shadow'>
    <div class='card-body'>
        <x-landing.audio-embed :audioURL="$podcast->podcast_widget" type='inline' padding='56.25%' :img='$podcast->feature_image'/>
        <h4 class='mt-2'>
            <a class="text-black" href="{{Route('podcast_slug', $podcast->slug)}}">{{$podcast->title}} </a>
        </h4>
    </div>

    <div class='card-footer text-mid-light small'>
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-calendar.svg" alt="icon calendar" width="18" height="18"> {{date('M d Y', strtotime($podcast->podcast_publish_date))}}
        <span class='mx-1'>|</span>
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-microphone.svg" alt="icon microphone" width="18" height="18">  {{ $podcast->transcript_time??'Xh' }} Listening Time

        <hr class='my-2'>

        <div class='text-primary'>
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-folder-blue.svg"  alt="icon folder" width="18" height="18">
        @foreach($podcast->categories as $k => $meta)
        <a class='text-primary' href="{{Route('podcast_category_slug', $meta->slug)}}">
            {{htmlspecialchars_decode($meta->meta_name)}}
        </a>
         @endforeach
         {{$podcast->categories == '[]'?'No Category':''}}
        </div>
    </div>
</div>
