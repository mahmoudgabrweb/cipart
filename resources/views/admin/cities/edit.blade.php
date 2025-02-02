@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit Cities</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url("/admin/cities/$details->id") }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="name">City<span class="text-danger"> *</span></label>
                                <input type="text" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter City Name" name="name"
                                    value="{{ $details->name}}" />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class= "col-md-12">
                                <label class="form-label" for="country_id">Country<span class="text-danger"> *</span></label>
                                <select name="country_id" class="form-control" id="country_id">
                                    @foreach ($countries as $id => $name)
                                        <option value="{{$id}}" @selected($details->country_id == $id)>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('country_id')
                                <div class="alert alert-danger">{{$message}}</div>
                            @enderror
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
