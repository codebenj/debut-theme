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
