<div id="updateAddonsModal" class="modal updateAddons fade-scales" style="display:none;">
    <div>
        <form action="{{route('force_Update_Active_addons')}}" method="post" id="force-all-addon-form">
            @csrf
                <div class="Polaris-Modal-Dialog__Container undefined" data-polaris-layer="true" data-polaris-overlay="true">
                    <div>
                        <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header2" tabindex="-1">
                            <div class="Polaris-Modal-Header">
                                <div id="modal-header2" class="Polaris-Modal-Header__Title">
                                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall update-title">Updating Debutify Theme Manager<span class="Polaris-Badge Polaris-Badge--statusSuccess update-date_created"></span></h2>
                                </div>
                            </div>
                            <div class="Polaris-Modal__BodyWrapper">
                                <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                                    <section class="Polaris-Modal-Section">
                                        Please wait until the app update is complete, this process can take up to 4 minutes per Debutify theme (including your unpublished debutify theme). 
                                        <br/><br/>
                                        Thank you for your patience and get ready to see your store's page load speed greatly improved!
                                        <br/><br/>
                                        - The Debutify team
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

                                                    <button type="button" class="Polaris-Button Polaris-Button--primary force_all_addon_update1 disable-while-loading1" tabindex="0"  data-polaris-unstyled="true" onclick="return forceUpdateAllAddons(1);">
                            <span class="Polaris-Button__Content">
                              <span class="Polaris-Button__Text">Run the adapter</span>
                            </span>
                                                    </button></div></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Backdrop"></div>
        </form>
    </div>
</div>
<script>
    function forceUpdateAllAddons(type){
        loadingBarCustom();
        $('.disable-while-loading' + type).addClass('Polaris-Button--disabled').prop("disabled", true);
        $('.force_all_addon_update' + type).addClass('Polaris-Button--loading');
        $('.force_all_addon_update' + type).html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Run the adapter</span></span>');

        var form = document.getElementById('force-all-addon-form');
        form.submit();
    }
</script>




<div id="updateShopModal" class="modal updateShop fade-scales" style="display:none;">
    <div>
        <div class="Polaris-Modal-Dialog__Container undefined" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
                <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header2" tabindex="-1">
                    <div class="Polaris-Modal-Header">
                        <div id="modal-header2" class="Polaris-Modal-Header__Title">
                            <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall update-title">Update Debutify Theme Manager<span class="Polaris-Badge Polaris-Badge--statusSuccess update-date_created"></span></h2>
                        </div>
                    </div>
                    <div class="Polaris-Modal__BodyWrapper">
                        <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                            <section class="Polaris-Modal-Section">
                                Our team is working really hard to improve your store's page load speed, this update is the first step in making Debutify the fastest Shopify theme on the market.
                                <br/><br/>
                                An update of Debutify Theme Manager is required to apply these changes, please click the button below to go to Shopify's update page.
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

                                            <a type="button" href="{{ $script_tags_url }}" class="Polaris-Button Polaris-Button--primary disable-while-loading1" tabindex="0"  data-polaris-unstyled="true">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Button__Text">Update Debutify Theme Manager</span>
                    </span>
                                            </a></div></div>

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