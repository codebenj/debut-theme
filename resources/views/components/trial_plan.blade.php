<style>
.custom-heading-size {
    font-size: 45px;
}
</style>
<h2 class="Polaris-DisplayText--sizeLarge text-center mt-5">Choose your preferred plan</h2>
<div class="row mt-4" id="free_trial_plan_section">
  <div class="col-md-4">
    <div class="Polaris-Card text-center pt-5 pb-5 pl-4 pr-4">
      <h2 class="Polaris-Heading mb-4 mt-4 custom-heading-size">
        <sup>$</sup>{{ floatval($starterPriceMonthly) }}</h2> <p class="mb-4">per month</p>

     <!--    <button type="button" class="Polaris-Button Polaris-Button--primary btn-loading mt-3 mb-5" onclick="return window.location='{{ route('checkout','starter')}}?monthly&trial_expire=IzdxKCF3'" id="starter_plan">
          <span class="Polaris-Button__Content">
            <span class="Polaris-Button__Text">Upgrade now</span>
          </span>
        </button> -->
         @include("components.starter-button")
        <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-4 mt-5">
          Starter
        </h2>
        <p>Debutify Theme Facebook, email, live chat (Full Support) Any 5 Add-ons Integrations.</p>

        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
          <strong>Plans</strong>
        </h3>
        <p>Store licence : 1</p>

        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
          <strong>Themes</strong>
        </h3>
        <p>Debutify theme </p>

        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong>Support</strong>
       </h3>
       <p>Help Center </p>
       <p>Community</p>
       <p>Technical</p>

       <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong>Add-Ons</strong>
       </h3>
       <h4>
        <strong>Any 5 Add-Ons</strong>
       </h4>
       <p>Add-to-cart animation </p>
       <p>Cart countdown </p>
       <p>Cart discount </p>
       <p>Cart goal </p>
       <p>Chat box </p>

       <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong> Product research</strong>
       </h3>
       <p>Oportunity level</p>
       <p>Weekly products : 15</p>
       <p>Videos</p>
       <p>Images</p>
       <p>Prices</p>

       <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong>Training Courses</strong>
       </h3>
       <p>Beginner Shopify Course<svg style="  width:15px; height:15px; vertical-align:text-bottom;" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></p>

       </div>
     </div>

     <div class="col-md-4">
      <div class="Polaris-Card text-center pt-5 pb-5 pl-4 pr-4">
        <h2 class="Polaris-Heading mb-4 mt-4 custom-heading-size">
         <sup>$</sup>{{ floatval($hustlerPriceMonthly) }}</h2>
         <p class="mb-4">per month</p>
