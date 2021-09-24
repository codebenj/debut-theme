<div class='row justify-content-center'>
    @if (isset($podcasts) && !empty($podcasts) && count($podcasts) != 0)
    @foreach($podcasts as $key => $podcast)
    <div class="col-md-6 col-lg-4 mb-5">
        <x-landing.podcast-template :podcast='$podcast'/>
    </div>
    @endforeach
    @else
    <div class='col'>
        <h1 class='text-center my-5'>Result not found!</h1>
    </div>
    @endif
</div>

<?php $querystringArray = ['search' => request()->get('search')];?>
{!! $podcasts->links('vendor.pagination.default')->render() !!}