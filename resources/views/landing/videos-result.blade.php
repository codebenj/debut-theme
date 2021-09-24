<div class="row justify-content-center">
    @if (isset($videos) && !empty($videos) && count($videos) != 0)

    @foreach($videos as $video)
    <div class="col-md-6 col-lg-4 mb-4">
        <x-landing.video-template :video='$video'/>
    </div>
    @endforeach
    @else
    <div class='col'>
        <h1 class='text-center my-5'>Result not found!</h1>
    </div>
    @endif
</div>

@php  $querystringArray = ['search' => request()->get('search')];  @endphp
{!! $videos->links('vendor.pagination.default')->render() !!}