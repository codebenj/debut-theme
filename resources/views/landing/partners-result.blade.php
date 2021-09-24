@if(!count($partners))
<h2 class='text-center my-5'>Result not found!</h2>
@else
<div class="row text-center justify-content-center">
  @foreach($partners as $partner)
  <div class="col-md-4 mb-4">
    <div class="card h-100 shadow">
      <div class="card-body">
        <a class='text-black Polaris-Thumbnail integration-images' href="{{ $partner->slug ? route('partners.show', $partner->slug) : $partner->link }}" style="" >
          <div class="responsive-container-16by9">
            <img class="lazyload mb-3 partners-img w-100 integration-images-img" data-src="{{$partner->logo}}?v={{config('image_version.version')}}" alt="{{$partner->name}}">
          </div><br>
        </a>

        @if($partner->offer_description)
          <div class='my-4 badge badge-pill badge-secondary badge-sm'>
            {{ $partner->offer_description }}
          </div>
        @endif

        @if($partner->popular == 1)
          <div class='my-4 badge badge-pill badge-warning badge-sm'>
            Popular
          </div>
        @endif

        @if($partner->newTag)
          <div class='my-4 badge badge-pill badge-info badge-sm'>
            New
          </div>
        @endif

        <div>
          <a class='text-black' href="{{ $partner->slug ? route('partners.show', $partner->slug) : $partner->link }}" >
          <h4>{{ $partner->name}} </h4>

          @php ($description = html_entity_decode(htmlspecialchars_decode(strip_tags($partner->description), ENT_QUOTES)))

          @if(strlen($description) > 90 && preg_match('/\s/', $description))
            @php ($blog_description = substr($description, 0, strpos($description, ' ', 90)))
           {{ $blog_description }}...
          @else
           {!! $partner->description !!}
          @endif
          </a>
        </div>
      </div>

      <div class="card-footer p-0">
        <x-landing.download-btn class='btn-primary btn-sm btn-sm-block' cta='X' label="Activate Offer" />
        <hr>
        <div class='my-3 d-flex justify-content-center text-muted align-items-center'>
          <img class="lazyload mr-2 d-inline-block" data-src="/images/landing/icons/icon-folder-black.svg" alt="icon folder" width="18" height="18"/>
          <div>
            @foreach($partner->categories as $category)
            <a class="text-muted mr-2" href="{{ route('partners.landing', ['category' => $category]) }}">
              {{ $category }}
            </a>
            @endforeach

            @if (!count($partner->categories))
            No Category
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endif
