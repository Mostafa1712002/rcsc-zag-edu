<?php

use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Front\LoginStudentController;
use App\Http\Controllers\Front\RegisterStudentController;
use App\Http\Controllers\Front\StudentHomeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'logoutInactiveCustomer'],
    'prefix' => LaravelLocalization::setLocale(),
], function () {
    Route::get('/', RegisterStudentController::class)->name('home');
    Route::get('student/register', RegisterStudentController::class)->name('student.register');
    Route::get('student/login', LoginStudentController::class)->name('student.login');

    Route::group(['prefix' => 'student', 'middleware' => ['auth:student'], 'as' => 'student.'], function () {
        Route::get('home', StudentHomeController::class)->name('home');
        Route::get('exam-finished', [StudentHomeController::class, 'examFinished'])->name('exam_finished');
    });

    Route::get('logout', [LoginController::class, 'logout']);
    Auth::routes();

    // Auth::loginUsingId(2);

    Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'logoutInactiveAdmin'], 'as' => 'admin.'], function () {
        Route::get('/home', [AdminHomeController::class, 'index'])->name('home');
        Route::get('/getProfile', [AdminHomeController::class, 'getProfile'])->name('getProfile');

        Route::put('user/{user}/permissions', function (Request $request, User $user) {
            $permissions = $request->except(['_token', '_method', 'record_id']);
            $user->syncPermissions(array_keys($permissions));
            return back();
        })->name('save_permissions');

        Route::get('user/delete/{user}', [UserController::class, 'destroy'])->name('user.delete');
        Route::resource('user', UserController::class);

        Route::get('student', [StudentController::class, 'index'])->name('student.index');
        // edit student exam
        Route::get('student/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
        Route::put('student/{student}', [StudentController::class, 'update'])->name('student.update');
        
        Route::get('certificate/{student}', [CertificateController::class, 'show'])->name('certificate.show');
        Route::get('question', [QuestionController::class, 'index'])->name('question.index');
        Route::get('course', [CourseController::class, 'index'])->name('course.index');
        Route::get('answers/{question}', [QuestionController::class, 'answers'])->name('question.answers');

        Route::resource('page', PageController::class);

        Route::get('/profile', [AdminsController::class, 'getProfile'])->name('getProfile');
        Route::put('/setProfile', [AdminsController::class, 'setProfile'])->name('setProfile');

        // import student
        Route::post('import-student', [StudentController::class, 'importStudent'])->name('import_student');

    }); /*admin*/

}); /*authenticated users: admin, normal user*/
