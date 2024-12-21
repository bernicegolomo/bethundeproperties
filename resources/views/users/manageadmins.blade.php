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
                                            <h4 class="card-title mb-0 flex-grow-1">All Administrators</h4>
                                            @if($user->is_admin == 1)
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch form-switch-right form-switch-md">
                                                    <a href="{{url('user/admin')}}" class="btn btn-success btn-label right rounded-pill" ><i class="ri-add-circle-line label-icon align-middle rounded-pill fs-16 ms-2"></i> Add Administrator</a>
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
                                                                <th scope="col" class="text-warp">Email</th>
                                                                <th scope="col" class="text-warp">Phone</th>
                                                                <th scope="col" class="text-warp">Address</th>
                                                                <th scope="col" class="text-warp">Portal Access</th>
                                                                <th scope="col" class="text-warp">Status</th>
                                                                <th scope="col" class="text-warp">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($users) && !empty($users))
                                                                @php $x=0; @endphp
                                                                @foreach($users as $admin)
                                                                  @php $x++; @endphp
                                                                    <tr>
                                                                        <td><span class="fw-medium text-primary"># {{ $x }}</span></td>
                                                                        <td>{{ $admin->name }}</td>  
                                                                        <td class="text-wrap">{{ $admin->email }}</td>          
                                                                        <td>{{ $admin->phone }}</td> 
                                                                        <td>{{ $admin->address }}</td>
                                                                        <td>
                                                                            @if($admin->is_admin == 1)
                                                                                <span class="badge badge-soft-primary">Super Administrator</span>
                                                                            @else
                                                                                <span class="badge badge-soft-warning">Lawyer | Agent</span>
                                                                            @endif
                                                                        </td>    
                                                                        <td>                                                                            
                                                                            @if($admin->status == 1)
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
                                                                                    <li><a class="dropdown-item" href="{{ url('user/admin', ['id' => Illuminate\Support\Facades\Crypt::encrypt($admin->id)]) }}">Edit Profile</a></li>
                                                                                    <li>
                                                                                        @if($admin->status == 1)
                                                                                        <a class="dropdown-item" href="{{ url('user/deactivateprofile', ['id' => Illuminate\Support\Facades\Crypt::encrypt($admin->id)]) }}">De-Activate Profile</a>
                                                                                        @else
                                                                                        <a class="dropdown-item" href="{{ url('user/activateprofile', ['id' => Illuminate\Support\Facades\Crypt::encrypt($admin->id)]) }}">Activate Profile</a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li><a class="dropdown-item" href="{{ url('user/deleteprofile', ['id' => Illuminate\Support\Facades\Crypt::encrypt($admin->id)]) }}" onclick="return confirm(' Are you sure you want to delete this profile?');">Delete Profile</a></li>
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