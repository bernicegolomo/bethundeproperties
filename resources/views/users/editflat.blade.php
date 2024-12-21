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
                                                @if(isset($flats))
                                                    UPDATE {{ strtoupper($property->name) }} - {{ $flats->flatno}}
                                                @else
                                                    ADD NEW FLAT TO {{ strtoupper($property->name)}}
                                                @endif
                                            </h4>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <div class="live-preview">
                                                @if(isset($flats))
                                                    <form action="{{url('updateflat')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                                @else
                                                    <form action="{{url('createflat')}}" method="post"  enctype="multipart/form-data" class="row g-3">
                                                @endif
                                                    @csrf

                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Flat No.: <span class="text-danger">*</span></th>
                                                                    <th>Description </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="item_table">
                                                                <tr id="remove_table">
                                                                    <td>
                                                                        <input type="text" name="no" class="form-control" id="fullnameInput" @if(isset($flats)) value="{{$flats->flatno}}" @endif placeholder="Enter flat number" required="">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="description" class="form-control" id="inputEmail4" @if(isset($flats)) value="{{$flats->description}}" @endif placeholder="Enter flat description">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>         
                                                    

                                                    <input type="hidden" name="propertyid" class="form-control" id="inputEmail4" @if(isset($property)) value="{{$property->id}}" @endif>
                                                    @if(isset($flats))
                                                    <input type="hidden" name="flatid" class="form-control" id="inputEmail4" @if(isset($flats)) value="{{$flats->id}}" @endif>
                                                    @endif


                                                    
                                                    <div class="col-12">
                                                        
                                                        <div class="text-end">
                                                            @if(isset($flats))
                                                                <button type="submit" name="update" class="btn btn-primary"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Update Flat</button>
                                                            @else
                                                                <button type="submit" class="btn btn-primary"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Save Flat</button>
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
        function addItem() {
            let html = `
            <tr>
                <td>
                    <input type="text" name="no[]" class="form-control" id="fullnameInput" @if(isset($flat)) value="{{$flat->flatno}}" @endif placeholder="Enter flat number" required=""/>
                </td>
                <td>
                    <input type="text" name="description[]" class="form-control" id="inputEmail4" @if(isset($flat)) value="{{$flat->description}}" @endif placeholder="Enter flat description"/>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-item">
                        <i class="ri-delete-bin-fill"></i>
                    </button>
                </td>
            </tr>
        `;

            $('#item_table').append(html);

            // Add click handler to the remove button of the newly added item
            $('#item_table').find('.remove-item').last().click(removeItem);
        }

        function removeItem() {
            $(this).closest('tr').remove(); // Remove the parent tr
        }

        // Add click handler to the remove buttons of the existing items
        $('#item_table').find('.remove-item').click(removeItem);
    </script>

@endpush
@stack('scripts')