<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Quiz_participants.quiz_finished');
});
Route::get('/clogin', function () {
    return view('auth.login');
})->middleware('guest')->name('clogin');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/clogout', [App\Http\Controllers\QuizMainController::class, 'clogout'])->name('clogout');
});

// Auth::routes();
// Authentication Routes...
Route::get('login', function () {
    return view('Quiz_participants.quiz_finished');
})->name('login');
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
// Registration Routes...
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset']);


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home', [App\Http\Controllers\QuizMainController::class, 'index'])->name('home');
Route::resource('/home', 'App\Http\Controllers\QuizMainController');

Route::delete('/quizdelete/{id}', [App\Http\Controllers\QuizMainController::class, 'quizdelete'])->name('quizdelete');

Route::get('/list/{id}', [App\Http\Controllers\QuizMainController::class, 'quiz_list'])->name('quiz_list');
Route::get('/result', [App\Http\Controllers\QuizMainController::class, 'result'])->name('result');
Route::get('/member_search', [App\Http\Controllers\QuizMainController::class, 'member_search'])->name('member_search');
Route::get('/generate/{slug}', [App\Http\Controllers\QuizMainController::class, 'generateLink'])->name('generateLink');

Route::resource('/quiz', 'App\Http\Controllers\QuizParticipantController');

Route::get('/participant_register/{slug}', [App\Http\Controllers\QuizParticipantController::class, 'participantRegisterView'])->name('p-register-v');
Route::post('/registration', [App\Http\Controllers\QuizParticipantController::class, 'participantRegister'])->name('p-register');
Route::get('/finish', [App\Http\Controllers\QuizParticipantController::class, 'finish'])->name('finish');
// test reset
Route::get('/reset/{participant_id}/{id}',  [App\Http\Controllers\QuizParticipantController::class, 'reset']);

Route::get('/test_start', [App\Http\Controllers\QuizParticipantController::class, 'test_start'])->name('test_start');
Route::get('/meeting/{id}', [App\Http\Controllers\QuizParticipantController::class, 'meeting'])->name('meeting');

Route::get('/participantLoginView/{slug}', [App\Http\Controllers\QuizParticipantController::class, 'participantLoginView'])->name('participantLoginView');
Route::post('/participantLogin', [App\Http\Controllers\QuizParticipantController::class, 'participantLogin'])->name('participantLogin');

Route::get('/participantList', [App\Http\Controllers\QuizMainController::class, 'participantList'])->name('participantList');

Route::get('/question_view/{id}', [App\Http\Controllers\QuizMainController::class, 'show'])->name('show');
Route::get('/question_edit/{id}', [App\Http\Controllers\QuizMainController::class, 'edit'])->name('edit');
Route::post('/audio_req', [App\Http\Controllers\QuizMainController::class, 'audio_req'])->name('audio_req');

//FORGET PASSWORD PARTITIONS
Route::get('/forget_password/{slug}', [App\Http\Controllers\QuizParticipantController::class, 'forget_password_view'])->name('forget_password');
Route::post('/send/otp', [App\Http\Controllers\QuizParticipantController::class, 'send_otp'])->name('send_otp');
Route::post('/forget_password', [App\Http\Controllers\QuizParticipantController::class, 'forget'])->name('participantForget');
Route::post('/forgets_password', [App\Http\Controllers\QuizParticipantController::class, 'getotp'])->name('getotp');

Route::get('/verify_otp', [App\Http\Controllers\QuizParticipantController::class, 'verify_otp_view'])->name('verify_otp_view');
Route::post('/otp/verification', [App\Http\Controllers\QuizParticipantController::class, 'otp_verify'])->name('otp_verification');

Route::get('/verified', [App\Http\Controllers\QuizParticipantController::class, 'verified_view'])->name('verified');
Route::post('/change_password', [App\Http\Controllers\QuizParticipantController::class, 'change_password'])->name('change_password');

