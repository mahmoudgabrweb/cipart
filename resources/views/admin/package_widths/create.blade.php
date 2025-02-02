@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Add New Package Width</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST" action="{{ url('/admin/package_widths') }}">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="name">Package Width<span class="text-danger"> *</span></label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Package Width" name="name" />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" name="submitButton" class="btn btn-primary">Save</button>
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
