<?php
use App\Models\product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SendEmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//public Routes
Route::post('/register11',[AuthController::class,'register']);
Route::post('/login11',[AuthController::class,'login']);

Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

//Route::post('/registercompany', [CompanyController::class, 'registercompany']);
//Route::post('/registerdriver', [DriverController::class, 'registerdriver']);
//Route::post('/registervehicle', [VehicleController::class, 'registervehicle']);
Route::get('send-email', [SendEmailController::class, 'index']);


Route::get('/products/{id}',[ProductController::class,'show']);
Route::get('/products/search/{name}',[ProductController::class,'search']);

//Route::get('/registercompany',[CompanyController::class,'index']);
//Route::get('/registercompany/{id}',[CompanyController::class,'show']);
//Route::get('/registercompany/search/{name}',[CompanyController::class,'search']);
//
//Route::post('/products',[ProductController::class,'store']);
//Route::resource('products',ProductController::class);
//Route::get('products/search/{name}',[ProductController::class,'search']);
Route::group(['middleware'=>['auth:sanctum']], function () {
//    Route::post('/registercompany',[CompanyController::class,'store']);
//    Route::put('/registercompany/{id}',[CompanyController::class,'update']);
//    Route::delete('/registercompany',[CompanyController::class,'destroy']);
    Route::get('/products',[ProductController::class,'index'])->middleware('CheckCompanyUser');
    Route::post('/products',[ProductController::class,'store'])->middleware('CheckCompanyUser');
    Route::put('/products{id}',[ProductController::class,'update']);
    Route::delete('/products/{id}',[ProductController::class,'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
