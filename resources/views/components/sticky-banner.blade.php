@if (in_array(\Route::current()->getName(), $routes))
    <div class="sticky-banner">
        @include('components.trial-banner')
    </div>
@endif
