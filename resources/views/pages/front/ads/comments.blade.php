@foreach($comments as $comment)
    <x-comment :comment="$comment" :ad_customer_id="$ad->customer_id"/>
@endforeach
