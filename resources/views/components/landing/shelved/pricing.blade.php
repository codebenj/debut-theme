<style>
    @media only screen and (min-width:992px) {
   .scale-price{ transform: scale(1.2,1.14); top:20px; }
   }
</style>

<div  style="max-width:320px" class='mx-auto text-center'>

    <div class='row'>
        <div class='col'></div>
        <div class='col'> <span class='badge badge-sm badge-secondary mb-2'>Save 10% </span></div>
        <div class='col'> <span class='badge badge-sm badge-secondary mb-2'>Save 50% </span></div>
    </div>
    <div class="btn-group  btn-group-sm mb-3">
        <button type="button" data-plan="monthly" class="btn btn-light pricing-group-btn px-3">Monthly</button>
        <button type="button" data-plan="quarterly" class="btn btn-light pricing-group-btn px-3">Quarterly</button>
        <button type="button" data-plan="yearly" class="btn btn-primary pricing-group-btn px-3">Yearly</button>
    </div>
</div>

<div class='row pt-lg-5 my-lg-5 pt-md-3 my-md-3'>
    @foreach ([
    ['cta'=>'X','btn'=>'btn-outline-secondary','plan'=>'Free','license'=>1,'price'=>0,'features'=>['1 store licence','Private Facebook group access','Basic support']],
    ['cta'=>'X','btn'=>'btn-outline-secondary','plan'=>'Starter','license'=>1,'price'=>9.5,'features'=>['1 store licence','Any 5 Sales Add-Ons','Private Facebook group access','Full support','Bronze Product Vault (name, image)','1-click Integrations']],
    ['cta'=>'X','btn'=>'btn-primary','plan'=>'Master','license'=>3,'price'=>48.5,'features'=>['3 store licence','Any 30 Sales Add-Ons','VIP Facebook mentoring group','Priority full support (skip the queue)','Gold Product Vault (name, image, audience, interests, description & more)','Access to tested Marketing Strategies courses','Chance for 1-on-1mentoring call every week']],
    ['cta'=>'X','btn'=>'btn-secondary','plan'=>'Hustler','license'=>1,'price'=>23.5,'features'=>['1 store licence','All '.$nbAddons.'+ Sales Add-Ons','Private Facebook group access','Full support (live support, email &Facebook chat)','Silver Product Vault (name, image, audience, interests &more)','1-click Integrations']],
    ] as $item)
    
    <div class='col-md-6 col-lg-3 mb-4'>
        <div class='card h-100 shadow-sm {{$item['plan'] == 'Master'?'scale-price':''}}'>
            <div class='card-body p-3 rounded text-center {{$item['plan'] == 'Master'?'bg-primary':''}}'>
                
                <div class='{{$item['plan'] == 'Master'?'text-white':''}}'>
                    <p class='text-secondary font-weight-bolder {{$item['plan'] == 'Master'?'':'invisible'}}'>
                        Best Value For Money!
                    </p>
                    <h3 class='font-weight-bold mt-3 {{$item['plan'] == 'Master'?'text-white':''}}'>
                        {{$item['plan']}}
                    </h3>
                    <p class='mb-4'>Get started with Debutify</p>
                </div>
                
                <div class='bg-white rounded p-3'>
                    
                    <div class='{{$item['plan']=='Master'?'text-black font-weight-bolder':''}}'>
                        <span class='position-relative' style="top:-20px">$</span>
                        <span class="display-4 {{strtolower($item['plan'])}}-price {{$item['plan']=='Master'?'font-weight-bolder':'font-weight-normal'}}">
                            {{$item['price']}} 
                        </span>
                        <span>/mo</span>
                    </div>
                    
                    <small class='billed-text text-center'>Billed Yearly</small>
                    
                    <div class='mt-3 mb-2'>
                        <span class='text-yellow'>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                        </span>
                         <span class='text-black'>
                            4.8/5.0
                        </span> 
                    </div>
                    
                    <p class='text-mid-light'><span class='debutify-reviews'></span>+ Review</p>
                    
                    <x-landing.download-btn  cta="$item['cta']" :class="$item['btn'].' debutify-hover btn btn-sm btn-block mt-3'"/>
                    
                    @if ($item['plan']=='Master')
                    <div class='small mt-3'>Everything in Hustler, plus:</div> 
                    @endif
                    
                    <div class='pt-3'>                        
                        @foreach ($item['features'] as $feature)
                        <div class='d-flex text-left mb-2'>
                            <i class='fas fa-check mr-2 mt-1 {{$item['plan']!='Master'?'text-primary':''}}'></i>
                            <div>{{$feature}}</div>
                        </div>
                        @endforeach
                    </div> 
                    
                </div>
                
            </div>
        </div>
    </div>
    
    @endforeach
</div>
