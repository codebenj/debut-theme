@extends('layouts.debutify')
@section('title','support')
@section('view-support','view-support')

@section('styles')
@endsection

@if($all_addons != 1)
  @section('bannerTitle','available only on Paid plans')
  @section('bannerLink','upgrade to '. $starter .', '. $hustler . ' or '. $guru .' plans')
@endif

@section('content')
  @include("components.account-frozen-banner")
    <!-- skeleton -->
    <div class="Polaris-SkeletonPage__Page skeleton-wrapper text-center" role="status" aria-label="Page loading">
      <div class="Polaris-SkeletonPage__Content">

        <div class="row">
          <div class="col-12">
            <div class="Polaris-Card">
              <div class="Polaris-CalloutCard__Container">
                <div class="Polaris-Card__Section">
                  <div class="Polaris-CalloutCard">
                    <div class="Polaris-CalloutCard__Content">
                      <div class="Polaris-SkeletonThumbnail Polaris-SkeletonThumbnail--sizeMedium mx-auto mb-4"></div>
                      <div class="Polaris-TextContainer">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText mx-auto"></div>
                        </div>
                      </div>
                      <div class="Polaris-CalloutCard__Buttons">
                        <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeMedium mx-auto"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md">
            <div class="Polaris-Card">
              <div class="Polaris-CalloutCard__Container">
                <div class="Polaris-Card__Section">
                  <div class="Polaris-CalloutCard">
                    <div class="Polaris-CalloutCard__Content">
                      <div class="Polaris-SkeletonThumbnail Polaris-SkeletonThumbnail--sizeMedium mx-auto mb-4"></div>
                      <div class="Polaris-TextContainer">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText mx-auto"></div>
                        </div>
                      </div>
                      <div class="Polaris-CalloutCard__Buttons">
                        <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeMedium mx-auto"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md">
            <div class="Polaris-Card">
              <div class="Polaris-CalloutCard__Container">
                <div class="Polaris-Card__Section">
                  <div class="Polaris-CalloutCard">
                    <div class="Polaris-CalloutCard__Content">
                      <div class="Polaris-SkeletonThumbnail Polaris-SkeletonThumbnail--sizeMedium mx-auto mb-4"></div>
                      <div class="Polaris-TextContainer">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText mx-auto"></div>
                        </div>
                      </div>
                      <div class="Polaris-CalloutCard__Buttons">
                        <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeMedium mx-auto"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md">
            <div class="Polaris-Card">
              <div class="Polaris-CalloutCard__Container">
                <div class="Polaris-Card__Section">
                  <div class="Polaris-CalloutCard">
                    <div class="Polaris-CalloutCard__Content">
                      <div class="Polaris-SkeletonThumbnail Polaris-SkeletonThumbnail--sizeMedium mx-auto mb-4"></div>
                      <div class="Polaris-TextContainer">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText"></div>
                          <div class="Polaris-SkeletonBodyText mx-auto"></div>
                        </div>
                      </div>
                      <div class="Polaris-CalloutCard__Buttons">
                        <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeMedium mx-auto"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- page -->
    <div id="dashboard" style="display:none;">
      <div class="row text-center">

        <div class="col-12">
          <div class="Polaris-Card">
            <div class="Polaris-CalloutCard__Container">
              <div class="Polaris-Card__Section">
                <div class="Polaris-CalloutCard">
                  <div class="Polaris-CalloutCard__Content">
                    <img src="/svg/design.svg" alt="" class="Polaris-CalloutCard__Image mx-auto">
                    <div class="Polaris-CalloutCard__Title">
                      <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">
                        Debutify Help Center
                      </h2>
                    </div>
                    <div class="Polaris-TextContainer">
                      <p>Visit our Help Center and find answers to you questions in no time!</p>
                    </div>
                    <div class="Polaris-CalloutCard__Buttons">
                      <a class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge" href="https://help.debutify.com/" target="_blank" data-polaris-unstyled="true">
                        <span class="Polaris-Button__Content">
                          <span>Visit Help Center</span>
                        </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md">
          <div class="Polaris-Card">
            <div class="Polaris-CalloutCard__Container">
              <div class="Polaris-Card__Section">
                <div class="Polaris-CalloutCard">
                  <div class="Polaris-CalloutCard__Content">
                    <img src="/svg/illustration-2.svg" alt="" class="Polaris-CalloutCard__Image mx-auto">
                    <div class="Polaris-CalloutCard__Title">
                      <h2 class="Polaris-Heading">
                        Community support
                      </h2>
                    </div>
                    <div class="Polaris-TextContainer">
                      <p>Join our Facebook group and Discord server to chat with the community.</p>
                    </div>
                    <div class="Polaris-CalloutCard__Buttons">
                      <div class="Polaris-ButtonGroup justify-content-center">
                        <div class="Polaris-ButtonGroup__Item">
                          <a class="Polaris-Button" href="https://www.facebook.com/groups/434715920362644" data-polaris-unstyled="true" target="_blank">
                            <span class="Polaris-Button__Content"><span>Facebook group</span></span>
                          </a>
                        </div>
                        <div class="Polaris-ButtonGroup__Item">
                          <a class="Polaris-Button Polaris-Button--plain" href="https://discord.gg/RVC8QMk" data-polaris-unstyled="true" target="_blank">
                            <span class="Polaris-Button__Content"><span>Discord server</span></span>
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

        <div class="col-md">
          <div class="Polaris-Card">
            <div class="Polaris-CalloutCard__Container">
              <div class="Polaris-Card__Section">
                <div class="Polaris-CalloutCard">
                  <div class="Polaris-CalloutCard__Content">
                    <img src="/svg/tools.svg" alt="" class="Polaris-CalloutCard__Image mx-auto">
                    <div class="Polaris-CalloutCard__Title">
                      <h2 class="Polaris-Heading">
                        Account support
                      </h2>
                    </div>
                    <div class="Polaris-TextContainer">
                      <p>send us a message by chat or email and we will get back to you shorthly.</p>
                    </div>
                    <div class="Polaris-CalloutCard__Buttons">
                      <div class="Polaris-ButtonGroup justify-content-center">
                        <div class="Polaris-ButtonGroup__Item">
                          <button onclick="Intercom('show');" type="button" class="Polaris-Button" target="_blank" data-polaris-unstyled="true">
                            <span class="Polaris-Button__Content"><span>Live chat</span></span>
                          </button>
                        </div>
                        <div class="Polaris-ButtonGroup__Item">
                          <a class="Polaris-Button Polaris-Button--plain" href="mailto:support@debutify.com" target="_blank" data-polaris-unstyled="true">
                            <span class="Polaris-Button__Content"><span>Email</span></span>
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

        <div class="col-md">
          <div class="Polaris-Card">
            <div class="Polaris-CalloutCard__Container">
              <div class="Polaris-Card__Section">
                <div class="Polaris-CalloutCard">
                  <div class="Polaris-CalloutCard__Content">
                    <img src="/svg/support.svg" alt="" class="Polaris-CalloutCard__Image mx-auto">
                    <div class="Polaris-CalloutCard__Title">
                      <h2 class="Polaris-Heading">
                        Technical support
                      </h2>
                    </div>
                    <div class="Polaris-TextContainer">
                      <p>Contact our dedicated technical support team by live chat.</p>
                    </div>
                    <div class="Polaris-CalloutCard__Buttons">
                      <a href="{{config('env-variables.APP_PATH')}}technical-support" class="Polaris-Button" data-polaris-unstyled="true">
                        <span class="Polaris-Button__Content"><span>Technical support</span></span>
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
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
      // ESDK page and bar title
      {{--
      ShopifyTitleBar.set({
          title: 'Support',
      });
      --}}
  </script>
@endsection
