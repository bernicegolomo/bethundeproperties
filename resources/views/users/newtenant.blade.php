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
                                            <h4 class="card-title mb-0 flex-grow-1">
                                                @if(isset($tenant))
                                                    UPDATE {{ strtoupper($tenant->firstname .' '. $tenant->lastname) }}
                                                @else
                                                    ADD NEW TENANT
                                                @endif
                                            </h4>
                                            
                                        </div><!-- end card header -->

                                        <div class="card-body form-steps">
                                            @if(isset($tenant))
                                                <form action="{{url('updatetenant')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                            @else
                                                <form action="{{url('savetenant')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                            @endif
                                                @csrf
                                                <div class="step-arrow-nav mb-4">

                                                    <ul class="nav nav-pills custom-nav nav-justified" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link active" id="steparrow-personal-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-personal-info" type="button" role="tab" aria-controls="steparrow-personal-info" aria-selected="true">Personal Information</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="steparrow-guarantor-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-guarantor-info" type="button" role="tab" aria-controls="steparrow-guarantor-info" aria-selected="false">Guarantor's Information</button>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <button class="nav-link" id="steparrow-property-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-property-info" type="button" role="tab" aria-controls="steparrow-property-info" aria-selected="false">Property Information</button>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="tab-content">
                                                    <div class="tab-pane  show active" id="steparrow-personal-info" role="tabpanel" aria-labelledby="steparrow-personal-info-tab">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="steparrow-personal-info-first-input">First Name <span class="text-danger">*</span></label>
                                                                        <input type="text" name="fname" class="form-control" @if(isset($tenant)) value="{{$tenant->firstname}}" @endif id="steparrow-personam-info-first-input" placeholder="Enter First Name" required="">
                                                                    </div>
                                                                </div>

                                                                @if(isset($tenant))
                                                                <input type="hidden" name="tenantid" class="form-control" @if(isset($tenant)) value="{{$tenant->id}}" @endif required="">
                                                                @endif
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="steparrow-personal-info-last-input">Last Name <span class="text-danger">*</span></label>
                                                                        <input type="text" name="lname" class="form-control" @if(isset($tenant)) value="{{$tenant->lastname}}" @endif id="steparrow-personal-info-last-input" placeholder="Enter Last Name" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="steparrow-personal-info-phone-input">Phone Number <span class="text-danger">*</span></label>
                                                                        <input type="text" name="phone" class="form-control" @if(isset($tenant)) value="{{$tenant->phone}}" @endif id="steparrow-personal-info-phone-input" placeholder="Enter Phone Number" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="steparrow-personal-info-email-input">Email</label>
                                                                        <input type="email" name="email" class="form-control" @if(isset($tenant)) value="{{$tenant->email}}" @endif id="steparrow-personal-info-email-input" placeholder="Enter Email">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="steparrow-personal-info-occupation-input">Occupation <span class="text-danger">*</span></label>
                                                                        <input type="text" name="occupation" class="form-control" @if(isset($tenant)) value="{{$tenant->occupation}}" @endif id="steparrow-personal-info-occupation-input" placeholder="Enter Occupation" required="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="steparrow-personal-info-address-input">Previous Address </label>
                                                                        <textarea name="address" class="form-control" id="steparrow-personal-info-address-input" placeholder="Enter Previous Address">
                                                                            @if(isset($tenant)) {{$tenant->previous_address}} @endif
                                                                        </textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">                                                                    
                                                                    <div class="mb-3">
                                                                        <label for="formFile" class="form-label">Upload Documents</label>
                                                                        <input class="form-control" name="files[]" type="file" id="formFile">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="d-flex align-items-start gap-3 mt-4">
                                                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-guarantor-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                                                        </div>
                                                    </div>
                                                    <!-- end tab pane -->

                                                    <div class="tab-pane fade" id="steparrow-guarantor-info" role="tabpanel" aria-labelledby="steparrow-guarantor-info-tab">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="steparrow-guarantor-info-name-input">Guarantor's Name</label>
                                                                    <input type="text" name="gname" class="form-control" @if(isset($tenant)) value="{{$tenant->guarantor_name}}" @endif id="steparrow-guarantor-info-last-input" placeholder="Enter Guarantor's Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                        <label class="form-label" for="steparrow-guarantor-info-gphone-input">Guarantor's Phone Number </label>
                                                                        <input type="text" name="gphone" class="form-control" @if(isset($tenant)) value="{{$tenant->guarantor_phone}}" @endif id="steparrow-guarantor-info-gphone-input" placeholder="Enter Phone Number" >
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="des-info-description-input">Guarantor's  Address</label>
                                                                    <textarea name="gaddress" class="form-control" placeholder="Enter Address" id="des-info-description-input" rows="3">
                                                                        @if(isset($tenant)) {{$tenant->guarantor_address}} @endif
                                                                    </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-start gap-3 mt-4">
                                                            <button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-personal-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous</button>
                                                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-property-info-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                                                            <!--<button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-Next-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>-->
                                                        </div>
                                                    </div>
                                                    <!-- end tab pane -->

                                                    <div class="tab-pane fade" id="steparrow-property-info" role="tabpanel"  aria-labelledby="steparrow-property-info-tab">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Property <span class="text-danger">*</span></label>
                                                                    <select name="property" class="form-control" required id="propertyz">
                                                                        @if(!isset($tenant))
                                                                        <option value="" selected="" disabled="">-- Select Property --</option>
                                                                        @endif
                                                                        @if(isset($properties) && count($properties) > 0)
                                                                            @foreach($properties as $property)
                                                                                <option value="{{$property->id}}" @if(isset($tenant))  {{ $tenant->property_id == $property->id ? 'selected' : '' }}  @endif> {{strtoupper($property->name)}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Flat <span class="text-danger">*</span></label>
                                                                    <select name="flat" class="form-control" required id="flat">
                                                                        <option value="" selected="" disabled="">-- Select Flat --</option>
                                                                        @if(isset($flats) && count($flats) > 0)
                                                                            @foreach($flats as $flat)
                                                                                <option value="{{$flat->id}}" @if(isset($tenant))  {{ $tenant->flat_id == $flat->id ? 'selected' : '' }}  @endif> {{strtoupper($flat->flatno .' '. $flat->description)}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Rent Fee <span class="text-danger">*</span></label>
                                                                    <select name="rent" class="form-control" required id="rent">
                                                                        <option value="" selected="" disabled="">-- Select Fee --</option>
                                                                        @if(isset($rents) && count($rents) > 0 && isset($getfee))
                                                                            @foreach($rents as $rent)
                                                                                <option value="{{$rent->id}}" @if(isset($tenant))  {{ $getfee->fee == $rent->id ? 'selected' : '' }}  @endif> {{number_format($rent->fee)}}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="@if(isset($tenant)) col-lg-4 @else col-lg-6 @endif">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Start Date @if(!isset($tenant)) <span class="text-danger">*</span> @endif</label>
                                                                    <input type="date" name="date" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class=" @if(isset($tenant)) col-lg-4 @else col-lg-6 @endif">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Rent Duration @if(!isset($tenant)) <span class="text-danger">*</span> @endif</label>
                                                                    <select name="duration"  class="form-control" @if(!isset($tenant)) required="" @endif>
                                                                        <option value="" selected="" disabled="">-- Select Rent Duration --</option>
                                                                        <option value="1 year">1 Year</option>
                                                                        <option value="1 month">1 Month</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            @if(isset($tenant))
                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Vacate Date </label>
                                                                        <input type="date" name="vdate" class="form-control">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            
                                                        </div>

                                                        <div class="d-flex align-items-start gap-3 mt-4">
                                                            <button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-guarantor-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous</button>
                                                            <button type="submit" class="btn btn-success btn-label right ms-auto"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                                                @if(isset($tenant)) 
                                                                    Update
                                                                @else
                                                                    Submit
                                                                @endif
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <!-- end tab pane -->
                                                </div>
                                                <!-- end tab content -->
                                            </form>
                                            
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