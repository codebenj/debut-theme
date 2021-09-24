@if($subscription_status == 'unpaid')
    <div class="subscriptionUnpaidBanner Polaris-Banner Polaris-Banner--statusCritical Polaris-Banner--withinPage {{ isset($class) ? $class : '' }}" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner4Heading" aria-describedby="Banner4Content">
        <div class="Polaris-Banner__Ribbon">
            <span class="Polaris-Icon Polaris-Icon--colorRedDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                    <path d="M11.768.768a2.5 2.5 0 0 0-3.536 0L.768 8.232a2.5 2.5 0 0 0 0 3.536l7.464 7.464a2.5 2.5 0 0 0 3.536 0l7.464-7.464a2.5 2.5 0 0 0 0-3.536L11.768.768zM9 6a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V6zm2 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
            </span>
        </div>
        <div>
            <div class="Polaris-Banner__Heading" id="Banner4Heading">
                <p class="Polaris-Heading">Failed payment: your account has been frozen</p>
            </div>
            <div class="Polaris-Banner__Content" id="Banner4Content">
                <p>Debutify access will be restored once your account has been updated with a valid payment method.</p>
                @if(request()->route()->getName() !== 'billing')
                <div class="Polaris-Banner__Actions">
                    <div class="Polaris-ButtonGroup">
                        <div class="Polaris-ButtonGroup__Item">
                            <div class="Polaris-Banner__PrimaryAction">
                                <a type="button" class="Polaris-Button Polaris-Button--outline" href="{{ route('billing') }}">
                                    <span class="Polaris-Button__Content">
                                        <span class="Polaris-Button__Text">Update payment method</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endif