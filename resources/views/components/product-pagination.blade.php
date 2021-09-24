@if ($paginator->hasPages())
<div class="Polaris-ButtonGroup Polaris-ButtonGroup--segmented pagination justify-content-center mt" data-buttongroup-segmented="true">

  <div class="Polaris-ButtonGroup__Item">
    @if ($paginator->previousPageUrl())
    <a href="{{$paginator->previousPageUrl()}}" class="Polaris-Button btn-pagination">
    @else
    <a href="JavaScript:void(0);" class="Polaris-Button Polaris-Button--disabled" disabled="">
    @endif
      <span class="Polaris-Button__Content">
        <span class="Polaris-Icon">
          <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
            <path d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2" fill-rule="evenodd"></path>
          </svg>
        </span>
        <span class="Polaris-Button__Text"></span>
      </span>
    </a>
  </div>

  <div class="Polaris-ButtonGroup__Item">
    @if ($paginator->nextPageUrl())
    <a href="{{$paginator->nextPageUrl()}}" class="Polaris-Button btn-pagination">
    @else
    <a href="JavaScript:void(0);" class="Polaris-Button Polaris-Button--disabled" disabled="">
    @endif
      <span class="Polaris-Button__Content">
        <span class="Polaris-Icon">
          <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
            <path d="M17.707 9.293l-5-5a.999.999 0 1 0-1.414 1.414L14.586 9H3a1 1 0 1 0 0 2h11.586l-3.293 3.293a.999.999 0 1 0 1.414 1.414l5-5a.999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
          </svg>
        </span>
        <span class="Polaris-Button__Text"></span>
      </span>
    </a>
  </div>
</div>


{{--<nav class="Polaris-Pagination" aria-label="Pagination">

  @if ($paginator->previousPageUrl())
  <!-- <button type="button" class="Polaris-Pagination__Button Polaris-Pagination__PreviousButton" aria-label="Previous"> -->
    <a href="{{$paginator->previousPageUrl()}}" class="Polaris-Pagination__Button Polaris-Pagination__PreviousButton btn-pagination pagination-link" rel="prev">
      <span class="Polaris-Icon">
        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <path d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2" fill-rule="evenodd"></path>
        </svg>
      </span>
    </a>
  <!-- </button> -->
  @else
  <!-- <button type="button" class="Polaris-Pagination__Button Polaris-Pagination__PreviousButton Polaris-Button--disabled" disabled="" aria-label="Previous"> -->
    <a href="JavaScript:void(0);" rel="prev" class="Polaris-Pagination__Button Polaris-Pagination__PreviousButton pagination-link">
      <span class="Polaris-Icon">
        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <path d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2" fill-rule="evenodd"></path>
        </svg>
      </span>
    </a>
  <!-- </button> -->
  @endif

  @if ($paginator->nextPageUrl())
  <!-- <button type="button" class="Polaris-Pagination__Button Polaris-Pagination__NextButton" aria-label="Next"> -->
    <a href="{{$paginator->nextPageUrl()}}" rel="next" class="Polaris-Pagination__Button Polaris-Pagination__NextButton btn-pagination pagination-link">
      <span class="Polaris-Icon">
        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <path d="M17.707 9.293l-5-5a.999.999 0 1 0-1.414 1.414L14.586 9H3a1 1 0 1 0 0 2h11.586l-3.293 3.293a.999.999 0 1 0 1.414 1.414l5-5a.999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
        </svg>
      </span>
    </a>
  <!-- </button> -->
  @else
  <!-- <button type="button" class="Polaris-Pagination__Button Polaris-Pagination__NextButton Polaris-Button--disabled" disabled="" aria-label="Next"> -->
    <a href="JavaScript:void(0);" rel="next" class="Polaris-Pagination__Button Polaris-Pagination__NextButton pagination-link">
      <span class="Polaris-Icon">
        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <path d="M17.707 9.293l-5-5a.999.999 0 1 0-1.414 1.414L14.586 9H3a1 1 0 1 0 0 2h11.586l-3.293 3.293a.999.999 0 1 0 1.414 1.414l5-5a.999.999 0 0 0 0-1.414" fill-rule="evenodd"></path>
        </svg>
      </span>
    </a>
  <!-- </button> -->
  @endif

</nav>--}}




@endif
