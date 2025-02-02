@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit Cities</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url("/admin/countries/$details->id") }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="name">Country<span class="text-danger"> *</span></label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter Country Name" name="name"
                                    value="{{ $details->name }}" />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="display_name">Display Name<span class="text-danger"> *</span></label>
                                <input type="text" id="display_name"
                                    class="form-control @error('display_name') is-invalid @enderror"
                                    placeholder="Enter Display Name" name="display_name"
                                    value="{{ $details->display_name }}" />
                                @error('display_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="iso">ISO<span class="text-danger"> *</span></label>
                                <input type="text" id="iso"
                                    class="form-control @error('iso') is-invalid @enderror"
                                    value="{{ $details->iso }}"
                                    placeholder="Enter ISO" name="iso" />
                                @error('iso')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="iso3">ISO3<span class="text-danger"> *</span></label>
                                <input type="text" id="iso3"
                                    class="form-control @error('iso3') is-invalid @enderror"
                                    value="{{ $details->iso3 }}"
                                    placeholder="Enter ISO3" name="iso3" />
                                @error('iso3')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="phone_code">Phone Code +<span class="text-danger"> *</span></label>
                                <input type="text" id="phone_code"
                                    class="form-control @error('phone_code') is-invalid @enderror"
                                    value="{{ $details->phone_code }}"
                                    placeholder="Enter Phone Code" name="phone_code" />
                                @error('phone_code')
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
