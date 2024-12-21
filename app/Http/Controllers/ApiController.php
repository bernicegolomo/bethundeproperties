<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
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
use App\Models\Settings;
use App\Notifications\WelcomeNotification;



class ApiController extends Controller
{
    
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:4'
        ]);

        $status = User::where('email',$request->email)->first();

        if(!isset($status)){ 
            return response()->json([
                'status' => false,
                'message' => 'Invalid Username or Password'
            ], 200);
        }else{
	    if($status->status == 0){
            	return response()->json([
                	'status' => false,
                	'message' => 'Inactive Account'
            	], 200);
	    }
            if($status->email_verified_at == null){
                return response()->json([
                    'status' => false,
                    'message' => 'Check your email for verification Link'
                ], 200);
            }
        }

        

        if (\Auth::guard()->attempt($request->only(['email','password']), $request->get('remember'))){
            
	     return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $status->createToken("API TOKEN")->plainTextToken,
                'user' => $status
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Invalid Username or Password'
            ], 200);
        }
    }


    public function users(){

     	$users = User::orderby('id', 'DESC')->get();
        return response()->json([
            'status' => true,
            'users' => $users
        ], 200);
    }

    public function administratordetails($id){
	$administrator = User::find($id);
        if(!$administrator){
            return response()->json([
                'status'  => 'error',
                'message' => 'Administrator does not exist.'
            ], 200);
        }

        return response()->json([
            'status'  => 'success',
            'administrator' => $administrator
        ], 200);
    }

    
    public function addadministrator(Request $request){
	request()->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users'],
            'phone'     => ['required', 'min:11', 'max:20'],
            'address'   => ['string', 'max:255'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $token = Str::random(20);
        if($request->is_admin == 1){$admin = 1;}else{$admin = 0;}

        $creatProfile = User::create([
                            'name'          => $request->name,
                            'email'         => $request->email,
                            'phone'         => $request->phone,
                            'address'       => $request->address,
                            'is_admin'      => $admin,
                            'password'      => Hash::make($request->password),
                            'status'        => 1,
                            'verify_token'  => $token,
                        ]);

        if($creatProfile){
            //send mail and redirect user
            $info = [
                'name'      => $request->name,
                'password'  => $request->password,
                'token'     => $token,
                'email'     => $request->email,
		'platform'  => "mobile"
            ];
            $creatProfile->notify(new WelcomeNotification($info));
	    return response()->json([
            	'status'  => "success",
		'message' => "Account profile has been successfully created. Confirmation email has been sent to email address provided.",
            	'user'    => $creatProfile
            ], 200);
        }else{
		return response()->json([
            		'status'  => "error",
			'message' => "Error in creating account profile"
            	], 200);
	}
    }


    public function updateprofile(Request $request)
    {
        request()->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'phone'     => ['required', 'min:11', 'max:20'],
            'address'   => ['string', 'max:255']
        ]);

        $user = User::FindOrFail($request->id);
        if($user && !empty($user)){
            if($request->is_admin == 1){$admin = 1;}else{$admin = 0;}
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->is_admin = $admin;
            $user->update();

            return response()->json([
            	'status'  => "success",
		'message' => "Account profile has been successfully updated."
            ], 200);

        }else{
	    return response()->json([
            	'status'  => "error",
		'message' => "Error in updating account. Profile not found."
            ], 200);
	}
        

        
    }

    public function deleteadministrator(Request $request)
    {        
        $administrator = User::find($request->id);
        if(!$administrator){
            return response()->json([
                'status'  => 'error',
                'message' => 'Administrator does not exist.'
            ], 200);
        }


        $administrator->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Administrator deleted successfully'
        ], 200);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'token' => 'required'
        ]);


        $user = User::where('email', $request->email)->where('verify_token', $request->token)->first();
        if(!empty($user)){
            if(empty($user->email_verified_at)){
                $today = Carbon::today();
                $user->update([
                    'email_verified_at' => $today
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Email verified successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'User email already verified!!'
                ], 200);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid email address or token'
        ], 200);



    }

    public function activateadministrator($id)
    {        
        $administrator = User::find($id);
        if(!$administrator){
            return response()->json([
                'status'  => 'error',
                'message' => 'Administrator does not exist.'
            ], 200);
        }

	$administrator->status = "1";
        $administrator->update();

        return response()->json([
            'status'  => 'success',
            'message' => 'Administrator activated successfully'
        ], 200);
    }

    public function deactivateadministrator($id)
    {        
        $administrator = User::find($id);
        if(!$administrator){
            return response()->json([
                'status'  => 'error',
                'message' => 'Administrator does not exist.'
            ], 200);
        }

	$administrator->status = "0";
        $administrator->update();

        return response()->json([
            'status'  => 'success',
            'message' => 'Administrator de-activated successfully'
        ], 200);
    }


    public function properties(){

     	$properties = Property::orderby('id', 'DESC')->get();
        return response()->json([
            'status' => true,
            'properties' => $properties
        ], 200);
    }


    public function addproperty(Request $request) 
    {
        request()->validate([
            'name'       => ['required', 'string', 'max:255', 'unique:properties'],
            'country'    => ['max:255'],
            'state'      => ['max:255'],
            'location'   => ['string', 'max:255'],
        ]);

        $createProperty = Property::create([
                            'name'      => $request->name,
                            'location'  => $request->location,
                            'country'   => $request->country,
                            'state'     => $request->state,
                            'status'    => 1,
                        ]);

        if($createProperty){
	      $createFlat = [];
	      if(isset($request->flat) && !empty($request->flat[0]['flatno'])){

		foreach($request->flat[0]['flatno'] as $key => $flatno){ //echo $flatno; die();
            		if(isset($request->flat['description'][$key]) && !empty($request->flat['description'][$key])){
                		$desc = $request->flat['description'][$key];
            		}else{
                		$desc = "";
            		}

            		$createFlat = Property_Flats::create([
                            'property_id' => $createProperty->id,
                            'flatno'      => $flatno,
                            'description' => $request->flat[0]['description'][$key],
                            'status'      => 0,
                        ]);
        	}
	    }
            return response()->json([
            	'status'      => "success",
		'message'     => "Property has been successfully created. You can proceed to add flats to this property.",
            	'property'    => $createProperty,
		'flats'       => $createFlat
            ], 200);            
        }else{
	    return response()->json([
            	'status'  => "error",
		'message' => "Error in adding property."
            ], 200); 
	}
    }


    public function deleteproperty(Request $request)
    {        
        $property = Property::find($request->id);
        if(!$property){
            return response()->json([
                'status'  => 'error',
                'message' => 'Property does not exist.'
            ], 200);
        }


        $property->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Property deleted successfully'
        ], 200);
    }
    

    public function updateproperty(Request $request)
    {
        request()->validate([
	    'id'        => ['required'],
            'name'      => ['required', 'string', 'max:255'],
            'location'  => ['required', 'max:255'],
            'country'   => ['max:20'],
            'state'     => ['string', 'max:255']
        ]);

        $property = Property::FindOrFail($request->id);
        if($property && !empty($property)){
            $property->name = $request->name;
            $property->location = $request->location;
            $property->country = $request->country;
            $property->state = $request->state;
            $property->update();

            return response()->json([
            	'status'  => "success",
		'message' => "Property has been successfully updated.",
            	'property'    => $property
            ], 200); 

        }
        
    }


    public function activateproperty($id)
    {        
        $property = Property::find($id);
        if(!$property){
            return response()->json([
                'status'  => 'error',
                'message' => 'property does not exist.'
            ], 200);
        }

	$property->status = "1";
        $property->update();

        return response()->json([
            'status'  => 'success',
            'message' => 'Property activated successfully'
        ], 200);
    }

    public function deactivateproperty($id)
    {        
        $property = Property::find($id);
        if(!$property){
            return response()->json([
                'status'  => 'error',
                'message' => 'Property does not exist.'
            ], 200);
        }

	$property->status = "0";
        $property->update();

        return response()->json([
            'status'  => 'success',
            'message' => 'Property de-activated successfully'
        ], 200);
    }


    public function propertydetails($id){

        $property = Property::find($id);
	
	if($property && !empty($property)){
		$fees = "";
        	$flats = Property_Flats::where('property_id', $property->id)->Orderby('id', 'DESC')->get();
		$tenants = Tenants::where('property_id', $property->id)->Orderby('id', 'DESC')->get();
        
        	return response()->json([
            		'status'  => 'success',
            		'property' => $property,
	    		'flats'    => $flats,
	    		'fees'     => $fees,
            		'tenants'  => $tenants
        	], 200);
	}else{
		return response()->json([
            		'status'  => 'error',
            		'message' => 'Property does not exist'
        	], 200);
	}
    }
 

    public function getdata(){
	$country = Country::all();
   	$states = States::all();

	return response()->json([
            'status'  => 'success',
            'country' => $country,
	    'states'  => $states
        ], 200);
    }

    public function addflats(Request $request){
	$x=0;
//print_r($request->flat['flatno']);  die();
	//foreach($request->flat  as $flat){ echo $flat; die();
		foreach($request->flat['flatno'] as $key => $flatno){ $x++; //echo $flatno; die();

 //if($x==2){
//echo $request->flat['description'][$key]; die();
//}
            		if(isset($request->flat['description'][$key]) && !empty($request->flat['description'][$key])){
                		$desc = $request->flat['description'][$key];
            		}else{
                		$desc = "";
            		}

            		$createFlat = Property_Flats::create([
                            'property_id' => $request->propertyid,
                            'flatno'      => $flatno,
                            'description' => $desc,
                            'status'      => 0,
                        ]);
        	//}
	}

        if($createFlat){
	    $flats = Property_Flats::where('property_id', $request->propertyid)->orderby('id', 'DESC')->get();
            return response()->json([
            	'status'  => 'success',
            	'message' => 'Property flats has been successfully created.',
	    	'flats'  => $flats
            ], 200);
        }

    }


    public function updateflat(Request $request)
    { 
        
        $propertyflat = Property_Flats::FindOrFail($request->flatid);
       
        if($propertyflat && !empty($propertyflat)){
            $propertyflat->flatno = $request->flatno;
            $propertyflat->description = $request->description;
            $propertyflat->property_id = $request->propertyid;
            $propertyflat->update();

            return response()->json([
            	'status'  => 'success',
            	'message' => 'Property flats has been successfully updated.',
	    	'flats'  => $propertyflat
            ], 200);

        }
        
    }

    public function flatdetails($id){
	$flats = Property_Flats::find($id);
        if(!$flats){
            return response()->json([
                'status'  => 'error',
                'message' => 'flat does not exist.'
            ], 200);
        }

        return response()->json([
            'status'  => 'success',
            'flat' => $flats
        ], 200);
    }


    public function propertyflats($id){
	$flats = Property_Flats::where('property_id', $id)->get();

	if($flats && count($flats) > 0){
	    return response()->json([
            	'status'  => 'success',
	    	'flats'  => $flats
            ], 200);
	}else{
	    return response()->json([
            	'status'  => 'error',
	    	'message'  => "No record found"
            ], 200);
	}
    }


    public function deleteflat(Request $request)
    {        
        $flat = Property_Flats::find($request->id);
        if(!$flat){
            return response()->json([
                'status'  => 'error',
                'message' => 'Flat does not exist.'
            ], 200);
        }


        $flat->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Flat deleted successfully'
        ], 200);
    }


    public function flats(){
	$flats = Property_Flats::orderby('id', 'DESC')->get();

	return response()->json([
            'status'  => 'success',
            'flats' => $flats
        ], 200);
    }

    
    public function tenants(){
	$tenants = Tenants::orderby('id', 'DESC')->get();

	return response()->json([
            'status'  => 'success',
            'tenants' => $tenants
        ], 200);
    }


    public function deletetenant(Request $request)
    {        
        $tenant = Tenants::find($request->id);
	
        if(!$tenant){
            return response()->json([
                'status'  => 'error',
                'message' => 'Tenant does not exist.'
            ], 200);
        }

	$tenantrent = Rents::where('tenant_id', $tenant->id);
	$tenantrent->delete();
        $tenant->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Tenant deleted successfully'
        ], 200);
    }

    public function addtenant(Request $request){ 
//return $request;
	request()->validate([
            'fname'         => ['required', 'string', 'max:255'],
            'lname'         => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'unique:tenants', 'max:15'],
            'email'         => ['email', 'max:255'],
            'occupation'    => ['required', 'string', 'max:255'],
            'address'       => ['string', 'max:255'],
            'gname'         => ['required', 'string', 'max:255'],
            'gphone'        => ['required', 'string', 'max:15'],
            'gaddress'      => ['required', 'string', 'max:255'],
            'property'      => ['required', 'string', 'max:255'],
            'flat'          => ['required', 'string', 'max:255'],
            'rent'          => ['required', 'string', 'max:255'],
        ]);

