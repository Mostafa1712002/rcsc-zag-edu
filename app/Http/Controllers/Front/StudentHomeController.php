<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinishDataStudentRequest;
use Illuminate\Support\Str;

class StudentHomeController extends Controller
{
    public function __invoke()
    {
        return view('front.student-home');
    }

    public function examFinished()
    {

        return view('front.exam-finished');
    }

    public function finishData(FinishDataStudentRequest $request, $id)
    {

        $path = date('Y/m/d');
        $personal_pic = $request->personal_pic->storeAs($path, Str::random(75) . '_' . mt_getrandmax() . '.' . $request->personal_pic->extension(), 'public');
        $ack_video = $request->ack_video->storeAs($path, Str::random(75) . '_' . mt_getrandmax() . '.' . $request->ack_video->extension(), 'public');
        auth('student')->user()->update([
            'personal_pic' => $personal_pic,
            'ack_video' => $ack_video,
            "course_ids" => $request->course_ids,
        ]);

        return redirect()->back();
    }
}
