<div id="UpdateVideoModal" class="modal fade-scales" style="display:none;">
    <div>
        <div class="Polaris-Modal-Dialog__Container undefined" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
                <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header2" tabindex="-1">
                    <div class="Polaris-Modal-Header">
                        <div id="modal-header2" class="Polaris-Modal-Header__Title">
                            <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall update-title">{{ $updates->modal_title }} <span class="Polaris-Badge Polaris-Badge--statusSuccess update-date_created"><?php if (isset($updates->created_at)) {echo date("F d, Y", strtotime($updates->created_at));}?> </span></h2>
                        </div>
                        <button class="Polaris-Modal-CloseButton close-modal" aria-label="Close">
                            <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                    <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div class="Polaris-Modal__BodyWrapper">
                        <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                            <section class="Polaris-Modal-Section">
                                <?php if (isset($updates->video) && $updates->video === "") {?>
                                <img  class="rounded shadow img-fluid mb-5" src="{!! isset($updates->image) ? $updates->image : ""  !!}" >
                                <?php } else {?>
                                <div class="mb-5 embed-responsive rounded shadow embed-responsive-16by9 Polaris-TextContainer video-tutorial" style="margin-top:2rem;">
                                    <iframe id="video_link" class="embed-responsive-item"  src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <?php }?>
                                <div class="Polaris-TextContainer">
                                    <p class="update-subtitle">{!! isset($updates->description) ? $updates->description : ""  !!} </p>
                                </div>
                            </section>
                        </div>
                    </div>
                    <div class="Polaris-Modal-Footer">
                        <div class="Polaris-Modal-Footer__FooterContent">
                            <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                                <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                                <div class="Polaris-Stack__Item">
                                    <div class="Polaris-ButtonGroup">
                                        <div class="Polaris-ButtonGroup__Item">
                                            <button type="button" class="close-modal Polaris-Button">
                                            <span class="Polaris-Button__Content">
                                            <span class="Polaris-Button__Text">Close</span>
                                            </span>
                                            </button>
                                        </div>
                                        <div class="Polaris-ButtonGroup__Item">
                                            <a class="Polaris-Button Polaris-Button--primary" tabindex="0"  href="{{ $updates->footer_button_link }}" data-polaris-unstyled="true">
                                            <span class="Polaris-Button__Content">
                                            <span class="Polaris-Button__Text">
                                            {{ $updates->footer_button_text }}
                                            </span>
                                            </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="Polaris-Backdrop"></div>
    </div>
</div>