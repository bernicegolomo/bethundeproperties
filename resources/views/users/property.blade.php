@extends('layouts.userapp')

@section('content')

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row project-wrapper">
                        <div class="col-xxl-8">
                            <div class="row">
                                <div class="col-xs-12">
                                    @include('partials.errors')
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1 text-info">
                                                @if(isset($property))
                                                    UPDATE {{ strtoupper($property->name) }}
                                                @else
                                                    ADD NEW PROPERTY
                                                @endif
                                            </h4>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div class="live-preview">
                                                @if(isset($property))
                                                    <form action="{{url('updateproperty')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                                @else
                                                    <form action="{{url('createproperty')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                                @endif
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <label for="fullnameInput" class="form-label">Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" id="fullnameInput" @if(isset($property)) value="{{$property->name}}" @endif placeholder="Enter property name" required="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputEmail4" class="form-label">Location <span class="text-danger">*</span></label>
                                                        <input type="text" name="location" class="form-control" id="inputEmail4" @if(isset($property)) value="{{$property->location}}" @endif placeholder="Enter property location" required="">
                                                    </div>

                                                    @if(isset($property))
                                                    <input type="hidden" name="id" class="form-control" id="inputEmail4" @if(isset($property)) value="{{$property->id}}" @endif>
                                                    @endif

                                                    <div class="col-md-6">
                                                        <label for="inputPhone4" class="form-label">County <span class="text-danger">*</span></label>
                                                        <select id="ForminputState" class="form-select" name="country" data-choices data-choices-sorting="true">
                                                            @if(isset($property))
                                                            <option selected>Choose...</option>
                                                            @endif
                                                            @foreach($countrys as $country)
                                                            <option value="{{$country->id}}" @if(isset($property)) {{ $property->country == $country->id ? 'selected' : '' }} @endif> {{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputPhone4" class="form-label">State <span class="text-danger">*</span></label>
                                                        <select id="ForminputState" class="form-select" name="state" data-choices data-choices-sorting="true">
                                                            @if(isset($property))
                                                            <option selected>Choose...</option>
                                                            @endif
                                                            @foreach($states as $state)
                                                            <option value="{{$state->id}}" @if(isset($property)) {{ $property->state == $state->id ? 'selected' : '' }} @endif> {{$state->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    
                                                    
                                                    <div class="col-12">
                                                        <div class="text-end">
                                                            @if(isset($property))
                                                                <button type="submit" name="update" class="btn btn-primary"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Update Property</button>
                                                            @else
                                                                <button type="submit" class="btn btn-primary"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Save Property</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                
                                                </form>
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

