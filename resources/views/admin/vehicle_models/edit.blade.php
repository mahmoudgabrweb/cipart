@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit FAQ</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST" action="{{ url("/admin/vehicle_models/$details->id") }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="name">Vehicle Model<span class="text-danger"> *</span></label>
                                <input type="text" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{$details->name}}"
                                       placeholder="Enter Vehicle Model" name="name" />
                                @error('question')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class= "col-md-12">
                                <label class="form-label" for="vehicle_maker_id">Vehicle Maker<span class="text-danger"> *</span></label>
                                <select name="vehicle_maker_id" class="form-control" id="vehicle_maker_id">
                                    <option value="" selected disabled>Choose Vehicle Maker</option>
                                    @foreach ($makers as $id => $name)
                                        <option value="{{$id}}" @selected($details->vehicle_maker_id == $id)>{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input type="hidden" value="0" name="is_active">
                                    <input class="form-check-input" value="1" type="checkbox" id="is_active"
                                           name="is_active" @if ($details->is_active) checked @endif />
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="submitButton" class="btn btn-primary">Save</button>
                            </div>
                        </form>                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
