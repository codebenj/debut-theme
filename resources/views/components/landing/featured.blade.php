
<h3 class='text-center mb-5 font-weight-light'>  As Featured On </h3>
<div id="debutify-feature" class='mb-4' style="display: none">
    @foreach ([
    ['image'=>'udroppy','link'=>'https://www.udroppy.com/'],
    ['image'=>'smsbump','link'=>'https://smsbump.com/'],
    ['image'=>'techmoney','link'=>'https://www.techmoneytalks.com/'],
    ['image'=>'cjdropshipping','link'=>'https://cjdropshipping.com/'],
    ['image'=>'ecomhunt','link'=>'https://ecomhunt.com/'],
    ['image'=>'ecomking','link'=>'https://www.youtube.com/channel/UCn8V4itSjrJBax-xLNJxeOQ'],
    ['image'=>'salesource','link'=>'https://salesource.com/'],
    ['image'=>'dropshippingcouncil','link'=>'https://www.thedropshippingcouncil.com/'],
    ['image'=>'flippa','link'=>'https://www.thedropshippingcouncil.com/'],
    ['image'=>'aftership','link'=>'https://www.thedropshippingcouncil.com/'],
    ['image'=>'omnisend','link'=>'https://www.thedropshippingcouncil.com/'],
    ['image'=>'ecomkingz','link'=>'https://vault.ecomkingz.com/'],
    ['image'=>'wiio','link'=>'https://www.wiio.io/'],
    ['image'=>'viralvault','link'=>'https://www.tryviralvault.com/unlock'],
    ] as $item)

    <div class='mx-2'>
        <div class='pt-3'>
            <img class='w-100 rounded lazyload' data-src="/images/landing/webinar-{{$item['image']}}.png" alt="{{$item['image']}}">
        </div>
    </div>
    @endforeach
</div>
