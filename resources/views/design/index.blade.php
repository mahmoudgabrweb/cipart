@extends('voyager::master')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- DataTable with Buttons -->
        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table id="index-dt" class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Count of Cyliners</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js_scripts')
    @vite('resources/js/custom/cylinders.js')
@stop
