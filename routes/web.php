<?php
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

// THIS IS CRUD URLS ////
Route::group(['middleware'=>'auth','disable_back_btn'],function(){

Route::get('/employees', [EmployeeController::class,'index'])->name('employees.index');
});

Route::get('/employees/create', [EmployeeController::class,'create'])->name('employees.create');
Route::post('/employees', [EmployeeController::class,'store'])->name('employees.store');
Route::get('/employees/edit/{employee}', [EmployeeController::class,'edit'])->name('employees.edit');
Route::post('/employees/{employee}',[EmployeeController::class,'update'])->name('employees.update');
Route::delete('/employees/{employee}',[EmployeeController::class,'destroy'])->name('employees.destroy');

// THIS is custome login and signup //

// Route::get('/login', [CustomAuthController::class,'login']);
// Route::get('/registration',[CustomAuthController::class,'registration']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

