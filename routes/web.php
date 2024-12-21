<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;

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



Auth::routes();
//Auth::routes(['verify'=> true]);

//user routes
Route::get('/', function () {
    return view('auth/login');
});
Route::post('/login_process',[LoginController::class, 'login_process'])->name('login_process')->middleware(['guest']);
Route::get('/logout',[LoginController::class, 'logout'])->name('logout');

//Forgot Password Routes && Reset password
Route::get('/password/reset',[ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');

Route::post('/password/reset',[ForgotPasswordController::class,'submitLinkRequestForm'])->name('password.send');
Route::get('/password/change/{token}',[ForgotPasswordController::class,'changePassword'])->name('change.password');
Route::post('/password/change/{token}',[ForgotPasswordController::class,'submitChangePassword'])->name('submit.password.change');
//Reset Password Routes
Route::get('/password/reset/{token}',[ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

//Email Verification Routes
//Route::get('/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
//updated email verification routes
Route::get('/verify', [VerificationController::class, 'verify']);
Route::post('/verify/resend',[VerificationController::class,'resendLink'])->name('verify.resend');


Route::middleware(['auth'])->name('user.')->group(function (){
    Route::get('/user/dashboard',[UsersController::class, 'dashboard'])->name('dashboard');
    Route::get('/user/profile',[UsersController::class, 'profile'])->name('profile');
    Route::get('/user/manageadmins',[UsersController::class, 'manageadmins'])->name('manageadmins');    
    Route::get('/user/admin',[UsersController::class, 'admin'])->name('admin');      
    Route::get('/user/admin/{id}',[UsersController::class, 'admin'])->name('admin');   
    Route::get('/user/deactivateprofile/{id}',[UsersController::class, 'deactivateprofile'])->name('deactivateprofile'); 
    Route::get('/user/activateprofile/{id}',[UsersController::class, 'activateprofile'])->name('activateprofile');    
    Route::get('/user/deleteprofile/{id}',[UsersController::class, 'deleteprofile'])->name('deleteprofile');   
    Route::post('/createadmin',[UsersController::class, 'create'])->name('create'); 
    Route::post('/updateadmin',[UsersController::class, 'update'])->name('update'); 

    //Property routes
    Route::get('/user/manageproperty',[UsersController::class, 'manageproperty'])->name('manageproperty'); 
    Route::get('/user/propertyflats/{id}',[UsersController::class, 'propertyflats'])->name('propertyflats');     
    Route::get('getflats/{id}',[UsersController::class, 'getflats'])->name('getflats');    
    Route::get('getflatfees/{pid}/{id}',[UsersController::class, 'getflatfees'])->name('getflatfees');    
    Route::get('/user/property',[UsersController::class, 'property'])->name('property');      
    Route::get('/user/property/{id}',[UsersController::class, 'property'])->name('property');   
    Route::get('/user/deactivateproperty/{id}',[UsersController::class, 'deactivateproperty'])->name('deactivateproperty'); 
    Route::get('/user/activateproperty/{id}',[UsersController::class, 'activateproperty'])->name('activateproperty');    
    Route::get('/user/deleteproperty/{id}',[UsersController::class, 'deleteproperty'])->name('deleteproperty');   
    Route::post('/createproperty',[UsersController::class, 'createproperty'])->name('createproperty'); 
    Route::post('/updateproperty',[UsersController::class, 'updateproperty'])->name('updateproperty'); 
    Route::get('/user/flat/{pid}',[UsersController::class, 'flat'])->name('flat');      
    Route::get('/user/editflat/{pid}/{id}',[UsersController::class, 'editflat'])->name('editflat');   
    Route::get('/user/deleteflat/{id}',[UsersController::class, 'deleteflat'])->name('deleteflat');   
    Route::post('/createflat',[UsersController::class, 'createflat'])->name('createflat'); 
    Route::post('/updateflat',[UsersController::class, 'updateflat'])->name('updateflat'); 
    Route::get('/user/flatfees/{pid}/{id}',[UsersController::class, 'flatfees'])->name('flatfees');   
    
      
    //Fees routes
    Route::post('/add-fees',[UsersController::class, 'addfees'])->name('addfees'); 
    Route::get('/user/deactivatefee/{id}',[UsersController::class, 'deactivatefee'])->name('deactivatefee'); 
    Route::get('/user/activatefee/{id}',[UsersController::class, 'activatefee'])->name('activatefee');    
    Route::get('/user/deletefee/{id}',[UsersController::class, 'deletefee'])->name('deletefee');   
    

    //Tenants routes   
    Route::get('/user/managetenants',[UsersController::class, 'managetenants'])->name('managetenants');   
    Route::get('/user/newtenant/{id}',[UsersController::class, 'newtenant'])->name('newtenant');      
    Route::get('/user/viewtenant/{id}',[UsersController::class, 'viewtenant'])->name('viewtenant');      
    Route::get('/user/newtenant',[UsersController::class, 'newtenant'])->name('newtenant');      
    Route::get('/user/deletetenant/{id}',[UsersController::class, 'deletetenant'])->name('deletetenant');   
    Route::get('/user/newtenant',[UsersController::class, 'newtenant'])->name('newtenant');   
    Route::post('/savetenant',[UsersController::class, 'savetenant'])->name('savetenant'); 
    Route::post('/updatetenant',[UsersController::class, 'updatetenant'])->name('updatetenant'); 
    

    //Rent routes
    Route::get('/user/rents',[UsersController::class, 'rents'])->name('rents');   
    


    //Report routes
    Route::get('/user/propertyreport',[UsersController::class, 'propertyreport'])->name('propertyreport');   
    Route::get('/user/tenantreport',[UsersController::class, 'tenantreport'])->name('tenantreport');   
    Route::get('/user/financialreport',[UsersController::class, 'financialreport'])->name('financialreport');
    Route::post('/record-payment',[UsersController::class, 'recordpayment'])->name('recordpayment');  


    //Cronjob routes
    Route::get('/user/generateRents',[UsersController::class, 'generateRents'])->name('generateRents'); 
    
});