Route::get('/test_video/{id}', [App\Http\Controllers\QuizParticipantController::class, 'test_video'])->name('test_video');

Route::get('/view_online/{slug}', [App\Http\Controllers\QuizParticipantController::class, 'view_online'])->name('view_online');
Route::get('/finished', [App\Http\Controllers\QuizParticipantController::class, 'finished'])->name('finished');

// Add link Popup submit
Route::post('/custom_link', [App\Http\Controllers\QuizMainController::class, 'custom_link'])->name('custom_link');

// Add Link Form submit
Route::post('/add_link', [App\Http\Controllers\QuizMainController::class, 'add_link'])->name('add_link');

// Fill Dropdown Values in Add link Page
Route::get('/get_category', [App\Http\Controllers\QuizMainController::class, 'get_category'])->name('get_category');
Route::get('/get_sub_category', [App\Http\Controllers\QuizMainController::class, 'get_sub_category'])->name('get_sub_category');
Route::get('/get_level', [App\Http\Controllers\QuizMainController::class, 'get_level'])->name('get_level');
Route::get('/no_questions', [App\Http\Controllers\QuizMainController::class, 'no_questions'])->name('no_questions');

Route::get('/test_request', [App\Http\Controllers\QuizMainController::class, 'test_request'])->name('test_request');
Route::post('/submit_reply', [App\Http\Controllers\QuizMainController::class, 'submit_reply'])->name('submit_reply');


Route::get('/fetch_data', [App\Http\Controllers\QuizMainController::class, 'fetch_data'])->name('fetch_data');
Route::get('/get_report', [App\Http\Controllers\QuizMainController::class, 'get_report'])->name('get_report');

// Category Page Filter
Route::get('/category_filter', [App\Http\Controllers\CategoryController::class, 'category_filter'])->name('category_filter');

Route::get('/check-finished', function () {
    return response()->json(['finished' => session()->get('finished')]);
});

Route::get('/check-started', function () {
    return response()->json(['started' => session()->get('started')]);
});

Route::get('/search_title', [App\Http\Controllers\QuizMainController::class, 'search_title'])->name('search_title');

Route::post('get_level_list', [App\Http\Controllers\QuizMainController::class, 'get_level_list'])->name('get_level_list');

Route::get('/view_report/{id}', [App\Http\Controllers\QuizMainController::class, 'view_report'])->name('view_report');

Route::get('/report_download/{id}', [App\Http\Controllers\QuizMainController::class, 'report_download'])->name('report_download');

// Route::get('/pdf/{id}',function($id){
//     return view('Quiz_participants.pdf',compact('id'));
// })->name('pdf_download');

Route::get('/forceDonwload/{id}', [App\Http\Controllers\QuizMainController::class, 'forceDonwload'])->name('forceDonwload');
Route::resource('user', 'App\Http\Controllers\UserController');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/import', [App\Http\Controllers\QuizMainController::class, 'import_view'])->name('import');
    Route::resource('department', 'App\Http\Controllers\DepartmentController');
    Route::resource('category', 'App\Http\Controllers\CategoryController');
    Route::resource('subadmin', 'App\Http\Controllers\SubadminController');
 	Route::resource('subadminnew', 'App\Http\Controllers\SubadminnewController');
    Route::get('/register_subadmin', [App\Http\Controllers\SubadminController::class, 'regformapi'])->name('regformapi');
	Route::get('/register_subadmins', [App\Http\Controllers\SubadminnewController::class, 'regformapis'])->name('regformapis');
    Route::post('/sendpassword', [App\Http\Controllers\SubadminController::class, 'sendpassword'])->name('sendpassword');
    Route::get('/archive_question/{dummy}/{id}', [App\Http\Controllers\QuizMainController::class, 'archive_question'])->name('archive_question');


});
Route::post('/groupmail', [App\Http\Controllers\QuizMainController::class, 'groupmail'])->name('groupmail');
