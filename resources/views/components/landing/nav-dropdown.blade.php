
<li class="nav-item dropdown">
    <a class="nav-link d-flex justify-content-between align-items-center" href="#" id="navbarDropdown{{$id}}" data-toggle="dropdown">
        <div class='mr-1'>{{$label}}</div> <img class="d-inline-block"  alt="icon Drop-down" src="/images/landing/icons/icon-dropdown.svg" width="16" height="16" />
    </a>
    <div class="dropdown-menu debutify-dropdown-menu dropdown-menu-center shadow" >
        <div class='row no-gutters'>
            @foreach ($links as $item)
            <div class='col-12 col-lg-6 position-relative'>
                <a class="dropdown-item" href="{{$item['link']}}" target='{{$item['target']??''}}'>
                    <div class='d-flex align-items-center py-1'>
                        <img data-src="/images/landing/icon-{{$item['icon']}}.svg" class='lazyload mr-2'  width="42" height="42" alt="">
                        <div>
                            <span class='font-weight-bold'>{{$item['label']}}</span> <br>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</li>
