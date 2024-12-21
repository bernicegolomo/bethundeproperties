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
                                            <h4 class="card-title mb-0 flex-grow-1"> FLATS FOR {{strtoupper($property->name)}}</h4>
                                            @if($user->is_admin == 1)
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch form-switch-right form-switch-md">
                                                    <a href="{{url('user/flat', ['pid' => Illuminate\Support\Facades\Crypt::encrypt($property->id)]) }}" class="btn btn-success btn-label right rounded-pill" ><i class="ri-add-circle-line label-icon align-middle rounded-pill fs-16 ms-2"></i> Add Flat</a>
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
                                                                <th scope="col" class="text-warp">FLAT NO</th>
                                                                <th scope="col" class="text-warp">DESCRIPTION</th>
                                                                <th scope="col" class="text-warp">Status</th>
                                                                <th scope="col" class="text-warp">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($flats) && count($flats) > 0)
                                                                @php $x=0; @endphp
                                                                @foreach($flats as $flat)
                                                                  @php $x++; @endphp
                                                                    <tr>
                                                                        <td><span class="fw-medium text-primary"># {{ $x }}</span></td>
                                                                        <td>{{ $flat->flatno }}</td>  
                                                                        <td class="text-wrap">{{ $flat->description }}</td>     
                                                                        
                                                                        <td>
                                                                            @php $flatstatus = App\Http\Controllers\UsersController::flatstatus($flat->status); @endphp
                                                                            <span class="badge badge-soft-info"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> {{$flatstatus}}</span>
                                                                        </td>

                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <a href="#" role="button" id="dropdownMenuLink5" data-bs-toggle="dropdown" aria-expanded="false" class="text-danger">
                                                                                    <i class="ri-more-2-fill"></i>
                                                                                </a>

                                                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink5" style="">
                                                                                    <li><a class="dropdown-item" href="{{ url('user/editflat', ['pid' => Illuminate\Support\Facades\Crypt::encrypt($flat->property_id), 'id' => Illuminate\Support\Facades\Crypt::encrypt($flat->id)]) }}">Edit Flat</a></li>
                                                                                    <li><a class="dropdown-item" href="{{ url('user/flatfees', ['pid' => Illuminate\Support\Facades\Crypt::encrypt($flat->property_id), 'id' => Illuminate\Support\Facades\Crypt::encrypt($flat->id)]) }}">Manage Fees</a></li>                                                                                                                                                                        
                                                                                    <li><a class="dropdown-item" href="{{ url('user/deleteflat', ['id' => Illuminate\Support\Facades\Crypt::encrypt($flat->id)]) }}" onclick="return confirm(' Are you sure you want to delete this flat?');">Delete Flat</a></li>
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