<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\City;
use Illuminate\View\View;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Country;

class CityController extends MainController
{
    public function __construct()
    {
        $this->moduleName = 'cities';
        $this->model = City::class;
    }

    public function index(): View
    {
        $dataType = $this->checkPermission('browse');

        return view("admin.$this->moduleName.index", compact("dataType"));
    }

    public function load()
    {
        $moduleName = $this->moduleName;

        $records = $this->model::with('country')->select(['id', 'name', 'created_at', 'country_id']);

        return datatables()
        ->of($records)
        ->editColumn('created_at', function ($row) {
            return Carbon::createFromDate($row->created_at)->format("Y-m-d H:i");
        })
        ->addColumn('Country', function ($row) {
            return $row->country->name ?? 'N/A';
        })
        ->addColumn('actions', function ($row) use ($moduleName) {
            $buttons = " ";

            if(auth()->user()->hasPermission("edit_$moduleName"))
            {
                $buttons .="<a href='/admin/cities/$row->id/edit' class='btn btn-sm btn-warning'>Edit</a>";
            }

            if(auth()->user()->hasPermission("delete_$moduleName"))
            {
                $buttons .="<a href='javascript:void(0);' data-url='/admin/cities/$row->id' class='delete-record btn btn-sm btn-danger'>Delete</a>";
            }
            return $buttons;
        })
        ->rawColumns(['actions'])
        ->make(true);

    }

    public function create(): View
    {
        $dataType = $this->checkPermission('add');

        $countries = Country::pluck("name", "id")->toArray();

        return view("admin.$this->moduleName.create", compact("dataType", "countries"));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            "name" => 'required',
            "country_id" => 'required'
        ]);

        $this->model::create($validatedData);

        return redirect(route("voyager.$this->moduleName.index"))
            ->with([
                "message" => "New Record has been added successfully.",
                "alert-type" => 'success'
        ]);
    }

    public function edit(int $id): View
    {
        $dataType = $this->checkPermission('edit');

        $details = $this->model::find($id);

        $countries = Country::pluck("name", "id")->toArray();

        return view("admin.$this->moduleName.edit", compact("dataType", "details", "countries"));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            "name" => "required",
            "country_id" => "required"
        ]);

        $updatedArray = ["name" => $request->name, "country_id" => $request->country_id];

        $this->model::where('id', $id)->update($updatedArray);

        return redirect(route("voyager.$this->moduleName.index"))
        ->with([
            "message" => "Record has been updated successfully." ,
            "alert-type" => "success"
        ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->checkPermission('delete');

        $this->model::destroy($id);

        return redirect(route("voyager.$this->moduleName.index"))
            ->with([
                "message" => "Record has been deleted successfully.",
                'alert-type' => 'success',
            ]);
    }

}
