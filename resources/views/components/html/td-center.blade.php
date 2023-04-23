<td class="text-center">
    <span title="{{$attributes['text']}}">
        {{strlen($attributes['text'])>35?\Str::substr($attributes['text'],0,35).' ...' : $attributes['text']}}
    </span>
</td>
