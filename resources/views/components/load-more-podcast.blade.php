@if(isset($podcasts) && !empty($podcasts) && count($podcasts) != 0)
    @foreach($podcasts as $key => $podcast)
    <div class="col-sm-6 mb-4">
        <div class="card h-100 podcast-card shadow">
            <div class="card-body pb-0">

                <h4 class="card-title"><a class="font-weight-bold text-black" href="{{Route('podcast_slug', $podcast->slug)}}"> {{$podcast->title}}</a></h4>

                <iframe class="lazyload" sandbox="allow-same-origin allow-scripts allow-top-navigation allow-popups allow-forms" scrolling=no width="100%" height="185" frameborder="0" data-src="{{$podcast->podcast_widget }}"></iframe>

                <?php
                $description = html_entity_decode(htmlspecialchars_decode(strip_tags($podcast->description), ENT_QUOTES));
                if (strlen($description) > 250 && preg_match('/\s/', $description)) {
                    $pos = strpos($description, ' ', 250);
                    $podcast_description = substr($description, 0, $pos);?>
                    <p> {{$podcast_description}} <a href="{{Route('podcast_slug', $podcast->slug)}}">Read More...</a></p>
                    <?php } else {?>
                    <div> {!! $podcast->description !!}</div>
                <?php 
                }
                ?>

            </div>
            <div class="card-footer border-top">
                <ul class="list-inline list-unstyled mb-0 small">
                    @if(isset($podcast->transcript_time) && !empty($podcast->transcript_time))
                    <li class="list-inline-item">
                        <span class="fas fa-headphones" aria-hidden="true"></span>
                        {{ $podcast->transcript_time }} Listening Time
                    </li>
                    <li class="list-inline-item">|</li>
                    @endif

                    <li class="list-inline-item">
                        <span class="far fa-calendar-alt" aria-hidden="true"></span> 
                        {{ (!empty($podcast->podcast_publish_date) ? date('M d Y', strtotime($podcast->podcast_publish_date)) : date('M d Y', strtotime($podcast->created_at)) ) }}
                    </li>
                </ul>
            </div>
        </div> 
    </div>
    @endforeach
@endif