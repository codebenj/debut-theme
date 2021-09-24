<div class='{{$class??''}}'>
    @if ($type=='masonry')
        <div class='debutify-masonry' data-rw-masonry="22397"></div>
    @elseif($type=='badge')

    <div class='row justify-content-center text-center debutify-badge no-gutters'>
            @foreach (
                [
                    ['name'=>'facebook','id'=>'22006'],
                    ['name'=>'capterra','id'=>'22008'],
                    ['name'=>'google','id'=>'22009'],
                    ['name'=>'trustpilot','id'=>'22007'],
                    ['name'=>'g2','id'=>'22010'],
                ] as $index => $item)

            @if (empty($badges??[]) || in_array($item['name'],$badges??[]))
                <div class='{{$row??''}} mb-4'>
                    <div class='w-100 shadow-sm' data-rw-badge1="{{$item['id']}}"></div>
                </div>
            @endif

        @endforeach
    </div>
    @endif
</div>
