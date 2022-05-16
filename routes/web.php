<?php


use App\Models\Department;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Symfony\Component\ErrorHandler\Debug;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\serviceController;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $users = DB::table('users')->get();
    return view('dashboard', compact('users'));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    //department
    Route::get('/department/all', [DepartmentController::class, 'index'])->name('department');
    Route::post('/department/add', [DepartmentController::class, 'store'])->name('addDepartment');
    Route::get('/department/edit/{id}', [DepartmentController::class, 'edit']);
    Route::post('/department/update/{id}', [DepartmentController::class, 'update']);
    //softDelete

    Route::get('/department/softdelete/{id}', [DepartmentController::class, 'softdelete']);
    Route::get('/department/restore/{id}', [DepartmentController::class, 'restore']);
    Route::get('/department/delete/{id}', [DepartmentController::class, 'delete']);
    //service

    Route::get('/service/all', [serviceController::class, 'index'])->name('services');
    Route::post('/service/add', [serviceController::class, 'store'])->name('addService');

    Route::get('/service/edit/{id}', [serviceController::class, 'edit']);
    Route::post('/service/update/{id}', [ServiceController::class, 'update']);
    Route::get('/service/delete/{id}', [ServiceController::class, 'delete']);
});
