<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




// Route pour la page de connexion
Route::get('/login', [App\Http\Controllers\AuthenticatedSessionController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('throttle');

// Route pour la soumission du formulaire de connexion
Route::post('/login', [App\Http\Controllers\AuthenticatedSessionController::class, 'login']);

// Route pour la déconnexion
Route::post('/logout', [App\Http\Controllers\AuthenticatedSessionController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::view('/admin', 'admin.home')->name('admin.home');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [App\Http\Controllers\AuthenticatedSessionController::class, 'logout'])->name('logout');
    Route::get('/profil', [App\Http\Controllers\UserController::class, 'profil'])->name('profil');
    Route::get('/changepassword', [App\Http\Controllers\UserController::class, 'showChangePasswordForm'])->name('user.changePassword');
    Route::post('/changepassword', [App\Http\Controllers\UserController::class, 'changePassword']);
    Route::get('/etudiant/planning/{week?}', [App\Http\Controllers\SessionController::class, 'studentPlanning'])->name('sessions.student_planning');
    Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
});



Route::get('/register', [App\Http\Controllers\RegisterController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register']);


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.users.index');
    Route::resource('formations', App\Http\Controllers\FormationController::class);
    Route::resource('admin/formations', App\Http\Controllers\FormationController::class)->except(['show']);
    Route::get('admin/formations/create', [App\Http\Controllers\FormationController::class, 'create'])->name('admin.formations.create');
    Route::post('admin/formations', [App\Http\Controllers\FormationController::class, 'store'])->name('admin.formations.store');
    Route::get('admin/formations', [App\Http\Controllers\FormationController::class, 'index'])->name('admin.formations.index');
    Route::get('/admin/formations/{formation}/edit', [App\Http\Controllers\FormationController::class, 'edit'])->name('admin.formations.edit');
    Route::delete('/admin/formations/{formation}', [App\Http\Controllers\FormationController::class, 'destroy'])->name('admin.formations.destroy');
    Route::put('/admin/formations/{formation}', [App\Http\Controllers\FormationController::class, 'update'])->name('admin.formations.update');
    Route::post('/admin/users/{user}/approve', 'App\Http\Controllers\AdminController@approveUser')->name('admin.users.approve');
    Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/admin/users/{user}/refuse', [App\Http\Controllers\AdminController::class, 'refuseUser'])->name('admin.users.refuse');
    Route::get('/cours', [App\Http\Controllers\CourseController::class, 'index'])->name('cours.index');
    Route::get('/cours/create', [App\Http\Controllers\CourseController::class, 'create'])->name('cours.create');
    Route::post('/cours', [App\Http\Controllers\CourseController::class, 'store'])->name('cours.store');
    Route::get('/cours/{id}/edit', [App\Http\Controllers\CourseController::class, 'edit'])->name('cours.edit');
    Route::put('/cours/{id}', [App\Http\Controllers\CourseController::class, 'update'])->name('cours.update');
    Route::delete('/cours/{id}', [App\Http\Controllers\CourseController::class, 'destroy'])->name('cours.destroy');
    Route::put('/cours/{id}', [App\Http\Controllers\CourseController::class, 'update'])->name('cours.update');
    Route::get('/admin/users/{user}/changepassword', [App\Http\Controllers\AdminController::class, 'showChangePasswordUserForm'])->name('admin.users.changePasswordForm');
    Route::post('/admin/users/{user}/changepassword', [App\Http\Controllers\AdminController::class, 'changePasswordUser'])->name('admin.users.changepassword');
    Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'showCreateUserForm'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{user}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::put('/admin/users/{user}/type', [App\Http\Controllers\AdminController::class, 'updateType'])->name('admin.users.update.type');



});

Route::middleware(['auth', 'is_admin_ou_enseignant'])->group(function () {
    Route::get('/sessions/{session}/edit', [App\Http\Controllers\SessionController::class, 'edit'])->name('sessions.edit');
    Route::put('/sessions/{session}', [App\Http\Controllers\SessionController::class, 'update'])->name('sessions.update');
    Route::delete('/sessions/{session}', [App\Http\Controllers\SessionController::class, 'destroy'])->name('sessions.destroy');
    Route::get('/sessions', [App\Http\Controllers\SessionController::class, 'index'])->name('sessions.index');
    Route::get('/sessions/create', [App\Http\Controllers\SessionController::class, 'create'])->name('sessions.create');
    Route::post('/sessions', [App\Http\Controllers\SessionController::class, 'store'])->name('sessions.store');
    Route::delete('/sessions/{session}', [App\Http\Controllers\SessionController::class, 'destroy'])->name('sessions.destroy');
    Route::get('/cours/{id}', [App\Http\Controllers\CourseController::class, 'show'])->name('cours.show');
    Route::get('/sessions', [App\Http\Controllers\SessionController::class, 'index'])->name('sessions.index');

});

Route::get('/', function () {
    return view('main');
})->middleware('ensureUserIsActive')->name('main');




Route::get('/student/courses', [App\Http\Controllers\CourseController::class, 'studentCourses'])->name('student.courses');
Route::post('/student/courses/{id}/enroll', [App\Http\Controllers\CourseController::class, 'enroll'])->name('student.enroll');
Route::post('/student/courses/{id}/unenroll', [App\Http\Controllers\CourseController::class, 'unenroll'])->name('student.unenroll');
Route::get('/student/my-courses', [App\Http\Controllers\CourseController::class, 'myCourses'])->name('student.mycourses');



Route::get('/sessions', [App\Http\Controllers\SessionController::class, 'index'])->name('sessions.index');
Route::get('/student-sessions', 'App\Http\Controllers\SessionController@studentPlanning')->name('sessions.student_sessions');
Route::get('/student-sessions-table', 'App\Http\Controllers\SessionController@studentPlanningTable')->name('sessions.student_sessionsTable');