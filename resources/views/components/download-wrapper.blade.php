<div class="download-wrapper text-center">
    <div class="user-ratings mb-3">
        @include ("components.star-rating-badges")
    </div>
    <div class="download-btn">
    <button class="btn btn-primary btn-lg mb-3 animated pulse infinite download-cta" data-cta-tracking="{{ $cta_tracking ?? '' }}" data-toggle="modal" data-target="#downloadModal"><span class="fas fa-download"></span> Free Download Now</button>
        {{-- <img src="images/new/arrow-yellow.png" alt="" class="img-fluid arrow-img animated pulse infinite" /> --}}
    </div>
    <p class="download-text">
        <span class="fas fa-check-circle"></span> Easy install
        <span class="fas fa-check-circle"></span> No coding needed
        <br>
        <span class="fas fa-check-circle mt-2"></span> No credit card needed
    </p>
</div>
