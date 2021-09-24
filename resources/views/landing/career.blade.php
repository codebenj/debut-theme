@extends('layouts.landing')
@section('title','Careers at Debutify | #1 Shopify Theme Developers')
@section('description','Join the team of experts who are behind the highest converting Debutify theme. Check out current vacant positions and apply now.')


@section('content')

<section class='debutify-section '>
	<div class='container'>

		@if (request()->get('gh_jid'))
		<button class='btn btn-primary btn-sm' onclick="window.history.back()"> <i class='fas fa-angle-left mt-2'></i> Go Back</button>
		@endif

		@if (!request()->get('gh_jid'))

		<div class='text-center'>
			<h1 class='display-3 mb-5'><span class='debutify-underline-sm'>Careers</span></h1>
			<p class='lead mb-5'>Join the team behind the World's #1 Free Shopify Theme.</p>
		</div>
		<h1 class='text-center mb-5'>The Core Values We Uphold</h1>
		<x-landing.values/>
		@endif

		<div id='grnhse_focus' tabindex="1"></div>
		<div id="grnhse_app"  style="visibility: hidden;"></div>

		<div id='grnhse_loader' >
			<div class='d-flex justify-content-center text-primary  mt-5'>
				<div class="spinner-border mr-2" style="width: 3rem; height: 3rem;"></div>
				<h1 class='text-primary'>Loading...</h1>
			</div>
		</div>

	</div>
</section>

@endsection

@section('scripts')
<script src="https://boards.greenhouse.io/embed/job_board/js?for=debutify" async></script>
<script>
	window.addEventListener('DOMContentLoaded', function() {

		var check_content = setInterval(function() {
			if($("#grnhse_app").html().length > 0){
				$('#grnhse_loader').fadeOut(()=>{
					$('#grnhse_app').css({opacity: 0.0, visibility: "visible"}).animate({opacity: 1.0});
				});
				clearInterval(check_content);
			}
		},300);
	});
</script>
@endsection
