@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Add New Manufacture Year</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url('/admin/manufacture_years') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="year">Year</label>
                                <input type="number" id="year"
                                    class="form-control @error('year') is-invalid @enderror" placeholder="Enter year"
                                    name="year" value="{{ @old('year') }}" />
                                @error('year')
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
