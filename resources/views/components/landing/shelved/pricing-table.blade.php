
{{-- Experimantal Table Template --}}
<div class='bg-white p-3 rounded my-5'>
<div class='table-responsive-xl rounded '>
<table class="table table-striped table-bordered text-center">
    <thead class='bg-primary text-white '>
        <tr>
            <th class='text-left lead align-middle' width='25%'>
               {{$label}}
            </th>
            @foreach ([
            ['label'=>'Free','price'=>'0','width'=>'15%','class'=>''],
            ['label'=>'Starter','price'=>'9.5','width'=>'15%','class'=>'starter-price'],
            ['label'=>'Master','price'=>'48.5','width'=>'15%','class'=>'master-price'],
            ['label'=>'Hustler','price'=>'23.5','width'=>'15%','class'=>'hustler-price'],
            ] as $item)
            <th>  
               <span class='font-weight-light lead' width='{{$item['width']}}'> {{$item['label']}} </span> <br>
                <small>$ <span class='{{$item['class']}}'>{{$item['price']}}</span>/mo</small>
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($body as $item)
        <tr>
            @foreach ($item as $v_index => $values)

                <td class="{{$v_index ==0?'text-left':''}}">
                    @if ($values == '1')
                    <i class='text-success fas fa-check'></i>
                    @elseif($values == '0')  
                    <i class='text-danger h4 fas fa-times'></i>
                    @else
                    {{$values}}
                    @endif
                </td>

            @endforeach        

        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td>  
            </td>
            <td>
                <x-landing.download-btn class='btn-sm btn-outline-secondary debutify-hover text-nowrap' :cta="$cta[0]"/>
            </td>
            <td>
                <x-landing.download-btn class='btn-sm btn-outline-secondary debutify-hover text-nowrap' :cta="$cta[1]"/>
            </td>
            <td>
                <x-landing.download-btn class='btn-sm btn-primary debutify-hover text-nowrap' :cta="$cta[2]"/>
            </td>
            <td>
                <x-landing.download-btn class='btn-sm btn-secondary debutify-hover text-nowrap' :cta="$cta[3]"/>
            </td>
        </tr>
    </tfoot>
</table>
</div>
</div>