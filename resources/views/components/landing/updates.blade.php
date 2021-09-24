<div class='row text-center text-lg-left '>
    @foreach ([
    ['icon'=>'training2','title'=>'New High-Level Marketing Training','description'=>'Platforms and tactics may change over time. But marketing principles stay forever. We’re rolling out new masterclass content to give you both timeless strategies and the latest tactics that work today.'],
    ['icon'=>'optimization2','title'=>'Non-Stop UX Optimizations','description'=>'Optimization is not a “one and done” thing. We’re constantly updating our design based on the latest data gathered by our in-house experts to give you (and your customers) seamless user experience.'],
    ['icon'=>'speed2','title'=>'Even Faster Page <br/> Load Speed','description'=>'Success loves speed they say. Well, so do conversions. It’s why we’re always on top of this one. Month after month, we’re looking for more ways to quicken our code to give your visitors an even smoother experience.'],
    ['icon'=>'templates2','title'=>'Done For You <br/>Niche Templates','description'=>"If you fancy ready-made templates for specific niches, this one's for you. Choose out of different done-for-you templates you could either plug and play… or customize to fit  your brand. Now you won’t have to hire expensive CRO freelancers. Just let our in-house experts do the work for you."],
    ['icon'=>'one2','title'=>'One App To <br/> Rule Them All','description'=>'Debutify will be the central app to manage all other apps within our umbrella. No more wasting time comparing third-party apps — because we’re bringing them all native for you.'],
    ['icon'=>'tracking2','title'=>'Site Tracking','description'=>'See what actual visitors do when they visit your site. Find out which sections attract their attention the most so you can place your high-margin, best-selling offers right in front of their eyes.'],
    ['icon'=>'analytics2','title'=>'Marketing <br/> Analytics','description'=>'This will give you powerful (and profitable) insights into what your customers desire the most… so you can bridge the gap and show them a way to get it! No more “hit or miss” marketing because now you’ll have valuable data as your foundation.'],
    ['icon'=>'support2','title'=>'Multi-Channel Support','description'=>'24/7 support, whenever you want… wherever you want it. Get world-class help from different platforms. Choose whatever works best for you.'],
    ['icon'=>'mouth2','title'=>'Word of Mouth Advertising','description'=>'Take full advantage of one of the most effective marketing strategies you can have for your brand. Turn regular buyers into raving fans who promote your products for you.'],
    ] as $key => $item)
    <div class='col-md-6 updates-features col-lg-4 mb-4 d-md-block debutify-animation-wrapper' data-animation-target='icon-updates-{{$item['icon']}}' style="{{$key>3 ?'display:none':''}}">

      <object class="lazyload pointer-none" width="50" height="50" type="image/svg+xml" id='icon-updates-{{$item['icon']}}' data-object="/images/landing/icon-{{$item['icon']}}-infinite-animated.svg">
      </object>
      
        <h3 class='my-4'style="min-height:84px;">{!!$item['title']!!}</h3>
        <p> {{$item['description']}} </p>
    </div>
    @endforeach
</div>

<button class='btn-block btn-sm-block d-md-none btn btn-light debutify-hover' onclick="$('.updates-features').fadeIn('slow');$(this).hide();">View All</button>
