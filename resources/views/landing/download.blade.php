@extends('layouts.landing')
@section('title','Download Debutify Shopify Theme')
@section('description','Download and install Debutify free Shopify theme in 1 click. Safe and easy installation. Start selling today - download Debutify now')

@section('content')

<section class='debutify-section '>
	<div class='container'>
		<div class='text-center mb-4'>
			<h1 class='display-3'>Download Free <br> Shopify Theme</h1>
			<p class='lead'>Install or login into Debutify Theme Manager.</p>
		</div>

		<div class='row justify-content-center'>
			<div class='col-md-6'>
				
				<form id='downloadDomainForm' action="{{route('authenticate')}}"  target="_blank" >
					{{ csrf_field() }}
					<h4 class='text-center my-4'> Enter your shopify domain.</h4>
					<div class="form-group">
						<input class="form-control"  type="text" name="shop" placeholder="storename.myshopify.com" onkeyup="this.value = this.value.toLowerCase();" pattern=".+myshopify.com" title="storename.myshopify.com" required>
					</div>
					
					<button type="submit" class="btn btn-primary btn-block">
						Try Debutify Free
					</button>
					
					<div class="alert alert-success text-center small rounded-pill mt-3">
						To install Debutify theme, an active Shopify store is required. Don't have one yet?<br class="d-block d-sm-none">
						<a class="text-primary" target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website-modal-get-started">
							<u> Start your 14-Day free trial</u>
						</a>
					</div>  
				</form>
			</div>
		</div> 
		
	</div>
</section>
@endsection


@section('scripts')

<script>
	document.addEventListener("DOMContentLoaded", function(){
		
		@if (config('app.env') == 'production' || config('app.env') == 'staging')
		if(sessionStorage.getItem("initiateDownload")){} else{
			window.dataLayer.push({'event': 'initiate_download'});
			sessionStorage.setItem('initiateDownload','yes');
		};
		@endif
		
		$("#downloadDomainForm").one('submit', function(e) {
            e.preventDefault();

			const domainValue = $(this).find("input[name='shop']").val();
				if(domainValue){
					localStorage.setItem("shopDomain" , domainValue)
				}

            @if (config('app.env') == 'production' || config('app.env') == 'staging')
				//webpushr custom attribute complete_registration
				webpushr('attributes',{"Complete Registration" : "True"});
				//complete registration tracking
				window.dataLayer.push({'event': 'complete_registration'});
				@endif
            $(this).submit();

			window.location.href = "/thank-you";
        });


	
		
	});
</script>
@endsection
