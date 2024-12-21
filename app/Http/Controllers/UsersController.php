<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
use App\Notifications\WelcomeNotification;

class UsersController extends Controller
{
    //

    public function dashboard(){
        $title = "Dashboard";
        $user = Auth::guard()->user();
        $admins = User::where('status', 1)->count();
        $properties = Property::where('status', 1)->count();
        $flats = Property_Flats::count();
        $tenants = Tenants::where('status', 1)->count();
        
        return view('users.dashboard', compact('user','admins', 'properties', 'flats', 'tenants', 'title'));
    }

    public function manageadmins(){
        
        $title = "Manage Admins";
        $user = Auth::guard()->user();
        if($user->is_admin != 1){
            return redirect('user/dashboard')->with('danger', 'Access restiction');
        }

        $users = User::orderby('id', 'DESC')->paginate(9);
        
        return view('users.manageadmins', compact('user','title','users'));
    }

    public function deactivateprofile($id){
        $id = Crypt::decrypt($id);
        $user = User::FindOrFail($id);
        $user->status = "0";
        $user->update();
        return back()->with('success', 'Profile has been deactivated successfully');
    }

    public function activateprofile($id){
        $id = Crypt::decrypt($id);
        $user = User::FindOrFail($id);
        $user->status = "1";
        $user->update();
        return back()->with('success', 'Profile has been deactivated successfully');
    }

    public function deleteprofile($id){
        $id = Crypt::decrypt($id);
        $user = User::where('id',$id)->delete();

        return back()->with('success', 'Profile has been deleted successfully');
    }

    public function admin($id=null){
        if($id !=null){
            $id = Crypt::decrypt($id);
            $profile = User::Find($id);
            return view('users.admin', compact('profile'));
        }
        return view('users.admin');
    }

