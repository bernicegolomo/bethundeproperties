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
                                            <h4 class="card-title mb-0 flex-grow-1">FEES FOR {{strtoupper($property->name)}} - {{strtoupper($flats->flatno)}} {{strtoupper($flats->description)}}</h4>
                                            @if($user->is_admin == 1)
                                            <div class="flex-shrink-0">
                                                <div class="form-check form-switch form-switch-right form-switch-md">
                                                    <a data-bs-toggle="modal" data-bs-target=".addModal" class="btn btn-success btn-label right rounded-pill"><i class="ri-add-circle-line label-icon align-middle rounded-pill fs-16 ms-2"></i> Add Fees</a>

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
                                                                <th scope="col" class="text-warp">AMOUNT</th>
                                                                <th scope="col" class="text-warp">EFFECTIVE DATE</th>
                                                                <th scope="col" class="text-warp">STATUS</th>
                                                                <th scope="col" class="text-warp">ACTION</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($fees) && count($fees) > 0)
                                                                @php $x=0; @endphp
                                                                @foreach($fees as $fee)  
                                                                  @php $x++; @endphp
                                                                    <tr>
                                                                        <td><span class="fw-medium text-primary"># {{ $x }}</span></td>
                                                                        <td>{{ ($fee->fee) }}</td>  
                                                                        <td class="text-wrap">{{ $fee->effective_date }}</td>   
                                                                        <td>                                                                            
                                                                            @if($fee->status == 1)
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
                                                                                    <li>
                                                                                        @if($fee->status == 1)
                                                                                        <a class="dropdown-item" href="{{ url('user/deactivatefee', ['id' => Illuminate\Support\Facades\Crypt::encrypt($fee->id)]) }}">De-Activate Fee</a>
                                                                                        @else
                                                                                        <a class="dropdown-item" href="{{ url('user/activatefee', ['id' => Illuminate\Support\Facades\Crypt::encrypt($fee->id)]) }}">Activate Fee</a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li><a class="dropdown-item" href="{{ url('user/deletefee', ['id' => Illuminate\Support\Facades\Crypt::encrypt($fee->id)]) }}" onclick="return confirm(' Are you sure you want to delete this fee?');">Delete Fee</a></li>
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


                <!-- Add Fees Modal -->
                <div class="modal fade addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Add Fees</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{url('add-fees')}}" class="outer-repeater" method="POST"  enctype="multipart/form-data">
                                @csrf
                              <div class="modal-body">
                              
                                
                                <div data-repeater-list="outer-group" class="outer">
                                  <div data-repeater-item class="outer">
                                                    
                                    <div class="inner-repeater mb-4">
                                      <div data-repeater-list="inner-group" class="inner mb-3">
                                        <div data-repeater-item class="inner mb-3 row">
                                          <div class="col-md-12 col-12">
                                            <label> Flat Fees <span class="text-danger">*</span></label>
                                            <input type="text" class="inner form-control" placeholder="Enter amount" name="amount" onkeypress="return onlyNumberKey(event)" maxlength="10"  required/>
                                          </div>  
                                          <div class="col-md-12 col-12 mt-4">
                                            <label> Effective Date <br/><span class="text-warning"><em>If you leave blank, current date will be set as effective date</em></span></label>
                                            <input type="date" class="inner form-control" placeholder="Effective Date" name="date"/>
                                          </div>              
                                        </div>
                                      </div>
                                    </div>
        
                                    <input type="hidden" class="inner form-control" name="propertyid" value="{{$propertyid}}"/>
                                    <input type="hidden" class="inner form-control" name="flatid" value="{{$flatid}}"/>     
                                    
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
                <!-- end add fees modal -->


 
@endsection