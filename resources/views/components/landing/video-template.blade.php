<div class="card h-100 shadow">
    <div class="card-body">
        <x-landing.video-player  :link='$video->video_id' type='inline'  resolution='maxresdefault' />
        <h4 class='mt-2'>
            <a class='text-black' href="{{Route('video_slug', $video->slug)}}"> {{$video->title}} </a>
        </h4>
    </div>
    <div class="card-footer text-mid-light small">
      <div class="d-flex align-items-center">
        <img class="lazyload mr-2 d-inline-block" data-src="/images/landing/icons/icon-calendar.svg" alt="icon calendar" width="18" height="18"/> {{date('M d Y', strtotime($video->publish_date))}}
        <span class='mx-1'>|</span>
        <img class="lazyload mr-2 d-inline-block" data-src="/images/landing/icons/icon-play-circle.svg" alt="icon play" width="18" height="18" />  {{ $video->watching_time??'Xh' }}
      </div>
          <hr class='my-2'>
        <div class='text-primary'>
            <img class="lazyload mr-2 d-inline-block" data-src="/images/landing/icons/icon-folder-blue.svg" alt="icon folder" width="18" height="18" />
            @foreach($video->categories as $k => $meta)
            <a class='text-primary' href="{{Route('video_category_slug', $meta->slug)}}">
                {{htmlspecialchars_decode($meta->meta_name)}}
            </a>
            @endforeach
            {{$video->categories == '[]'?'No Category':''}}
        </div>
    </div>
</div>
