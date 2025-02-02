@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Add New Gear Type</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST" action="{{ url('/admin/gear_types') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter name"
                                    name="name" value="{{ @old('name') }}" />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /FormValidation -->
        </div>
    </div>
@stop

@section('js_scripts')

@stop
