
<div class='bg-white p-3 rounded my-5'>
    <div class='table-responsive-xl rounded '>
        <table class="table table-striped table-bordered text-center">
            <thead class='bg-primary text-white'>
                <tr>
                    <th class='text-left lead align-middle font-weight-bolder' width='25%'> {{$label}} </th>
                    @foreach ([
                    ['label'=>'Free','price'=>'0','width'=>'15%','class'=>''],
                    ['label'=>'Starter','price'=>'9.5','width'=>'15%','class'=>'starter-price'],
                    ['label'=>'Hustler','price'=>'23.5','width'=>'15%','class'=>'hustler-price'],
                    ['label'=>'Master','price'=>'48.5','width'=>'15%','class'=>'master-price'],
                    ] as $item)
                    <th>  
                        <p class='font-weight-light lead mb-0' width='{{$item['width']}}'> {{$item['label']}} </p> 
                        <div class='small'>$ <span class='{{$item['class']}}'>{{$item['price']}}</span>/mo</div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{$slot}}
            </tbody>
            <tfoot>
                <tr>
                  <td> </td> 
                  
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