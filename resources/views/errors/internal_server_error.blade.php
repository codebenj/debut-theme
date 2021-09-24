<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="WycTb65S6Ia08R22qcEtBxNX8wphOuLZpVOFUsUw">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!-- Google ptimize -->
	<script src="https://www.googleoptimize.com/optimize.js?id=OPT-P8N97L2"></script>

	<!-- Fav icon ================================================== -->
	<link sizes="192x192" rel="shortcut icon" href="/images/debutify-favicon.png" type="image/png">

	<title>Debutify</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@5.10.1/dist/styles.css" />
	<!--<link rel="stylesheet" href="/css/debutify.css?version=1610004134" />-->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" />

	<link rel="stylesheet" href="/css/debutify.css?v=8" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

	<style>
		#dashboard{
			min-height: 100vh;
		}
		 .Polaris-FooterHelp{
			display:none;
		}
		.page-container{
			margin-left: 0px;
		}
		.main{
			margin-top: 0px;
		}

		
		@media only screen and (min-width:768px)
		{
			.top_messsage{
					padding-top: 4em; 
			} 
		}

		.error_notice {
			    word-break: break-all;
			}

	</style>


	<script src="/js/app.js?v=8"></script>

</head>

<body class="template-Thank you">
	<div class="main">
		<div class="page-container">
			<div >
				<style>
					button.Polaris-Modal-CloseButton.close-modal {
						position: absolute;
						right: 15px;
						top: 10px;
					}
					.Polaris-Modal-Header.text-center {
						position: relative;
					}
				</style>
		 
			
			<div id="dashboard">
				<section class="plan-upgradingSection">
						<div class="Polaris-CalloutCard__Container">
							<div class="Polaris-Card__Section">
								<div class="row justify-content-center">
									<div class="Polaris-Page-Header Polaris-Page-Header--separator">
                  
                  <div class="Polaris-Page-Header__MainContent">
                    <div class="Polaris-Page-Header__TitleActionMenuWrapper">
                      <div>
                        <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                          <div class="Polaris-Header-Title">
                            <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge page-title text-center">Sorry for inconvenience</h1>
                            <p class="Polaris-DisplayText--sizeSmall text-center mb-5">We're sorry you've lost your track..Try again to ignite your experience.</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
									<div class="col-md-10">
										<div class="row">
								          <div class="col-md-6">
								            <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued h3 mt-4 mb-5">
								                <p class="top_messsage"><strong>Sorry for inconvenience, please contact our support.</strong></p>
								                @if(Session::has('error_message'))

													<p class="Polaris-DisplayText--sizeSmall mt-5 mb-5 error_notice"><strong>Error Notice: </strong>{{ Session::get('error_message') }}</p>
													@php session()->forget(['error_message']); 	@endphp
													@endif
													@php 
														session()->forget(['error_message']);
													@endphp
								            </div>
								          </div>
								        <div class="col-md-6">
								              <img src="/svg/empty-state-12.svg" role="presentation" alt="" class="Polaris-EmptyState__Image">
								        </div>
								        </div>




										<div class="text-center">

											<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;" class="mb-5">
												<button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading" onclick="return window.location = '{{ route('home') }}'"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text text-light">Return to dashboard</span></span></button>
											</div>

											<a href="mailto:support@debutify.com">Contact support</a>
										</div>
									</div>
								</div>
							</div>
						</div>
				</section>
			</div>
		 
	</div>
</div>
</div>


<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<!-- Shopify -->
<script src="https://cdn.shopify.com/s/assets/external/app.js?2021010707"></script>

<!-- Shopify/Polaris -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous"></script>


</body>
</html>
