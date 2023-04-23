<div>
    @foreach($recent_ads as $ad)
        <x-aside-ad-list-item :ad="$ad"/>
    @endforeach
</div>
