<div class="table-responsive">
    <ul class="navbar-menu" style='display:flex;padding:0px;'>
        @foreach ($categories as $category_id=>$category_title)
            <li
                style='
                    border: 0.5px solid rgb(238, 235, 235);
                    border-radius:5px;
                    padding:5px;
                    margin:1px;'
            >
                <a
                    href="{{route('show_category',$category_id)}}"
                    style='
                        font-size:13px;
                        font-weight:normal;
                        @if($category_id==$current_category_id) color:rgb(187,32,37); @endif white-space:nowrap !important'>
                    {{$category_title}}
                </a>
            </li>
        @endforeach
    </ul>
</div>
