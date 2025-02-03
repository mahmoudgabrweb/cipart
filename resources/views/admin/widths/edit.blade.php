@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit Width</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url("/admin/widths/$details->id") }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="name_ar">Arabic Width<span class="text-danger"> *</span></label>
                                <input type="text" id="name_ar"
                                       class="form-control @error('name_ar') is-invalid @enderror"
                                       placeholder="Enter Name" name="name_ar"
                                       value="{{ $details->name_ar}}" />
                                @error('name_ar')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="name_en">English Width</label>
                                <input type="text" id="name_en"
                                       class="form-control @error('name_en') is-invalid @enderror"
                                       placeholder="Enter Name" name="name_en"
                                       value="{{ $details->name_en}}" />
                                @error('name_en')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="key">Key<span class="text-danger"> *</span></label>
                                <input type="text" id="key"
                                       class="form-control @error('key') is-invalid @enderror"
                                       placeholder="Enter Key" name="key"
                                       value="{{ $details->key}}" />
                                @error('key')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" name="submitButton" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /FormValidation -->
        </div>
    </div>
@stop
