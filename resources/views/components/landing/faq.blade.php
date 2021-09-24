

<div class="input-group mb-4 faq-search">
    <div class="input-group-prepend">
        <label class='input-group-text' for="faq-search">
          <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-search.svg" alt="icon search" width="25" height="25">
        </label>
    </div>
    <input type="text" class="form-control search-filter border-left-0 pl-0" placeholder="Search" data-id='faq'>
</div>

<div class='row justify-content-center faq-list'>
    @php  $faq_splitter = round(count($faqs)/2); @endphp
    @foreach ($faqs as $key => $item)
    @if ($key=='0' || $key== $faq_splitter)
    <div class='col-lg-6 faq-list'>
    @endif

    <div class='card  mb-3 position-relative overflow-hidden debutify-faq {{$key>=10?'d-md-block':''}} ' style="{{$key>=10?'display:none':''}}">
        <div class='bg-primary position-absolute faq-border-{{$key}}' style="left:0px; width:4px;height:100%;display: none;" ></div>
        <div class='bg-gray-500 position-absolute faq-border-{{$key}}' style="left:0px; width:4px;height:100%;"></div>
        <div class='card-header pointer' onclick="$('.faq-{{$key}}').slideToggle(); $('.faq-border-{{$key}}').toggle(); ">
            <span class='font-weight-bold text-black'>
                {!!$item['title']!!}
            </span>

            <span class='position-absolute' style="right:15px;">
                <div class='faq-border-{{$key}}' style="display: none">
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-minus.svg" alt="icon search" width="21" height="21">
                </div>
                <div class='faq-border-{{$key}} text-black'>
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-plus.svg" alt="icon search" width="19" height="19">
                </div>
            </span>
        </div>
        <div class='card-body faq-{{$key}}' style="display: none">
            {!!$item['content']!!}
        </div>
    </div>

    @if ($key==($faq_splitter-1) || $key==(count($faqs)-1))
        </div>
    @endif
    @endforeach
    <p id="noresults">Result not found.</p>
</div>

@if (count($faqs)>10)
    <button type="button" id='faq-view-more' class='btn btn-sm-block d-md-none btn-light' onclick="$('.debutify-faq').fadeIn('slow');$(this).hide()">
        View More
    </button>
@endif
