<div class="comment-card  p-3 mb-3 rounded bg-card-dark">
    <p class="float-start"><img src="{{asset('front/assets')}}/images/time-2.png" alt=""> {{$attributes['comment']->created_at->format('d/m/Y')}} </p>
    <div class="comment">
        <a href="{{route('show_customer',$attributes['comment']->customer_id)}}">
            <img src="{{$attributes['comment']->customer->avatar_url}}" alt="" class="float-end">
        </a>
        <div class="pe-5">
            <h3>
                <a href="{{route('show_customer',$attributes['comment']->customer->id)}}">
                    {{$attributes['comment']->customer->full_name}} #{{$attributes['comment']->id}}
                </a>
            </h3>
            <h4>
                @if($attributes['ad_customer_id'] != auth('customer')->id())
                    {{preg_replace('"05\d{8}$"',str_repeat('*',10),$attributes['comment']->content)}}
                @else
                    {{$attributes['comment']->content}}
                @endif
            </h4>
            @auth('customer')
                @if(auth('customer')->id() == $attributes['ad_customer_id'])

                    <div class="comment">
                        @livewire('comment-replies',['comment'=>$attributes['comment']->id,'ad_customer_id'=>$attributes['ad_customer_id']])
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
