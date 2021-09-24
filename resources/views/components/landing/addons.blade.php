@if ($id==1)
    @if(isset($global_add_ons) && is_object($global_add_ons))
        <div class="input-group mb-5">
            <div class="input-group-prepend ">
                <label class='input-group-text' for="addons-search">
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-search.svg" alt="icon search" width="25" height="25"/>
                </label>
            </div>
            <input type="text" class="form-control border-left-0 search-filter pl-0" placeholder="Search" data-id='addons'>
        </div>

        <div class='row addons-list justify-content-center'>
            @foreach ($global_add_ons as $key => $item)
            <div class='addons col-md-6 col-lg-4 mb-4  {{$key>2 && $key<=11?'d-md-block':''}}' style="{{$key>2?'display:none':''}}" >
                <div class='card shadow h-100'>
                    <div class='card-header text-center'>
                        <h4> {{$item['name']}} </h4>
                    </div>

                    <div class='bg-primary'>
                    <x-landing.wistia-video-player type='modal' :embedId="$item['wistia_video_id']"/>
                    </div>
                    <div class='card-footer text-center'>
                        <p>
                            {{$item['description']}}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
            <p id="noresults">Result not found.</p>
        </div>

        @if($nbAddons >= 12)
        <div class='text-center'>
            <button type='button' id='addons-view-more'  class='btn btn-sm-block  btn-light' onclick="$('.addons').fadeIn('slow'); $(this).hide(); ">
                View all {{$nbAddons}}+ Add-Ons
            </button>
        </div>
    @endif
@endif

@elseif($id == 2)
    @if(isset($global_add_ons) && is_object($global_add_ons))
        <div class='row' >
            @foreach ($global_add_ons as $key => $item)

                <div class="pointer col-6 col-sm-4 col-md-3 col-lg-2 debutify-addons mb-5 {{$showAll??true?'d-lg-block':''}} {{$key>=6 && $key<12?'d-md-block':''}}" style="{{$key>=6?'display:none':''}}" >
                    <x-landing.wistia-video-player type="slot" :embedId="$item['wistia_video_id']">
                        <div class='card shadow py-4 debutify-hover'>
                            <div class='card-body'>
                                <img class='lazyload' data-src="{{$item->icon_url}}" alt="" width="70" height="70">
                            </div>
                        </div>
                        <h4 class='mt-4'>{{$item['name']}}</h4>
                    </x-landing.wistia-video-player>
                </div>
            @endforeach
        </div>

        @if($nbAddons >= 12)
        <button type="button" class='btn btn-sm-block btn-lg btn-light mt-5 debutify-hover {{$showAll??true?'d-md-none':''}}'  onclick="$('.debutify-addons').fadeIn('slow');$(this).hide()">
            View All {{$nbAddons}}+ Add-Ons
        </button>
        @endif

    @endif
@endif
