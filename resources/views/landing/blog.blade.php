@extends('layouts.landing')
@section('title',$seo_title??'Blog | Debutify')
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('content')

@php
$counter = 0;
$blog_title = "<span class='debutify-underline-lg'>Debutify Blog</span>";
if(isset($tag_category_name) && !empty($tag_category_name)){
  $blog_title = $page_title.' : '.htmlspecialchars_decode($tag_category_name['meta_name']);
}

$blog_description = '';
if(isset($result_count)){
  $blog_description = "We found {$result_count} results for your search";
  if(isset($term_search_value) && $term_search_value != ''){
    $blog_description .= ' "'.$term_search_value.'"';
  }
}
@endphp

<div class='debutify-section'>
  <div class='container'>
    <div class='text-center'>
      <h1 class='display-3'>{!!$blog_title!!}</h1>
      <p class='lead mt-4'>{{$blog_description}}</p>
    </div>
  </div>
</div>

@if (Request::is('blog') && $blogs[0]??0)
<section class='debutify-section'>
  <div class='container'>
    <div class='row'>
      <div class='col-lg-8'>
        <div class='card shadow mb-4'>
          <div class='card-body'>
            <a class="text-black" href="{{Route('blog_slug', $blogs[0]->slug)}}">
              <div class="responsive-container-16by9 mb-3">
                <img alt="{{ $blogs[0]->alt_text }}" class="rounded w-100 lazyload mb-3" data-src="{{ $blogs[0]->feature_image }}?v={{config('image_version.version')}}" />
              </div>
              <h1> {{$blogs[0]->title}} </h1>
            </a>
          </div>
          <div class='card-footer text-mid-light d-flex align-items-center flex-wrap justify-content-lg-start justify-content-center'>
            <img class="lazyload mr-2 d-inline-block"  alt="icon folder" data-src="/images/landing/icons/icon-folder.svg" width="18" height="18" />
            @foreach($blogs[0]->categories as $k => $meta)
            <a class='text-reset'  href="{{Route('blog_category_slug', $meta->slug)}}">
              {{htmlspecialchars_decode($meta->meta_name)}}
            </a>
            @endforeach
            <span class='mx-2'>|</span>
            <img class="lazyload mr-2 d-inline-block"  alt="icon calendar" data-src="/images/landing/icons/icon-calendar.svg" width="18" height="18" />
            {{date('M d Y', strtotime($blogs[0]->blog_publish_date))}}
            <span class='mx-2'>|</span>
            <img class="lazyload mr-2 d-inline-block"  alt="icon glass" data-src="/images/landing/icons/icon-glass.svg" width="20" height="20" />
            {{floor(str_word_count(strip_tags($blogs[0]->description)) / 200 )." min read"}}
          </div>
        </div>

        @if (count($featured_posts))
        <div class='card shadow border-top-primary mb-4'>
          <div class='card-body'>
            <div id="blog-featured">
              @foreach ($featured_posts as [$most_popular, $picked_by_editors])
              <div class='row d-flex flex-row'>
                @for ($i = 0; $i <= 1; $i++)
                  <div class='col-md-6 mb-4'>
                    <div class='d-flex flex-column align-items-start'>
                      @if ($counter % 2 == 0)
                      <div class="d-flex flex-row">
                        <img class='lazyload mr-3' data-src="/images/landing/icon-popular.svg" alt="" width="36" height="36" class='mr-2'> <h4 class='font-weight-bold m-0'>Most Popular</h4>
                      </div>
                      @if (isset($most_popular->categories) && $most_popular->categories != null)
                      <p class='my-2 '>
                        <img class="lazyload mr-2 d-inline-block"  alt="icon folder" data-src="/images/landing/icons/icon-folder.svg" width="18" height="18" />
                        @foreach($most_popular->categories as $k => $meta)
                        <a class='text-reset'  href="{{Route('blog_category_slug', $meta->slug)}}">
                          {{htmlspecialchars_decode($meta->meta_name)}}
                        </a>
                        @endforeach
                      </p>
                      <a class="text-black" href="{{ url('blog/' . $most_popular->slug) }}">{{ $most_popular->title }}</a>
                      @endif
                      @endif
                      @if ($counter % 2 != 0)
                      <div class="d-flex flex-row">
                        <img class='lazyload mr-3' data-src="/images/landing/icon-design.svg" alt="" width="36" height="36" class='mr-2'> <h4 class='font-weight-bold m-0'>Editor's Picks</h4>
                      </div>
                      @if (isset($picked_by_editors->categories) && $picked_by_editors->categories != null)
                      <p class='my-2 '>
                        <img class="lazyload mr-2 d-inline-block"  alt="icon folder" data-src="/images/landing/icons/icon-folder.svg" width="18" height="18" />
                        @foreach($picked_by_editors->categories as $k => $meta)
                        <a class='text-reset'  href="{{Route('blog_category_slug', $meta->slug)}}">
                          {{htmlspecialchars_decode($meta->meta_name)}}
                        </a>
                        @endforeach
                      </p>
                      <a class="text-black" href="{{ url('blog/' . $picked_by_editors->slug) }}">{{ $picked_by_editors->title }}</a>
                      @endif
                      @endif
                    </div>
                  </div>
                @php
                $counter++
                @endphp
                @endfor
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @endif
      </div>
      <div class='col-lg-4'>
        <x-landing.newsletter class='mb-4'/>
          <div class='card bg-primary shadow'>
          <div class='card-body'>
            <img class='lazyload float-right' data-src="/images/landing/blog-explore.svg" width="120" >
            <h4 class='text-white'>2020 State of <br> Marketing <br> Report</h4>
              <x-landing.download-btn class='btn debutify-hover btn-secondary btn-sm mt-3' cta='X' label='Explore the Report'/>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<section class='debutify-section'>
  <div class="container">
    <form id="blog-search" class="mb-4" method="POST" action="{{ route('search_blogs') }}">
      {{ csrf_field() }}
      <div class='form-row'>
        <div class="col-lg-6 mb-3">
          <div class="input-group">
            <div class="input-group-prepend ">
              <button class="btn btn-light" type="submit">
                <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-search.svg" alt="icon search"width="25" height="25"/>
              </button>
            </div>
            <input type="text" class="form-control border-left-0 pl-0" id="search_title" name="search_title" placeholder="Search..." value="{{$search_field_value['search_title']??''}}" >
          </div>
        </div>
        <div class="col-lg-3 mb-3">
          <select class="selectpicker" data-live-search="true" data-width='100%' data-size="6" id="category" name="search_by_category">
            <option value="">Category...</option>
            @foreach($all_tags_and_cat['blog_category']??[] as $key => $category)
            <option value="{{ $key }}" {{(($search_field_value['search_by_category']??'')== $key)?'selected':''}}>
              {{htmlspecialchars_decode($category)}}
            </option>
            @endforeach
          </select>
        </div>
        <div class='col-lg-3 mb-3'>
          <select class="selectpicker" data-live-search="true"  data-width="100%" data-size="6" id="tag" name="search_by_tag" >
            <option selected value="">Tag...</option>
            @foreach($all_tags_and_cat['blog_tag']??[] as $key => $blog_tag)
            <option value="{{ $key }}" {{(($search_field_value['search_by_tag']??'')== $key)?'selected':''}}>


              {{-- @if (strlen($blog_tag)>10)
                {{substr($blog_tag, 0, 7) . '...'}}
              @else
                {{ $blog_tag }}
              @endif --}}


              {{ $blog_tag }}
            </option>
            @endforeach
          </select>
        </div>
      </div>
      <input type="submit" hidden/>
    </form>

    <div id="blogs-container">
      <div class="row justify-content-center">
        @if(isset($blogs) && !empty($blogs) && count($blogs) != 0)
        @foreach($blogs as $key => $blog)
        <div class="col-md-6 col-lg-4 mb-4">
          <x-landing.blog-template :blog="$blog"/>
        </div>
        @endforeach

        @else
        <div class='col'>
          <h1 class='text-center my-5'>Result not found!</h1>
        </div>
        @endif
      </div>

      @php  $querystringArray = ['search' => request()->get('search')];  @endphp
      {!! $blogs->appends(request()->get('search_title') != null ? ['search_title' => request()->get('search_title')] : '')->links('vendor.pagination.default')->render() !!}
    </div>
  </div>
