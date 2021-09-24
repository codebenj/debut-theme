
<div class='row justify-content-center'>
    @foreach ([
    ['name'=>'Chris Wane','image'=>'chris-wane','link'=>'','title'=>'7-figure Dropshipping entrepreneur & <br> YouTube Content Creator','saying'=>'From spending $180/mo. on my store to run itself, down to practically nothing with Debutify', 'player'=>'youtube'],
    ['name'=>'Kamil Sattar','image'=>'kamil-sattar','link'=>'ddp06vz1by','title'=>'7-figure e-commerce entrepreneur & <br> YouTube Content Creator','saying'=>"The conversion rates are amazing, the Add-Ons are amazing... it's changed my life and my store", 'player'=>'wistia'],
    ['name'=>'James Beattie','image'=>'james-beattie','link'=>'q4axn6p5ts','title'=>'ceo, ecom insiders; 7-figure entrepreneur & <br> YouTube Content Creator','saying'=>'From 2-3% conversion rate to 5% on a new branded Shopify store with optimizations in the theme', 'player'=>'wistia'],
    ['name'=>'Jordan Welch','image'=>'jordan-welch','link'=>'o9giis8s90','title'=>'serial entrepreneur, digital marketer & <br> 7-Figure store owner','saying'=>'The highest conversion rates… the highest page speeds… Debutify ranks among the top ones', 'player'=>'wistia'],
    ['name'=>'Marc Chapon','image'=>'marc-chapon','link'=>'5elz3nbyg7','title'=>'7-figure e-commerce entrepreneur & <br> YouTube Content Creator','saying'=>'Everything you need to test & scale your store efficiently. The best free theme out there by far', 'player'=>'wistia'],
    ['name'=>'Brandon Nguyen','image'=>'brandon-nguyen','link'=>'re8z3yppjo','title'=>'7-figure professional dropshipper <br><br>','saying'=>'Generated over $210k in the first month… High-converting, super easy, super customizable', 'player'=>'wistia'],
    ['name'=>'Cameron','image'=>'cameron','link'=>'qplctvv6am','title'=>'7-figure e-commerce entrepreneur <br><br>','saying'=>'Absolutely ridiculous results and literally took 30 minutes to set up. Improved my conversions by 2%', 'player'=>'wistia'],           
    ['name'=>'Clayton Bates','image'=>'clayton-bates','link'=>'c3c99tq5bb','title'=>'7-figure professional dropshipper & e-commerce entrepreneur','saying'=>'After downloading Debutify, a lot of these businesses went from 1-2% to 3, 4, 5% conversion rate', 'player'=>'wistia'],
    ['name'=>'Nick','image'=>'nick','link'=>'xt9d3748jm','title'=>'e-commerce <br><br>','saying'=>'Significantly helped with conversions… Perfect for building a branded e-commerce business', 'player'=>'wistia'],
    ['name'=>'Travis Lee','image'=>'','link'=>'whaoqnphxw','title'=>'Entrepreneur','saying'=>'The theme itself is very clean.. Very clear.. Easy to navigate.. I\'ll never use another theme.', 'player'=>'wistia'],
    ['name'=>'Ricky Hayes','image'=>'','link'=>'udc3l8p7kk','title'=>'8 Figure E-commerce Entrepreneur','saying'=>'From 2% to 3% conversion rate.. the best shopify theme... fast, easy and designed to get you more sales', 'player'=>'wistia'],
    ['name'=>'Zachary Oldham','image'=>'','link'=>'putxw8c540','title'=>'Founder, Digital Marketer','saying'=>'Its clean and sleek professional look helps build trust with customers.. worth trying out', 'player'=>'wistia'],
    ['name'=>'Michael Aririguzo','image'=>'','link'=>'l0puiullal','title'=>'Entrepreneur','saying'=>'Generated over $50,000 in revenue
    the first week...', 'player'=>'wistia'],
    ] as $key => $item)

    @if (empty($dropshipper??[]) || in_array($item['image'],$dropshipper??[]))


    <div class='debutify-dropshippers col-12 col-sm-12 col-md-6 col-lg-4 mb-4 {{ $key>2 && $key<=12?'d-md-block':''}}' style="{{empty($dropshipper??[]) && $key>2?'display:none':''}}">
        <div class='card shadow text-center h-100 overflow-hidden' >
            
            <div class='bg-primary'>
            @if($item['player'] == 'youtube')
                <x-landing.video-player :link="$item['link']" imageClass='rounded-top' :image="'/images/landing/dropship-'.$item['image'].'.png'" type='inline'/>
            @else
                <x-landing.wistia-video-player type='inline' :embedId="$item['link']"/>
            @endif
        </div>
            <div class='card-body pb-0'>
                <p class='text-black'> "{{$item['saying']}}" </p>
            </div>
            
            <div class='card-footer border-top'>
                <p class='m-0 font-weight-bolder'>{{$item['name']}}</p>
                <p class='m-0'><small> {!!$item['title']!!} </small> </p>
                @if ($logo??false == true)
                <img class='lazyload' data-src="/images/landing/dropshipper-logo-{{$item['image']}}.png" alt="">
                @endif
            </div>
        </div>
    </div>

    @endif
    
    @endforeach

</div>


@if (empty($dropshipper??[]))
<button type="button" class='view-more btn-sm-block mt-5 d-sm-block d-md-none btn btn-lg btn-secondary my-4 debutify-hover'  onclick="$('.debutify-dropshippers').fadeIn('slow');$(this).hide()">
    View More
</button>
@endif