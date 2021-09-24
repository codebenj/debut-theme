<div class='row text-center'>
    @foreach ([
    ['image'=>'oriented','title'=>'Growth-Oriented','description'=>'Always challenging ourselves'],
    ['image'=>'dependable','title'=>'Dependable','description'=>'We get the job done right'],
    ['image'=>'mindset','title'=>'Ownership Mindset','description'=>'Going above and beyond'],
    ['image'=>'everyone','title'=>'Respect for Everyone','description'=>'Colleagues, clients, and partners'],
    ] as $item)
    <div class='col-sm-6 col-lg-3 '>
      <div class="responsive-container-1by1">
        <img class='lazyload w-100' data-src="images/landing/about-{{$item['image']}}.svg?v={{config('image_version.version')}}" alt="">
      </div>
        <h4 class='my-3'>{{$item['title']}}</h4>
        <p class='lead'>
            {{$item['description']}}
        </p>

    </div>
    @endforeach
</div>