//echo $request->rent; die();

        $date  = $request->date;
	if(empty($request->duration)){ $duration = "1 year"; }else{ $duration = $request->duration; }
        //$duration="1 year"; 
	$endDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " + $duration"));

        //echo $endDate; die();
        //save tenant 

        $createTenant = Tenants::create([
            'firstname'         => $request->fname,
            'lastname'          => $request->lname,
            'phone'             => $request->phone,
            'occupation'        => $request->occupation,
            'email'             => $request->email,
            'previous_address'  => $request->address,
            'guarantor_name'    => $request->gname,
            'guarantor_phone'   => $request->gphone,
            'guarantor_address' => $request->gaddress,
            'property_id'       => $request->property,
            'flat_id'           => $request->flat,
            'fee'               => $request->rent,
            'startdate'         => $request->date,
            'rent_due_date'     => $endDate,
            'left_date'         => "",
            'status'            => 1,
        ]);

        if($createTenant){
            //save to rent table
            $createRent = Rents::create([
                'property_id'   => $request->property,
                'flat_id'       => $request->flat,
                'tenant_id'     => $createTenant->id,
                'start_year'    => $date,
                'end_year'      => $endDate,
                'fee'           => $request->rent,
                'status'        => 0,
            ]);

            //check if there is file and save file
            if($request->files && count($request->files) > 0){
		foreach($request->files as $key=>$image){
			$f = $request->files;
            		$folderPath = "assets/documents/"; 
	    	    	$image_parts = explode(";base64,", $f); 
            		$image_type_aux = explode("image/", $image_parts[0]); 
                	if(isset($image_type_aux[1])){ 
                    		$image_type = $image_type_aux[1];
                	}else{
            			$image_type = "png"; //$image_type_aux[1]; 
	    	    	}
            		$image_base64 = base64_decode($image_parts[0]);
            		$uniqid = uniqid();
            		$file = $folderPath . $uniqid . '.'.$image_type;
            		file_put_contents($file, $image_base64);
	    	    	$filename = $uniqid . '.'.$image_type;

			Documents::create([
                        	'tenant_id' => $createTenant->id,
                        	'file'      => $filename
                    	]);
          
		}
            }
                
            

            //redirect to tenants list
            return response()->json([
            	'status'  	=> 'success',
            	'message' 	=> 'Tenant profile has been successfully created.',
		'tenants'	=> $createTenant,
		'rent' 		=> $createRent
            ], 200);
        }else{
	    return response()->json([
            	'status'  => "error",
		'message' => "Error in creating tenant profile."
            ], 200); 
	}
    }


    public function updatetenant(Request $request){
        request()->validate([
            'fname'         => ['required', 'string', 'max:255'],
            'lname'         => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'max:15'],
            'email'         => ['email', 'max:255'],
            'occupation'    => ['required', 'string', 'max:255'],
            'address'       => ['string', 'max:255'],
            'gname'         => ['required', 'string', 'max:255'],
            'gphone'        => ['required', 'string', 'max:15'],
            'gaddress'      => ['required', 'string', 'max:255'],
            'property'      => ['required', 'string', 'max:255'],
            'flat'          => ['required', 'string', 'max:255'],
            'rent'          => ['required', 'string', 'max:255'],
        ]);
