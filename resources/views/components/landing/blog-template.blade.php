<div class="card h-100 shadow">
  <div class="card-body pb-0">
      <a class='text-black' href="{{Route('blog_slug', $blog->slug)}}">
        <div class="responsive-container-16by9 mb-3">
          <img alt="{{ $blog->alt_text }}" class="w-100 mb-3 rounded w-100 lazyload" data-src="{{ $blog->feature_image }}?v={{config('image_version.version')}}" />
        </div>
        <h4 >{{$blog->title}}</h4>
      </a>
  </div>
    <div class="card-footer text-mid-light small">   
        <img class="lazyload d-inline-block"  alt="icon calendar" data-src="/images/landing/icons/icon-calendar.svg" width="18" height="18" />  {{date('M d Y', strtotime($blog->blog_publish_date))}}
        <span class='mx-2'>|</span>
        <img class="lazyload d-inline-block"  alt="icon glass" data-src="/images/landing/icons/icon-glass.svg" width="20" height="20" /> {{floor(str_word_count(strip_tags($blog->description)) / 200 )." min read"}}
    
        <hr class='my-2'>
        <div class='text-primary d-flex align-items-center flex-wrap'>
        <img class="lazyload mr-2 d-inline-block"  alt="icon folder" data-src="/images/landing/icons/icon-folder-blue.svg" width="18" height="18" />
        @foreach($blog->categories as $k => $meta)
        <a  href="{{Route('blog_category_slug', $meta->slug)}}">
          {{htmlspecialchars_decode($meta->meta_name)}}
        </a>
        @endforeach
        
         {{$blog->categories == '[]'?'No Category':''}}
        </div>
    </div>
</div>