</section>

<section class='debutify-section'>
  <div class='container'>
    <div class='card border-top-primary mb-5'>
      <div class='card-body'>
        <h2 class="mb-3">More Topics</h2>
        <div class='row'>
          @foreach($get_all_blog_meta_categories as $category)
          <div class='col-md-4'>
            <div class='d-flex align-items-center mb-3'>
              <img class='lazyload mr-2' data-src="/images/landing/cta-check.svg" alt="" width="20" height="20">
              <a class="text-black" href="{{Route('blog_category_slug', $category['slug'])}}">
                {{htmlspecialchars_decode($category['meta_name'])}}
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class='card bg-light overflow-hidden py-5'>
      <div class='card-body'>
        <div class=' text-center'>
          <h1> {{$nbShops}}+ Are Reading The Debutify Newsletter. </h1>
          <p class='my-4'>Get bite-sized lessons from leading experts in the world of e-commerce.  <br class='d-none d-lg-block'>
            Improve your business in 5 minutes a week. Subscribe today:
          </p>
        </div>
        <img class='lazyload position-absolute d-lg-block d-none' style="left:-100px;bottom:0px;" data-src="/images/landing/newsletter-prop-infinite-animated.svg" alt="" width="300px">
        <form id='blogNewsletter'>
          <div class='form-row justify-content-center position-relative'>
            <div class='col-12 col-lg-6 '>
              <div class='form-group'>
                <input type="email" class='form-control form-control-sm mb-3' placeholder="Enter your email address" name='email' pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required>
              </div>
            </div>
            <div class='col-12 col-lg-2'>
              <button type="submit" class="ml-lg-2 btn btn-primary btn-sm btn-block mb-3"> Subscribe now </button>
            </div>
            <div class='col-12 col-lg-8' >
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="blogNewsletterCheckbox" name="" required>
                <label class="custom-control-label" for="blogNewsletterCheckbox">
                  <small> I agree to receive regular updates from Debutify. <a href="/privacy-policy">View Privacy Policy here.</a></small>
                </label>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function() {

    $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
          url : url,
          data: {
            search_title: $("#search_title").val(),
            search_by_category: $("#category").val(),
            search_by_tag: $("#tag").val(),
          },
        }).done(function (result) {
          $('#blogs-container').html(result.html);
          window.history.pushState("", "", url);
          document.getElementById('blog-search').scrollIntoView();
        }).fail(function () {
            alert('Articles could not be loaded.');
        });
    });

    $("#blog-search").on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: "{{ route('search_blogs') }}",
        data: {
          search_title: $("#search_title").val(),
          search_by_category: $("#category").val(),
          search_by_tag: $("#tag").val(),
        },
        success: function(result) {
          $('#blogs-container').html(result.html);
          window.history.pushState("", "", "{{ route('search_blogs') }}");
        }
      })
    });

    $("#search_title").keyup($.debounce(function(e) {
      $("#blog-search").submit();
    },500));

    $("#category").change($.debounce(function(e) {
      $("#blog-search").submit();
    },500));

    $("#tag").change($.debounce(function(e) {
      $("#blog-search").submit();
    },500));
  });
</script>
@endsection
