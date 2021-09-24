<div class="row accordion-section">
  <div class="col">
    <div class="accordion" id="faq">
      @foreach ($faqs as $faqIndex => $faq)
      <div class="faq mb-3">
        <a class="btn btn-light btn-block btn-lg collapsed" type="button" data-toggle="collapse" data-target="#a{{ $faq->id }}" aria-expanded="{{ $faqIndex == 0 ? 'true' : 'false' }}" aria-controls="a{{ $faq->id }}">
          <span class="fas fa-question-circle text-primary"></span>
          {{ $faq->title }}
        </a>
        <div id="a{{ $faq->id }}" class="collapse" aria-labelledby="q{{ $faq->id }}" data-parent="#faq">
          <div class="card-body">
          {{ $faq->content }}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
