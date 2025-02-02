@extends('voyager::master')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Edit FAQ</h5>
                    <div class="card-body">
                        <form id="formValidationExamples" class="row g-6" method="POST"
                            action="{{ url("/admin/faqs/$details->id") }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <label class="form-label" for="question">Question</label>
                                <input type="text" id="question"
                                    class="form-control @error('question') is-invalid @enderror"
                                    placeholder="Enter question" name="question" value="{{ $details->question }}" />
                                @error('question')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="answer">Answer</label>
                                <input type="text" id="answer"
                                    class="form-control @error('answer') is-invalid @enderror" placeholder="Enter answer"
                                    name="answer" value="{{ $details->answer }}" />
                                @error('answer')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
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
                                <button type="submit" name="submitButton" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
