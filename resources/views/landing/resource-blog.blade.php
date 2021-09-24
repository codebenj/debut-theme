
@foreach($blogs as $key => $blog)
<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow">
        <div class="card-body">
            <a class='text-black' href="{{Route('blog_slug', $blog->slug)}}">
                <img alt="{{ $blog->alt_text }}" class="w-100 mb-3 rounded w-100 lazyload" data-src="{{ $blog->feature_image }}" >
                <h4>{{$blog->title}}</h4>
            </a>
        </div>
        
        <div class="card-footer text-mid-light small">
            <i class="far fa-calendar-alt"></i>  {{date('M d Y', strtotime($blog->blog_publish_date))}}
            <span class='mx-1'>|</span>
            <i class="far fa-file-alt	" ></i> {{floor(str_word_count(strip_tags($blog->description)) / 200 )." min read"}}
            
            <hr class='my-2'>
            
            <div class='text-primary'>
                <i class="text-primary far fa-folder"></i>
                @foreach($blog->categories as $k => $meta)
                <a  href="{{Route('blog_category_slug', $meta->slug)}}">
                    {{htmlspecialchars_decode($meta->meta_name)}}
                </a>
                @endforeach
                
                {{$blog->categories == '[]'?'No Category':''}}
            </div>
            
        </div>
    </div>

</div>
@endforeach