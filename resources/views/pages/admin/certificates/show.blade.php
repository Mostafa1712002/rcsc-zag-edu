<html>
    <head>
        <title>{{$student->full_name}}</title>
    </head>
    <body style='padding:1.5cm;margin:0px;height:100%;page-break-after: auto;text-align:center;font-weight:bold'>
		<div style='height:8cm'></div>
        <h1>{{$student->full_name}}</h1>

        <div style='height:2cm'></div>

        <h2 style='color:RGB(139,88,77);'>@lang('certificates.has_successfully_passed') {{$course->title_en}}</h2>
        <div style='height:1cm'></div>

        <h3 style='color:RGB(106,98,122)'>{{$course->description_en}}, @lang('certificates.as_it_was_issued_on') {{date('F d, Y',strtotime($student->exam_at)) }}</h3>
        <div style='height:1cm'></div>

        <h4 style='text-align:right;'>
            @lang('certificates.with')
            ( <span style="color:red">{{strtoupper(__('grades.'.$student->exam_grade)) }}</span> )
            @lang('certificates.grade')
        </h4>

    </body>
</html>
