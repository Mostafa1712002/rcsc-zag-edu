<div
    class="table-responsive"

>
    <ul class="navbar-menu" style='display:flex;padding:0px;'>
        @foreach ($departments as $department_id=>$department_title)
            <li
                style='
                    border: 0.5px solid rgb(238, 235, 235);
                    border-radius:5px;
                    padding:5px;
                    font-weight:normal;
                    margin:1px;'
                >
                <a
                    title='{{$department_title}}'
                    href="{{route('show_department',$department_id)}}"
                    style='font-size:13px;font-weight:normal; @if($department_id==$current_department_id) color:rgb(187,32,37); @endif white-space:nowrap !important'>

                {{ mb_strlen($department_title)>25? mb_substr($department_title,0,25).'...' : $department_title}}
                </a>
            </li>
        @endforeach
    </ul>
</div>
