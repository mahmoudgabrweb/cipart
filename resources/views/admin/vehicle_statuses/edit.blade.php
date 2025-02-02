@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit Vehicle Status</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url("/admin/vehicle_statuses/$details->id") }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter name"
                                    name="name" value="{{ $details->name }}" />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="key">Key</label>
                                <input type="text" id="key" class="form-control @error('key') is-invalid @enderror"
                                    placeholder="Enter key" name="key" value="{{ $details->key }}" />
                                @error('key')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input type="hidden" value="0" name="is_active">
                                    <input class="form-check-input" value="1" type="checkbox" id="is_active"
                                        name="is_active" @checked('{{ $details->is_active }}') />
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
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