//echo $request; die();
        $tenant = Tenants::FindOrFail($request->tenantid);

        if(!isset($request->date)){
            $date       = $tenant->startdate;
            $endDate    = $tenant->rent_due_date;
        }else{
            $date       = $request->date;
	    //$duration = "1 year";
	    if(empty($request->duration)){ $duration = "1 year"; }else{ $duration = $request->duration; }
	    $endDate    = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " + $duration"));
        }
//echo $endDate; die();

        $tenant->firstname          = $request->fname;
        $tenant->lastname           = $request->lname;
        $tenant->phone              = $request->phone;
        $tenant->occupation         = $request->occupation;
        $tenant->email              = $request->email;
        $tenant->previous_address   = $request->address;
        $tenant->guarantor_name     = $request->gname;
        $tenant->guarantor_phone    = $request->gphone;
        $tenant->guarantor_address  = $request->gaddress;
        $tenant->property_id        = $request->property;
        $tenant->flat_id            = $request->flat;
        $tenant->fee                = $request->rent;
        $tenant->startdate          = $date;
        $tenant->rent_due_date      = $endDate;
        if(isset($request->vacate_date)){
            $tenant->left_date      = $request->vacate_date;
        }
        $tenant->update();

        //update to rent table
        $feez = Fees::FindOrFail($request->rent);
        $Rents = Rents::where('property_id', $request->property)
                        ->where('flat_id', $request->flat)
                        ->where('start_year', '>=', $feez->effective_date)
                        ->get();
        if($Rents && count($Rents) > 0){
            foreach($Rents as $Rent){
                $Rent->property_id  = $request->property;
                $Rent->flat_id      = $request->flat;
                $Rent->tenant_id    = $tenant->id;
                $Rent->start_year   = $date;
                $Rent->end_year     = $endDate;
                $Rent->fee          = $request->rent;
                $Rent->update();
            }
        }

        //check if there is file and save file
            if($request->files && !empty($request->files)){
		foreach($request->files as $key=>$image){
			$f = $image;
            		$folderPath = "assets/documents/"; 
	    	    	$image_parts = explode(";base64,", $f); 
            		$image_type_aux = explode("image/", $image_parts[0]); 
                	if(isset($image_type_aux[1])){ 
                    		$image_type = $image_type_aux[1];
                	}else{
            			$image_type = "png"; //$image_type_aux[1]; 
	    	    	}
            		$image_base64 = base64_decode($image_parts[0]);
            		$uniqid = uniqid();
            		$file = $folderPath . $uniqid . '.'.$image_type;
            		file_put_contents($file, $image_base64);
	    	    	$filename = $uniqid . '.'.$image_type;

			Documents::create([
                        	'tenant_id' => $tenant->id,
                        	'file'      => $filename
                    	]);
          
		}
            }


        return response()->json([
            	'status'  	=> 'success',
            	'message' 	=> 'Tenant profile has been successfully created.',
		'tenants'	=> $tenant
        ], 200);

    }

    public function viewtenant($id){
	$tenant = Tenants::find($id);
	$rents = Rents::select('rents.id', 'rents.property_id', 'rents.flat_id', 'rents.tenant_id', 'rents.start_year', 'rents.end_year', 'rents.fee')
                    ->join('tenants', 'rents.tenant_id', '=', 'tenants.id') 
                    ->orderBy('rents.id', 'DESC')
                    ->get();

        foreach($rents as $rent){
		$payment = $this->rentpaymenthistory($rent->id); //print_r($payment); die();
		$rentdetails[] = @array(
			'id'=> $rent->id, 
			'property_id'=> $rent->property_id,
			'flat_id' => $rent->flat_id,
			'tenant_id' => $rent->tenant_id,
			'start_year' => $rent->start_year,
			'end_year' => $rent->end_year,
			'fee' => $rent->fee,
			'total' => $payment['total'],
			'amount_paid' => $payment['paid'],
			'balance' => $payment['balance'],
			'status' => $rent->status

		);

	}
        return response()->json([
            'status'	=> 'success',
            'tenant' 	=> $tenant,
	    'paymenthistory' => $rentdetails
        ], 200);
        
    }

    public function flatfees($pid,$fid){
        $property = Property::findOrFail($pid);
        $flats = Property_Flats::Find($fid);  


        $fees = Fees::where('property_id', $pid)->where('flat_id', $fid)->orderby('id', 'DESC')->get();
        
	return response()->json([
            	'status'  	=> 'success',
            	'property' 	=> $property,
		'flat'		=> $flats,
		'fees'		=> $fees
        ], 200);

    }

    public function addfees(Request $request){
	request()->validate([
            'amount'    => ['required', 'max:8'],
        ]);

        if(!empty($request->date)){ $date = $request->date; }else{ $date = date("Y-m-d"); }

        $createFee = Fees::create([
            'property_id'       => $request->propertyid,
            'flat_id'           => $request->flatid,
            'fee'               => $request->amount,
            'effective_date'    => $date,
            'status'            => 1,
        ]);

        if($createFee){
            	return response()->json([
            		'status'  	=> 'success',
            		'message' 	=> "Fee has been successfully created",
			'fees'		=> $createFee
        	], 200);
        }else{
            	return response()->json([
            		'status'  	=> 'error',
            		'message' 	=> "Error in creating fees"
        	], 200);
	}
    }

    public function deletefee(Request $request){
        $id = $request->id;
        $fee = Fees::where('id',$id)->delete();

        if($fee){
            	return response()->json([
            		'status'  	=> 'success',
            		'message' 	=> "Fee has been successfully deleted"
        	], 200);
        }else{
            	return response()->json([
            		'status'  	=> 'error',
            		'message' 	=> "Error in deleting fees"
        	], 200);
	}
    }
    
    public function deactivatefee($id){
        $fee = Fees::FindOrFail($id);
        $fee->status = "0";
        $fee->update();
	return response()->json([
            	'status'  	=> 'success',
            	'message' 	=> "Fee has been deactivated successfully"
        ], 200);
    }

    public function activatefee($id){
        $fee = Fees::FindOrFail($id);
        $fee->status = "1";
        $fee->update();
	return response()->json([
            	'status'  	=> 'success',
            	'message' 	=> "Fee has been activated successfully"
        ], 200);
    }

    public function fees(){
	$fees = Fees::orderby('id', 'DESC')->get();

	return response()->json([
            'status'  => 'success',
            'fees' => $fees
        ], 200);
    }

    public function rents(){
        //$rents = Rents::orderby('id', 'DESC')->get();
	$rents = Rents::select('rents.id', 'rents.property_id', 'rents.flat_id', 'rents.tenant_id', 'rents.start_year', 'rents.end_year', 'rents.fee')
                    ->join('tenants', 'rents.tenant_id', '=', 'tenants.id') 
                    ->orderBy('rents.id', 'DESC')
                    ->get();

        if($rents && count($rents) > 0){
		foreach($rents as $rent){
			$payment = $this->rentpaymenthistory($rent->id); //print_r($payment); die();
			$tenant = Tenants::find($rent->tenant_id);
			$rentdetails[] = @array(
						'id'=> $rent->id, 
						'property_id'=> $rent->property_id,
						'flat_id' => $rent->flat_id,
						'tenant_id' => $rent->tenant_id,
						'tenantdetail' => $tenant->firstname .' '. $tenant->lastname  .' : '. $rent->start_year .' - '. $rent->end_year,
						'start_year' => $rent->start_year,
						'end_year' => $rent->end_year,
						'fee' => $rent->fee,
						'total' => $payment['total'],
						'amount_paid' => $payment['paid'],
						'balance' => $payment['balance'],
						'status' => $rent->status

					);

		}
            	return response()->json([
            		'status'  	=> 'success',
            		'rents' 	=> $rentdetails
        	], 200);
        }else{
            	return response()->json([
            		'status'  	=> 'error',
            		'message' 	=> "no rent found"
        	], 200);
	}
    }
 

    public function recordrentpayment(Request $request){

	request()->validate([
            'amount'    => ['required', 'min:1', 'max:10'],
            'tenantrent'    => ['required'],
        ]);

        if(!empty($request->date)){ $date = $request->date; }else{ $date = date("Y-m-d"); }
	$payhistory = $this->rentpaymenthistory($request->tenantrent);

	$rentbalance = $payhistory['balance'];
	$paybalance = $request->amount;
	$rentid = $request->tenantrent;
	
	$tenant = Tenants::select('tenants.phone', 'tenants.id')
                    ->join('rents', 'rents.tenant_id', '=', 'tenants.id') 
                    ->where('rents.id', $rentid)
                    ->first();




	//while($paybalance > 0) {
	while(true){
		
  		if($paybalance > $rentbalance){ 
			$payRent[] = $this->payrent($rentid,$rentbalance,$date);
			$createRent = $this->createNewRent($rentid);
			
			
			$paybalance = $paybalance - $rentbalance;
			$newfee = Fees::find($createRent->fee);
			$rentbalance = $newfee->fee;
			$rentid = $createRent->id;

		}else{ 
			$payRent[] = $this->payrent($rentid,$paybalance,$date);
			break;
		}
	}
//echo "God is good"; die();
	if($payRent){
		//send sms to tenant
		$smsid = 1;
		$smslive = Settings::find($smsid);
		$owneremail = $smslive->email;
	    	$subacct = $smslive->subaccount;
        	$subacctpwd = $smslive->password;
        	$sender = $smslive->sender;
		$msg = "Your payment has been received. Thank you for your patronage to Bethunde Properties";
	    	$msg=urlencode($msg);
	        $phone = $tenant->phone;
	    	$url="http://smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=".$owneremail."&subacct=".$subacct."&subacctpwd=".$subacctpwd."&message=".$msg."&sender=".$sender."&sendto=".$phone."&msgtype=0";

            	//$file = file_get_contents($url);
            	//$res = substr($file, 0, 2);

		return response()->json([
            		'status'  	=> 'success',
			'message'	=> "Rent payment has been successfully added",
            		'payment' 	=> $payRent
        	], 200);
	}

	
    }

    public function payrent($rentid,$amount,$date){
	$payRent = RentPayments::create([
            		'rent_id'       => $rentid,
            		'amount'        => $amount,
            		'payment_date'  => $date,
        ]);

	if($payRent){
		return true;
	}
    }
	
    public function createNewRent($id){
	$getrent = Rents::find($id); 
	$createRent = [];
	
	if($getrent && !empty($getrent)){
		$startdate = $getrent->end_year;
		$enddate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate)) . " + 1year"));
		$tenant = Tenants::find($getrent->tenant_id);

		//add to rent table
		$createRent = Rents::create([
                	'property_id'   => $getrent->property_id,
                	'flat_id'       => $getrent->flat_id,
                	'tenant_id'     => $getrent->tenant_id,
                	'start_year'    => $startdate,
                	'end_year'      => $enddate,
                	'fee'           => $tenant->fee,
                	'status'        => 0,
            	]);
	}

	return $createRent;
    }




    public function rentpaymenthistory($id){
		$getrent = Rents::find($id);
		$paid = 0; $total = 0; $balance = 0;

		if($getrent && !empty($getrent)){
			//get rent fee
			$fee = Fees::find($getrent->fee);
			if(!empty($fee)){
				$total = $fee->fee;
				//get total paid

				$paid = RentPayments::where('rent_id', $id)->sum('amount'); 
				$balance = ($total - $paid); 
			}
		}

		$data = @array('total' => $total, 'paid' => $paid, 'balance' => $balance);
		return $data;
		//echo $getrent; die();
    }

    public function dashboarddata(){
	$admins = User::where('status', 1)->count();
        $properties = Property::where('status', 1)->count();
        $flats = Property_Flats::count();
        $tenants = Tenants::where('status', 1)->count();

	return response()->json([
            'status'  		=> 'success',
            'admincount' 	=> $admins,
            'propertycount' 	=> $properties,
            'flatcount' 	=> $flats,
            'tenantcount' 	=> $tenants
	     
        ], 200);

    }


    public function allpayments(){
	$payments = RentPayments::orderBy('id', 'DESC')->get();
 
 //echo "God is faithfull"; die();

	return response()->json([
            'status'  	=> 'success',
            'payments' 	=> $payments
	     
        ], 200);

    }

    public function deletepayment(Request $request){
	$id = $request->id;
        $payment = RentPayments::where('id',$id)->delete();
//$payment = Property_Flats::orderby('id', 'DESC')->delete();
//$payment = Property::orderby('id', 'DESC')->delete();
//$payment = Rents::orderby('id', 'DESC')->delete();
//$payment = Tenants::orderby('id', 'DESC')->delete();

        if($payment){
            	return response()->json([
            		'status'  	=> 'success',
            		'message' 	=> "Payment has been successfully deleted"
        	], 200);
        }else{
            	return response()->json([
            		'status'  	=> 'error',
            		'message' 	=> "Error in deleting payment"
        	], 200);
	}
    }





}
