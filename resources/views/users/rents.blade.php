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
                                            <h4 class="card-title mb-0 flex-grow-1"> RENTS </h4>
                                            @if($user->is_admin == 1)
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch form-switch-right form-switch-md">
                                                    <a  data-bs-toggle="modal" data-bs-target=".payModal"  class="btn btn-success btn-label right rounded-pill" ><i class="ri-add-circle-line label-icon align-middle rounded-pill fs-16 ms-2"></i> Record Rent Payment</a>
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
                                                                <th scope="col" class="text-warp">TENANT</th>
                                                                <th scope="col" class="text-warp">RENT YEAR</th>
                                                                <th scope="col" class="text-warp">RENT FEE</th>
                                                                <th scope="col" class="text-warp">AMOUNT PAID</th>
                                                                <th scope="col" class="text-warp">BALANCE</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($rents) && count($rents) > 0)
                                                                @php $x=0; @endphp
                                                                @foreach($rents as $rent)
                                                                  @php $x++; @endphp
                                                                    <tr>
                                                                        <td><span class="fw-medium text-primary"># {{ $x }}</span></td>
                                                                        <td>
                                                                            @php $tenant = App\Http\Controllers\UsersController::tenantdetails($rent->tenant_id); @endphp
                                                                            {{ strtoupper($tenant->firstname  .' '. $tenant->lastname) }}
                                                                        </td>  
                                                                        <td>{{ $rent->start_year .' - '. $rent->end_year  }}</td>  
                                                                        <td>{{ number_format($rent->fee) }}</td>  
                                                                        <td></td>
                                                                        <td>
                                                                            @php $balance = App\Http\Controllers\UsersController::rentpaymentbalance($rent->id); @endphp
                                                                             {{ number_format($balance) }}
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

            <!-- Record Rent Modal -->
            <div class="modal fade payModal"  id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="payModalLabel">Record Rent Payment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{url('record-payment')}}" class="outer-repeater" method="POST"  enctype="multipart/form-data">
                                @csrf
                              <div class="modal-body">
                              
                                
                                <div data-repeater-list="outer-group" class="outer">
                                  <div data-repeater-item class="outer">
                                                    
                                    <div class="inner-repeater mb-4">
                                      <div data-repeater-list="inner-group" class="inner mb-3">
                                        <div data-repeater-item class="inner mb-3 row">
                                          <div class="col-md-12 col-12">
                                            <label> Search Tenant Rent <span class="text-danger">*</span></label>
                                            <select class="js-example-basic-single" id="select2insidemodal" name="tenantrent" required="">
                                                @if(isset($rents) && count($rents) > 0)
                                                     @foreach($rents as $rent)
                                                        @php $tenant = App\Http\Controllers\UsersController::tenantdetails($rent->tenant_id); @endphp
                                                        <option value="{{ $rent->id }}"> {{ strtoupper($tenant->firstname  .' '. $tenant->lastname) .' : '. $rent->start_year .' - '. $rent->end_year}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                          </div>  
                                          <div class="col-md-12 col-12 mt-4">
                                            <label> Amount <span class="text-danger">*</span></label>
                                            <input type="text" class="inner form-control" placeholder="Enter Amount" name="amount"  onkeypress="return onlyNumberKey(event)" maxlength="10"  />
                                          </div>                                           
                                          <div class="col-md-12 col-12 mt-4">
                                            <label> Payment Date <br/><span class="text-warning"><em>If you leave blank, current date will be set as effective date</em></span></label>
                                            <input type="date" class="inner form-control" placeholder="Effective Date" name="date"/>
                                          </div>                      
                                        </div>
                                      </div>
                                    </div>
       
                                    
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="bx bx-check-double font-size-16 align-middle"></i> Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-no-entry font-size-16 align-middle"></i> Close</button>
                              </div>
                              
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end record rent modal -->

 
@endsection