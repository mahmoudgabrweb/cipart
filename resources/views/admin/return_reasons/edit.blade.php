@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit Return Reason</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url("/admin/return_reasons/$details->id") }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="reason">Reason</label>
                                <input type="text" id="reason"
                                    class="form-control @error('reason') is-invalid @enderror" placeholder="Enter reason"
                                    name="reason" value="{{ $details->reason }}" />
                                @error('reason')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input type="hidden" value="0" name="is_active">
                                    <input class="form-check-input" value="1" type="checkbox" id="is_active"
                                        name="is_active" @checked('{{ $details->is_active }}') required />
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