    public function create(Request $request)
    {
        request()->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users'],
            'phone'     => ['required', 'min:11', 'max:20'],
            'address'   => ['string', 'max:255'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $token = Str::random(20);
        if($request->admin == 1){$admin = 1;}else{$admin = 0;}

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
                'email'     => $request->email
            ];
            $creatProfile->notify(new WelcomeNotification($info));
            return back()->with('success', 'Account profile has been successfully created. Confirmation email has been sent to email address provided.');
        }
    }

    public function update(Request $request)
    {
        request()->validate([
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255'],
            'phone'     => ['required', 'min:11', 'max:20'],
            'address'   => ['string', 'max:255']
        ]);

        $user = User::FindOrFail($request->id);
        if($user && !empty($user)){
            if($request->admin == 1){$admin = 1;}else{$admin = 0;}
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->is_admin = $admin;
            $user->update();

            return back()->with('success', 'Account profile has been successfully updated.');

        }
        

        
    }

    public function manageproperty(){
        $title = "Manage Properties";
        $user = Auth::guard()->user();
        if($user->is_admin != 1){
            return redirect('user/dashboard')->with('danger', 'Access restiction');
        }

        $properties = Property::orderby('id', 'DESC')->paginate(9);
        
        return view('users.manageproperties', compact('user','title','properties'));
    }


    public function deactivateproperty($id){
        $id = Crypt::decrypt($id);
        $user = Property::FindOrFail($id);
        $user->status = "0";
        $user->update();
        return back()->with('success', 'Property has been deactivated successfully');
    }

    public function activateproperty($id){
        $id = Crypt::decrypt($id);
        $user = Property::FindOrFail($id);
        $user->status = "1";
        $user->update();
        return back()->with('success', 'Property has been deactivated successfully');
    }

    public function deleteproperty($id){
        $id = Crypt::decrypt($id);
        $user = Property::where('id',$id)->delete();

        return back()->with('success', 'Property has been deleted successfully');
    }

    public function property($id=null){
        $countrys = Country::all();
        $states = States::all();
        $title = "Property";

        if($id !=null){
            $id = Crypt::decrypt($id);
            $property = Property::Find($id);
            return view('users.property', compact('property', 'countrys', 'states', 'title'));
        }
        return view('users.property', compact('countrys', 'states', 'title'));
    }


    public function createproperty(Request $request)
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
            //redirect user            
            return back()->with('success', 'Property has been successfully created. You can proceed to add flats to this property.');
        }
    }

    public function updateproperty(Request $request)
    {
        request()->validate([
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

            return back()->with('success', 'Property has been successfully updated.');

        }
        

        
    }

    public function propertyflats($id){

        $fid = Crypt::decrypt($id);
        $property = Property::find($fid);
        $title = "Property Flats";
        $user = Auth::guard()->user();
        if($user->is_admin != 1){
            return redirect('user/dashboard')->with('danger', 'Access restiction');
        }

        $flats = Property_Flats::where('property_id', $property->id)->Orderby('id', 'DESC')->get();
        
        return view('users.propertyflats', compact('user','title','property','flats'));
    }

    public function deleteflat($id){
        $id = Crypt::decrypt($id);
        $user = Property_Flats::where('id',$id)->delete();

        return back()->with('success', 'Flat has been deleted successfully');
    }

    public function flat($pid,$id=null){
        $title = "Property Flats";
        $propertyid = Crypt::decrypt($pid);
        $property = Property::findOrFail($propertyid);

        if($id !=null){
            $flatid = Crypt::decrypt($id);
            $flats = Property_Flats::Find($flatid);            
            return view('users.property', compact('flats','title','property'));
        }
        return view('users.flats', compact('title','property'));
    }

    public function editflat($pid,$id){
        $title = "Property Flats";
        $propertyid = Crypt::decrypt($pid);
        $property = Property::findOrFail($propertyid);

        $flatid = Crypt::decrypt($id);
        $flats = Property_Flats::Find($flatid);  

        return view('users.editflat', compact('flats','title','property'));
        
    }

    public function createflat(Request $request)
    {
        //request()->validate([
            //'no'            => ['required', 'string', 'max:255'],
            //'description'   => ['max:255'],
        //]);

        foreach($request->no as $key => $flatno){ 
            if(isset($request->input('description')[$key]) && !empty($request->input('description')[$key])){
                $desc = $request->input('description')[$key];
            }else{
                $desc = "";
            }

            $createFlat = Property_Flats::create([
                            'property_id' => $request->propertyid,
                            'flatno'      => $flatno,
                            'description' => $request->description[$key],
                            'status'      => 0,
                        ]);
        }

        if($createFlat){
            //redirect user            
            return back()->with('success', 'Property flats has been successfully created.');
        }
    }

    public function updateflat(Request $request)
    { 
        //request()->validate([
            //'no'            => ['required', 'string', 'max:255'],
            //'description'   => ['max:255'],
        //]);
        
        $propertyflat = Property_Flats::FindOrFail($request->flatid);
        $pid = Crypt::encrypt($request->propertyid);
        if($propertyflat && !empty($propertyflat)){
            $propertyflat->flatno = $request->no;
            $propertyflat->description = $request->description;
            $propertyflat->property_id = $request->propertyid;
            $propertyflat->update();

            return redirect("/user/propertyflats/$pid")->with('success', 'Property flat has been successfully updated.');

        }
        
    }

    public function managetenants(){
        $title = "Manage Tenants";
        $user = Auth::guard()->user();
        if($user->is_admin != 1){
            return redirect('user/dashboard')->with('danger', 'Access restiction');
        }

        $tenants = Tenants::orderby('id', 'DESC')->paginate(9);
        
        return view('users.tenants', compact('user','title','tenants'));
    }

    public function newtenant($id=null){
        $title = "New Tenants";
        $properties = Property::orderby('id', 'DESC')->get();


        if($id !=null){
            $id = Crypt::decrypt($id);
            $tenant = Tenants::Find($id);
            $flats = Property_Flats::where('property_id', $tenant->property_id)->orderby('id', 'DESC')->get();
            $getfee = Rents::where('property_id', $tenant->property_id)->where('flat_id', $tenant->flat_id)->first();
            $rents = Fees::where('property_id', $tenant->property_id)->where('flat_id', $tenant->flat_id)->orderby('id', 'DESC')->get();
          
            return view('users.newtenant', compact('title', 'properties', 'tenant', 'flats', 'rents', 'getfee'));
        }

        return view('users.newtenant', compact('title','properties'));
    }

    public function savetenant(Request $request){
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

        $date  = $request->date;
        $endDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " + $request->duration"));

        //dd($endDate); die();
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
            if($request->hasFile('files')){
                foreach($request->file('files') as $key=>$file){
                    $filename = time().'.'.$file->extension();
                    $file->move('assets/documents/', $filename);
    
                    //save files
                    Documents::create([
                        'tenant_id' => $createTenant->id,
                        'file'      => $filename
                    ]);
    
                }
            }

            //redirect to tenants list
            return redirect('user/managetenants')->with('sucess', 'Tenant has been added successfully');

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

        $tenant = Tenants::FindOrFail($request->tenantid);

        if(!isset($request->date)){
            $date       = $tenant->startdate;
            $endDate    = $tenant->rent_due_date;
        }else{
            $date       = $request->date;
            $endDate    = date("Y-m-d", strtotime(date("Y-m-d", strtotime($date)) . " + $request->duration"));
        }

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
        if(isset($request->vdate)){
            $tenant->left_date      = $request->vdate;
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
        }else{
		$Rent = Rents::where('tenant_id', $tenant->id)->first();
		if($Rent && empty($Rent)){
			//save to rent table
            		$createRent = Rents::create([
                		'property_id'   => $request->property,
                		'flat_id'       => $request->flat,
                		'tenant_id'     => $tenant->id,
                		'start_year'    => $date,
                		'end_year'      => $endDate,
                		'fee'           => $request->rent,
                		'status'        => 0
            		]);
		}
	}

        //check if there is file and save file
        if($request->hasFile('files')){
            foreach($request->file('files') as $key=>$file){
                $filename = time().'.'.$file->extension();
                $file->move('assets/documents/', $filename);

                //save files
                Documents::create([
                    'tenant_id' => $tenant->id,
                    'file'      => $filename
                ]);

            }
        }

        return back()->with('success', 'Tenant profile has been successfully updated.');

    }

    public function getflats($id){ 
        $flats['data'] = Property_Flats::where('property_id', $id)->get();
        return response()->json($flats);
    }

    public function getflatfees($pid,$id){ 
        $fees['data'] = Fees::where('property_id', $pid)->where('flat_id', $id)->get();
        return response()->json($fees);
    }


    public function flatfees($pid,$fid){
        $title = "Manage Flat Fees";
        $user = Auth::guard()->user();
        if($user->is_admin != 1){
            return redirect('user/dashboard')->with('danger', 'Access restiction');
        }

        $propertyid = Crypt::decrypt($pid);
        $property = Property::findOrFail($propertyid);

        $flatid = Crypt::decrypt($fid);
        $flats = Property_Flats::Find($flatid);  


        $fees = Fees::where('property_id', $propertyid)->where('flat_id', $flatid)->orderby('id', 'DESC')->paginate(9);
        
        return view('users.flatfees', compact('user','title','propertyid', 'flatid', 'fees', 'property', 'flats'));
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
            //redirect user            
            return back()->with('success', 'Fee has been successfully created.');
        }
    }

    public function deactivatefee($id){
        $id = Crypt::decrypt($id);
        $fee = Fees::FindOrFail($id);
        $fee->status = "0";
        $fee->update();
        return back()->with('success', 'Fee has been deactivated successfully');
    }

    public function activatefee($id){
        $id = Crypt::decrypt($id);
        $fee = Fees::FindOrFail($id);
        $fee->status = "1";
        $fee->update();
        return back()->with('success', 'Fee has been activated successfully');
    }

    public function deletefee($id){
        $id = Crypt::decrypt($id);
        $fee = Fees::where('id',$id)->delete();

        return back()->with('success', 'Fee has been deleted successfully');
    }

    public function recordpayment(Request $request){
        request()->validate([
            'amount'    => ['required', 'min:1', 'max:10'],
            'tenantrent'    => ['required'],
        ]);

        if(!empty($request->date)){ $date = $request->date; }else{ $date = date("Y-m-d"); }

        $createRent = RentPayments::create([
            'rent_id'       => $request->tenantrent,
            'amount'        => $request->amount,
            'payment_date'  => $date,
        ]);

        if($createRent){
            //redirect user            
            return back()->with('success', 'Rent payment has been successfully added.');
        }
    }


    public static function countrydetails($id){
        return Country::Find($id);
    }

    public static function statedetails($id){
        return States::Find($id);
    }

    public static function propertydetails($id){
        return Property::Find($id);
    }

    public static function flatdetails($id){
        return Property_Flats::Find($id);
    }

    public static function flatstatus($status){
        if($status == 0){
            $name = "Not Occupied";
        }elseif($status == 1){
            $name = "Active Tenant";
        }elseif($status == 2){
            $name = "Due Rent";
        }elseif($status == 3){
            $name = "Quick Notice Issued";
        }

        return $name;
    }

    public function deletetenant($id){
        $id = Crypt::decrypt($id);
        $user = Tenants::where('id',$id)->delete();

        return back()->with('success', 'Tenant has been deleted successfully');
    }

    public function viewtenant($id){
        $title = "View Tenant";
        $tid = Crypt::decrypt($id);
        $tenant = Tenants::FindOrFail($tid);
//dd($tenant); die();

        return view('users.viewtenant', compact('tenant','title'));
    }

    public static function tenantdetails($id){
        return Tenants::Find($id);
    }

    public static function rentpaymentbalance($id){
        $rent = Rents::Find($id);
        $payment = RentPayments::where('rent_id', $id)->get();

        return "0";
    }

    public static function tenantfeedetails($tenantid,$propertyid,$flatid){
        $getfee = Rents::where('property_id', $propertyid)->where('flat_id', $flatid)->where('tenant_id', $tenantid)->first();
//dd(Rents::all()); die();
        return Fees::where('id', $getfee->fee)->first();
    }

    public static function tenantdocuments($tenantid){
        return Documents::where('tenant_id', $tenantid)->get();
    }

    public function rents(){
        $title = "Rents";
        $user = Auth::guard()->user();
	$rents = Rents::select('rents.property_id', 'rents.flat_id', 'rents.tenant_id', 'rents.start_year', 'rents.end_year', 'rents.fee', 'rents.status')
                            ->join('tenants', 'rents.tenant_id', '=', 'tenants.id')
                            ->get();
        //$rents = Rents::orderby('id', 'DESC')->get();

        return view('users.rents', compact('rents', 'user', 'title'));
    }

    public function generateRents(){
        //Get all active tenants and create valid new rents
        //get 2 month ahead date
        //check if enddate is <=
        $tenants = Tenants::where("created_at",">", Carbon::now()->subMonths(3))->get();
        dd($tenants); die();
        //2023-06-02


        Profession::select('professions.id', 'professions.user_id', 'professions.profile', 'professions.category')
                    ->join('users', 'users.id', '=', 'professions.user_id') 
                    ->where('professions.user_id', '!=', $user->id)
                    ->orderBy('professions.created_at', 'DESC')
                    ->paginate(9);
    }


}