<!-- 
         <button type="button" class="Polaris-Button Polaris-Button--primary btn-loading mt-3 mb-5" onclick="return window.location='{{ route('checkout','hustler')}}?monthly&trial_expire=IzdxKCF3'" id="starter_plan">
          <span class="Polaris-Button__Content">
            <span class="Polaris-Button__Text">Upgrade now</span>
          </span>
        </button> -->
         @include("components.hustler-button")

        <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-4 mt-5">
          Hustler
        </h2>
        <p>Debutify Theme Facebook, email, live chat (Full Support) 30 add-ons and future add-ons Integrations.</p>

        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
          <strong>Plans</strong>
        </h3>
        <p>Store licence : 1</p>

        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
          <strong>Themes</strong>
        </h3>
        <p>Debutify theme </p>

        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong>Support</strong>
       </h3>
       <p>Help Center </p>
       <p>Community</p>
       <p>Technical</p>

       <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong>Add-Ons</strong>
       </h3>
       <h4>
        <strong>Any 30 Add-Ons</strong>
       </h4>
       <p>Add-to-cart animation </p>
       <p>Cart countdown </p>
       <p>Cart discount </p>
       <p>Cart goal </p>
       <p>Chat box</p>
       <p>Collection add-to-cart</p>
       <p>Color swatches </p>
       <p>Cookie box</p>
       <p>Delivery time </p>
       <p>Discount Saved </p>
       <p>F.A.Q page</p>
       <p>Inventory quantity</p>
       <p>Linked options </p>
       <p>Live view </p>
       <p>Mega menu </p>
       <p>Newsletter pop-up </p>
       <p>Product tabs </p>
       <p>Product video</p>
       <p>Quick view</p>
       <p>Sales countdown </p>
       <p>Sales pop </p>
       <p>Shop protect </p>
       <p>Skip cart </p>
       <p>Smart search </p>
       <p>Sticky add-to-cart</p>
       <p>Trust badge </p>
       <p>Upsell bundles </p>
       <p>Upsell pop-up </p>
       <p>Wish list </p>


       <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong> Product research</strong>
       </h3>
       <p>Oportunity level : Silver</p>
       <p>Weekly products : 25</p>
       <p>Videos</p>
       <p>Images</p>
       <p>Prices</p>
       <p>Spy tools</p>
       <p>Audiences</p>
       <p>Interest targeting</p>

       <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
         <strong>Training Courses</strong>
       </h3>
       <p>Beginner Shopify Course<svg style="  width:15px; height:15px; vertical-align:text-bottom;" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></p>

         <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
           <strong>Integrations
           </strong>
         </h3>
         <p>Klaviyo<svg style="  width:15px; height:15px; vertical-align:text-bottom;" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></p>
           <p>Smsbump<svg style="  width:15px; height:15px; vertical-align:text-bottom;" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></p>

           </div>
         </div>

         <div class="col-md-4">
          <div class="Polaris-Card text-center pt-5 pb-5 pl-4 pr-4">
            <h2 class="Polaris-Heading mb-4 mt-4 custom-heading-size">
             <sup>$</sup>{{ floatval($guruPriceMonthly) }}</h2>
             <p class="mb-4">per month</p>
             
           <!--   <button type="button" class="Polaris-Button Polaris-Button--primary btn-loading mt-3 mb-5" onclick="return window.location='{{ route('checkout','master')}}?monthly&trial_expire=IzdxKCF3'" id="starter_plan">
              <span class="Polaris-Button__Content">
                <span class="Polaris-Button__Text">Upgrade now</span>
              </span>
            </button> -->
             @include("components.guru-button")
            <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-4 mt-5">
              Master
            </h2>
            <p>Debutify Theme Facebook, email, live chat (Priority Full Support) All Add-Ons and future Add-Ons Integrations Mentoring Product research tool Advanced Courses.</p>

            <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
              <strong>Plans</strong>
            </h3>
            <p>Store licence : 3</p>

            <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
              <strong>Themes</strong>
            </h3>
            <p>Debutify theme </p>

            <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
             <strong>Support</strong>
           </h3>
           <p>Help Center </p>
           <p>Community</p>
           <p>Technical</p>
           <p>Priority support</p>


           <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
             <strong>Add-Ons</strong>
           </h3>
           <h4>
            <strong>All {{ $addon_infos_count }} Add-Ons and all future Add-Ons</strong>
          </h4>
           <p>Add-to-cart animation </p>
           <p>Cart countdown </p>
           <p>Cart discount </p>
           <p>Cart goal </p>
           <p>Chat box</p>
           <p>Collection add-to-cart</p>
           <p>Color swatches </p>
           <p>Cookie box</p>
           <p>Delivery time </p>
           <p>Discount Saved </p>
           <p>F.A.Q page</p>
           <p>Inventory quantity</p>
           <p>Linked options </p>
           <p>Live view </p>
           <p>Mega menu </p>
           <p>Newsletter pop-up </p>
           <p>Product tabs </p>
           <p>Product video</p>
           <p>Quick view</p>
           <p>Sales countdown </p>
           <p>Sales pop </p>
           <p>Shop protect </p>
           <p>Skip cart </p>
           <p>Smart search </p>
           <p>Sticky add-to-cart</p>
           <p>Trust badge </p>
           <p>Upsell bundles </p>
           <p>Upsell pop-up </p>
           <p>Wish list </p>


           <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
             <strong> Product research</strong>
           </h3>
           <p>Oportunity level : Gold</p>
           <p>Weekly products : 30</p>
           <p>Videos</p>
           <p>Images</p>
           <p>Prices</p>
           <p>Spy tools</p>
           <p>Audiences</p>
           <p>Interest targeting</p>
           <p>Descriptions</p>
           <p>Expert opinion</p>

           <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
             <strong>Mentoring
             </strong>
           </h3>
           <p>Private 1-On-1 mentoring Facebook group<svg style="  width:15px; height:15px; vertical-align:text-bottom;" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"></p>
             <p>Chance to win a 1-On-1 private live mentoring call with Ricky Hayes for 30 minutes</p>

             <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4">
               <strong>Integrations
               </strong>
             </h3>
             <p>Klaviyo</p>
             <p>Smsbump</p>
           </div>
         </div> 

       </div>

