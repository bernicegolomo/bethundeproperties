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
                                            <h4 class="card-title mb-0 flex-grow-1 text-info">
                                                @if(isset($profile))
                                                    UPDATE {{ strtoupper($profile->name) }} PROFILE
                                                @else
                                                    ADD ADMINISTRATOR
                                                @endif
                                            </h4>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div class="live-preview">
                                                @if(isset($profile))
                                                    <form action="{{url('updateadmin')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                                @else
                                                    <form action="{{url('createadmin')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                                @endif
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <label for="fullnameInput" class="form-label">Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control" id="fullnameInput" @if(isset($profile)) value="{{$profile->name}}" @endif placeholder="Enter your name" required="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEmail4" class="form-label">Email <span class="text-danger">*</span></label>
                                                        <input type="email" name="email" class="form-control" id="inputEmail4" @if(isset($profile)) value="{{$profile->email}}" @endif placeholder="Enter your email" required="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputPhone4" class="form-label">Phone <span class="text-danger">*</span></label>
                                                        <input type="text" name="phone" class="form-control" id="inputPhone4" @if(isset($profile)) value="{{$profile->phone}}" @endif placeholder="Enter your phone" required="">
                                                    </div>
                                                    @if(!isset($profile))
                                                    <div class="col-md-6">
                                                        <label for="inputPassword4" class="form-label">Password <span class="text-danger">*</span></label>
                                                        <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required="">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputPassword4" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                                        <input type="password" name="password_confirmation" class="form-control" id="inputPassword4" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required="">
                                                    </div>
                                                    @else
                                                    <input type="hidden" name="id" class="form-control" id="fullnameInput" @if(isset($profile)) value="{{$profile->id}}" @endif required="">
                                                    @endif
                                                    <div class="col-12">
                                                        <label for="inputAddress" class="form-label">Address</label>
                                                        <input type="text" name="address" class="form-control" id="inputAddress" @if(isset($profile) && !empty($profile->address)) value="{{$profile->address}}" @endif placeholder="Address">
                                                    </div>
                                                    
                                                    
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="admin" type="checkbox" id="gridCheck" @if(isset($profile) && $profile->is_admin == 1) checked @endif value="1">
                                                            <label class="form-check-label" for="gridCheck">
                                                                Check if profile is super admin
                                                            </label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12">
                                                        <div class="text-end">
                                                            @if(isset($profile))
                                                                <button type="submit" name="update" class="btn btn-primary"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Update Profile</button>
                                                            @else
                                                                <button type="submit" class="btn btn-primary"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Save Profile</button>
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

@push('scripts')
    <script>

        $(document).ready(function(){
    
            var i = 1;
                var length;
            $("#add").click(function(){
                i++;
                $('#dynamic_field').append('<tr id="row'+i+'"><td><select name="type[]" class="form-control"><option value="" selected="" disabled="">-- Select Type --</option><option value="Qualification">Qualification</option><option value="Document">Document</option></select></td><td><input type="text" name="filetitle[]" placeholder="Enter Title" class="form-control"/></td><td><input type="file" name="file[]" class="form-control"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
            });
            
            $(document).on('click', '.btn_remove', function(){ 
                var button_id = $(this).attr("id");     
                $('#row'+button_id+'').remove();  
            });
                
        });
    </script>
@endpush
@stack('scripts')