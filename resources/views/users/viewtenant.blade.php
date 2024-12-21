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
                                            <h4 class="card-title mb-0 flex-grow-1"> {{strtoupper($tenant->firstname .' '. $tenant->lastname)}}</h4>
                                            
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="table-responsive">
                                                    <table class="table align-middle table-striped-columns" style="z-index:2;">
                                                        <tbody>
                                                            <tr>
                                                                <th>PHONE</th>
                                                                <td>{{ $tenant->phone }}</td>

                                                                <th>GURANTOR'S NAME</th>
                                                                <td>{{ $tenant->guarantor_name }}</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th>EMAIL</th>
                                                                <td>{{ $tenant->email}}</td>

                                                                <th>GURANTOR'S PHONE</th>
                                                                <td>{{ $tenant->guarantor_phone }}</td>
                                                            </tr>
                                                           
                                                            <tr>
                                                                <th>OCCUPATION</th>
                                                                <td>{{ $tenant->occupation }}</td>

                                                                <th>GURANTOR'S ADDRESS</th>
                                                                <td>{{ $tenant->gurantor_address }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>PREVIOUS ADDRESS</th>
                                                                <td>{{ $tenant->previous_address }}</td>

                                                                <th></th>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>RENT START DATE</th>
                                                                <td>{{ $tenant->startdate }}</td>

                                                                <th>PROPERTY VACATE DATE</th>
                                                                <td>
                                                                    @if(!empty($tenant->left_date))                                                                    
                                                                        {{ $tenant->left_date }}
                                                                    @else
                                                                        Active Tenant
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>PROPERY COUPPIED</th>
                                                                <td>
                                                                    @php $property = App\Http\Controllers\UsersController::propertydetails($tenant->property_id); @endphp
                                                                    @php $flat = App\Http\Controllers\UsersController::flatdetails($tenant->flat_id); @endphp
                                                                    @if(!empty($property) && !empty($flat))
									{{ strtoupper($property->name) }} - {{ strtoupper($flat->flatno) }}
								    @endif
                                                                </td>

                                                                <th>RENT FEE</th>
                                                                <td>
                                                                    @php $fee = App\Http\Controllers\UsersController::tenantfeedetails($tenant->id, $tenant->property_id, $tenant->flat_id); @endphp

                                                                    @if($fee && !empty($fee))
                                                                        {{ number_format($fee->fee) }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>STATUS</th>
                                                                <td>
                                                                    @if($tenant->status == 1)
                                                                        <span class="badge badge-soft-success"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> Active</span>
                                                                    @elseif($tenant->status == 2)
                                                                        <span class="badge badge-soft-warning"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> Rent Almost Due</span>
                                                                    @elseif($tenant->status == 3)
                                                                        <span class="badge badge-soft-danger"><i class="ri-checkbox-circle-line fs-10 align-middle"></i> Rent Due</span>
                                                                    @endif
                                                                </td>

                                                                <th>ACTION</th>
                                                                <td>
                                                                    <a class="btn btn-primary btn-sm" href="{{ url('user/newtenant', ['id' => Illuminate\Support\Facades\Crypt::encrypt($tenant->id)]) }}">Edit Tenant</a>                                                                                   
                                                                    <a class="btn btn-danger btn-sm" href="{{ url('user/deletetenant', ['id' => Illuminate\Support\Facades\Crypt::encrypt($tenant->id)]) }}" onclick="return confirm(' Are you sure you want to delete this tenant?');">Delete Tenant</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>DOCUMENTS</th>
                                                                <td colspan="3">
                                                                    @php $documents = App\Http\Controllers\UsersController::tenantdocuments($tenant->id); $countdoc = count($documents); @endphp
                                                                    
                                                                    @if($documents && count($documents) > 0)
                                                                        @foreach($documents as $document)
                                                                            <a href="{{ URL::asset('assets/documents/'.$document->file) }}" target="blank">{{ $document->file }}</a> 
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>RENT PAYMENT HISTORY</th>
                                                                <td colspan="3"></td>
                                                            </tr>
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