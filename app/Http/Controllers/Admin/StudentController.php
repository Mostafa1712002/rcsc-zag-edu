<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\UpdateExamDegreeRequest;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    protected $model, $views_path, $redirect;
    public function __construct(Student $model)
    {
        $this->model = $model;
        $this->redirect = redirect()->route('admin.student.index');
        $this->views_path = 'pages.admin.students';
    }

    public function index()
    {
        $data = [
            'records' => $this->model->orderBy('id', 'desc')->paginate(),
            'page_title' => __('site.students'),
        ];
        return view($this->views_path . '.index', $data);
    }

    public function importStudent(ImportRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $file = $data['file'];
                $ext = $file->getClientOriginalExtension();
                $current_seconds =
                \Carbon\Carbon::now()->format('Y-m-d-H-i-s');
                $file->move(public_path('storage/uploads'), "$current_seconds.$ext");
                $path = public_path('storage/uploads/' . $current_seconds . '.' . $ext);
                $columns = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\GeneralImport(), $path);

                foreach ($columns as $column) {
                    $i = 0;
                    foreach ($column as $row) {
                        // $courses_id = $row[2];
                        // $courses_id = explode(',', $courses_id);
                        // $courses_id = array_map('trim', $courses_id);
                        // $courses_id = array_map('intval', $courses_id);
                        // $courses_id = array_filter($courses_id);
                        // $courses_id = array_unique($courses_id);
                        // $data = [];
                        // foreach ($courses_id as $course_id) {
                        //     $course = \App\Models\Course::find($course_id);
                        //     if (!$course) {
                        //         return $this->redirect->with('error', __('site.review your excl sheet'));
                        //     }
                        //     array_push($data, "$course_id");
                        // }
                        // $row[2] = $data;
                        $student = $this->model->where('national_id', $row[1])->first();
                        if (!$student) {
                            $new_student = $this->model->create([
                                'full_name' => $row[0],
                                'national_id' => $row[1],
                                'course_ids' => null,
                                'password' => \Illuminate\Support\Facades\Hash::make($row[1]),
                                "status" => "active",
                            ]);
                            $new_student->update([
                                "status" => "active",
                            ]);
                        }

                    }
                }
                return $this->redirect->with('success', __('site.imported_successfully'));
            });

        } catch (\Exception$e) {
            return $this->redirect->with('error', __('site.review your excl sheet'));
        }

    }

    public function show(Student $student)
    {
        $data = [
            'record' => $student,
            'page_title' => $student->full_name,
            'not_deleted_student_ads_count' => $student->ads()->count(),
            'deleted_student_ads_count' => $student->trashedAds()->count(),
        ];
        return view('pages.admin.students.show', $data);
    }

    public function edit($id)
    {
        $record = $this->model->find($id);
        $data = [
            'record' => $record,
            'page_title' => __('site.edit') . ' ' . $record->full_name,
        ];
        return view($this->views_path . '.exam-edit', $data);

    }

    public function update(UpdateExamDegreeRequest $request, $id)
    {
        $record = $this->model->find($id);
        $data = $request->validated();
        $record->update($data);
        return $this->redirect->with('success', __('site.updated_successfully'));
    }

}
