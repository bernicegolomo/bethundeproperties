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
                                            <h4 class="card-title mb-0 flex-grow-1"> TENANTS</h4>
                                            @if($user->is_admin == 1)
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch form-switch-right form-switch-md">
                                                    <a href="{{url('user/newtenant') }}" class="btn btn-success btn-label right rounded-pill" ><i class="ri-add-circle-line label-icon align-middle rounded-pill fs-16 ms-2"></i> Add Tenant</a>
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
                                                                <th scope="col" class="text-warp">FULL NAME</th>
                                                                <th scope="col" class="text-warp">PHONE</th>
                                                                <th scope="col" class="text-warp">OCCUPATION</th>
                                                                <th scope="col" class="text-warp">FLAT OCCUPIED</th>
                                                                <th scope="col" class="text-warp">STATUS</th>
                                                                <th scope="col" class="text-warp">ACTION</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($tenants) && count($tenants) > 0)
                                                                @php $x=0; @endphp
                                                                @foreach($tenants as $tenant)
                                                                  @php $x++; @endphp
                                                                    <tr>
                                                                        <td><span class="fw-medium text-primary"># {{ $x }}</span></td>
                                                                        <td>{{ strtoupper($tenant->firstname  .' '. $tenant->lastname) }}</td>  
                                                                        <td>{{ $tenant->phone }}</td>  
                                                                        <td>{{ $tenant->occupation }}</td>  
                                                                        <td>
                                                                            @php $property = App\Http\Controllers\UsersController::propertydetails($tenant->property_id); @endphp
                                                                            @php $flat = App\Http\Controllers\UsersController::flatdetails($tenant->flat_id); @endphp
										@if(!empty($property) && !empty($flat))
                                                                             		{{ strtoupper($property->name) }} - {{ strtoupper($flat->flatno) }}
										@endif
                                                                        </td>                                                                          
                                                                        <td>
                                                                            @if($tenant->status == 1)
                                                                                <span class="badge badge-soft-success"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> Active</span>
                                                                            @elseif($tenant->status == 2)
                                                                                <span class="badge badge-soft-warning"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> Rent Almost Due</span>
                                                                            @elseif($tenant->status == 3)
                                                                                <span class="badge badge-soft-danger"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> Rent Due</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" role="button" id="dropdownMenuLink5" data-bs-toggle="dropdown" aria-expanded="false" class="text-danger">
                                                                                    <i class="ri-more-2-fill"></i>
                                                                                </a>

                                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink5" style="">
                                                                                    <li><a class="dropdown-item" href="{{ url('user/viewtenant', ['id' => Illuminate\Support\Facades\Crypt::encrypt($tenant->id)]) }}">View Tenant</a></li>                                                                                    
                                                                                    <li><a class="dropdown-item" href="{{ url('user/newtenant', ['id' => Illuminate\Support\Facades\Crypt::encrypt($tenant->id)]) }}">Edit Tenant</a></li>                                                                                    
                                                                                    <li><a class="dropdown-item" href="{{ url('user/deletetenant', ['id' => Illuminate\Support\Facades\Crypt::encrypt($tenant->id)]) }}" onclick="return confirm(' Are you sure you want to delete this tenant?');">Delete Tenant</a></li>
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