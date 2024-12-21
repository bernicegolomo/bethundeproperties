<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Property;
use App\Models\Property_Flats;
use App\Models\Tenants;
use App\Models\Country;
use App\Models\States;
use App\Models\Fees;
use App\Models\Rents;
use App\Models\RentPayments;
use App\Models\Documents;
use App\Notifications\WelcomeNotification;

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


Route::post('/login', [ApiController::class, 'login']);
Route::post('/verify', [ApiController::class, 'verify']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/dashboarddata', [ApiController::class, 'dashboarddata']);
    Route::get('/administrators', [ApiController::class, 'users']);
    Route::get('/administratordetails/{id}', [ApiController::class, 'administratordetails']);
    Route::post('/addadministrator', [ApiController::class, 'addadministrator']);
    Route::post('/editadministrator', [ApiController::class, 'updateprofile']);
    Route::post('/deleteadministrator', [ApiController::class, 'deleteadministrator']);
    Route::get('/activate_administrator/{id}', [ApiController::class, 'activateadministrator']);
    Route::get('/deactivate_administrator/{id}', [ApiController::class, 'deactivateadministrator']);


    Route::get('/properties', [ApiController::class, 'properties']);
    Route::post('/addproperty', [ApiController::class, 'addproperty']);
    Route::post('/updateproperty', [ApiController::class, 'updateproperty']);
    Route::post('/deleteproperty', [ApiController::class, 'deleteproperty']);
    Route::get('/activate_property/{id}', [ApiController::class, 'activateproperty']);
    Route::get('/deactivate_property/{id}', [ApiController::class, 'deactivateproperty']);
    Route::get('/propertydetails/{id}', [ApiController::class, 'propertydetails']);

    Route::get('/getdata', [ApiController::class, 'getdata']);



    Route::post('/addflats', [ApiController::class, 'addflats']);
    Route::post('/updateflat', [ApiController::class, 'updateflat']);
    Route::post('/addflats', [ApiController::class, 'addflats']);
    Route::post('/deleteflat', [ApiController::class, 'deleteflat']);
    Route::get('/propertyflats/{pid}', [ApiController::class, 'propertyflats']);    
    Route::get('/flatdetails/{id}', [ApiController::class, 'flatdetails']);    
    Route::get('/flats', [ApiController::class, 'flats']);

        
    Route::get('/fees', [ApiController::class, 'fees']);
    Route::get('/flatfees/{pid}/{fid}', [ApiController::class, 'flatfees']);
    Route::post('/addflatfees', [ApiController::class, 'addfees']);
    Route::post('/deleteflatfee', [ApiController::class, 'deletefee']);
    Route::get('/activateflatfee/{id}', [ApiController::class, 'activatefee']);
    Route::get('/deactivateflatfee/{id}', [ApiController::class, 'deactivatefee']);
    

    Route::get('/tenants', [ApiController::class, 'tenants']);
    Route::get('/viewtenant/{id}', [ApiController::class, 'viewtenant']);
    Route::post('/deletetenants', [ApiController::class, 'deletetenant']);     
    Route::post('/addtenant', [ApiController::class, 'addtenant']);   
    Route::post('/updatetenant', [ApiController::class, 'updatetenant']);

    
    Route::get('/rents', [ApiController::class, 'rents']);
    Route::post('/recordrentpayment', [ApiController::class, 'recordrentpayment']);
    Route::get('/rentpaymenthistory', [ApiController::class, 'rentpaymenthistory']);
    Route::get('/allpayments', [ApiController::class, 'allpayments']);
    Route::post('/deletepayment', [ApiController::class, 'deletepayment']); 
});
