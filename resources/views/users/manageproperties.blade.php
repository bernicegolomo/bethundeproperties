@extends('layouts.userapp')

@section('content')

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row project-wrapper">
                        <div class="col-xxl-8">
                            <div class="row">
                                <div class="col-xs-12">
                                    @include('partials.errors') 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">All Properties</h4>
                                            @if($user->is_admin == 1)
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch form-switch-right form-switch-md">
                                                    <a href="{{url('user/property')}}" class="btn btn-success btn-label right rounded-pill" ><i class="ri-add-circle-line label-icon align-middle rounded-pill fs-16 ms-2"></i> Add Property</a>
                                                </div>
                                            </div>
                                            @endif
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="table-responsive">
                                                    <table class="table align-middle table-striped-columns" style="z-index:2;">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th scope="col" class="text-warp">SNO.</th>
                                                                <th scope="col" class="text-warp">PROPERTY NAME</th>
                                                                <th scope="col" class="text-warp">LOCATION</th>
                                                                <th scope="col" class="text-warp">COUNTRY</th>
                                                                <th scope="col" class="text-warp">STATE</th>
                                                                <th scope="col" class="text-warp">Status</th>
                                                                <th scope="col" class="text-warp">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($properties) && count($properties) > 0)
                                                                @php $x=0; @endphp
                                                                @foreach($properties as $property)
                                                                  @php $x++; @endphp
                                                                    <tr>
                                                                        <td><span class="fw-medium text-primary"># {{ $x }}</span></td>
                                                                        <td>{{ $property->name }}</td>  
                                                                        <td class="text-wrap">{{ $property->location }}</td>          
                                                                        <td>
                                                                            @php $country = App\Http\Controllers\UsersController::countrydetails($property->country); @endphp
                                                                            {{ $country->name }}
                                                                        </td> 
                                                                        <td>
                                                                            @php $state = App\Http\Controllers\UsersController::statedetails($property->state); @endphp
                                                                            {{ $state->name }}
                                                                        </td>
                                                                        <td>                                                                            
                                                                            @if($property->status == 1)
                                                                                <span class="badge badge-soft-success"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> Active</span>
                                                                            @else
                                                                                <span class="badge badge-soft-danger"><i class="ri-close-circle-line fs-10 align-middle"></i> In-Active</span>
                                                                            @endif
                                                                        </td>    
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" role="button" id="dropdownMenuLink5" data-bs-toggle="dropdown" aria-expanded="false" class="text-danger">
                                                                                    <i class="ri-more-2-fill"></i>
                                                                                </a>

                                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink5" style="">
                                                                                    <li><a class="dropdown-item" href="{{ url('user/propertyflats', ['id' => Illuminate\Support\Facades\Crypt::encrypt($property->id)]) }}">Property Flats</a></li>
                                                                                    <li><a class="dropdown-item" href="{{ url('user/property', ['id' => Illuminate\Support\Facades\Crypt::encrypt($property->id)]) }}">Edit Property</a></li>
                                                                                    <li>
                                                                                        @if($property->status == 1)
                                                                                        <a class="dropdown-item" href="{{ url('user/deactivateproperty', ['id' => Illuminate\Support\Facades\Crypt::encrypt($property->id)]) }}">De-Activate Property</a>
                                                                                        @else
                                                                                        <a class="dropdown-item" href="{{ url('user/activateproperty', ['id' => Illuminate\Support\Facades\Crypt::encrypt($property->id)]) }}">Activate Property</a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li><a class="dropdown-item" href="{{ url('user/deleteproperty', ['id' => Illuminate\Support\Facades\Crypt::encrypt($property->id)]) }}" onclick="return confirm(' Are you sure you want to delete this property?');">Delete Profile</a></li>
                                                                                </ul>
                                                                            </div>

                                                                            
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="8" class="text-center">No data found</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <!-- end table -->
                                                </div>
                                                <!-- end table responsive -->
                                            </div>
                                            
                                        </div><!-- end card-body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </div>
                    </div>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

 
@endsection