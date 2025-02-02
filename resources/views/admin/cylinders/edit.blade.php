@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit Cylinders</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url("/admin/cylinders/$details->id") }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="count_of_cylinders">Count of Cylinders</label>
                                <input type="text" id="count_of_cylinders"
                                    class="form-control @error('count_of_cylinders') is-invalid @enderror"
                                    placeholder="Enter count_of_cylinders" name="count_of_cylinders"
                                    value="{{ $details->count_of_cylinders }}" />
                                @error('count_of_cylinders')
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
