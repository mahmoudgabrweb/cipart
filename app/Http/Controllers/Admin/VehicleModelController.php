<?php

namespace App\Http\Controllers\Admin;

use App\Models\VehicleMaker;
use Carbon\Carbon;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class VehicleModelController extends MainController
{
    public function __construct()
    {
        $this->moduleName = "vehicle_models";
        $this->model = VehicleModel::class;
    }

    public function index(): View
    {
        $dataType = $this->checkPermission('browse');

        return view("admin.$this->moduleName.index", compact("dataType"));
    }

    public function load()
    {
        $moduleName = $this->moduleName;

        $records = $this->model::with('maker')->select(['id', "name", 'is_active', 'vehicle_maker_id', 'created_at']);

        return datatables()
            ->of($records)
            ->editColumn("is_active", function ($row) {
                if ($row->is_active) {
                    return "<span class='btn btn-sm btn-success'>Active</span>";
                }
                return "<span class='btn btn-sm btn-danger'>Inactive</span>";
            })
            ->editColumn("created_at", function ($row) {
                return Carbon::createFromDate($row->created_at)->format("Y-m-d H:i");
            })
             ->addColumn('maker', function ($row) {
                 return $row->maker->name ?? "N/A";
             })
            ->addColumn('actions', function ($row) use ($moduleName) {
                $buttons = "";
                if (auth()->user()->hasPermission("edit_$moduleName")) {
                    $buttons .= "<a href='/admin/$moduleName/$row->id/edit' class='btn btn-sm btn-warning'>Edit</a>";
                }
                if (auth()->user()->hasPermission("delete_$moduleName")) {
                    $buttons .= "<a href='javascript:void(0);' data-url='/admin/$moduleName/$row->id' class='delete-record btn btn-sm btn-danger'>Delete</a>";
                }
                return $buttons;
            })
            ->rawColumns(["is_active", 'actions'])
            ->make(true);
    }


    public function create(): View
    {
        $dataType = $this->checkPermission('add');

        $makers = VehicleMaker::pluck('name', 'id');

        return view("admin.$this->moduleName.create", compact('dataType', 'makers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => "required",
            "vehicle_maker_id" => "required",
        ]);

        $this->model::create([
                "name" => $request->name,
                "vehicle_maker_id" => $request->vehicle_maker_id,
                "is_active" => $request->is_active,
        ]);


        return redirect(route("voyager.$this->moduleName.index"))
            ->with([
                "message" => "New Record has been added successfully.",
                'alert-type' => 'success',
            ]);
    }

    public function edit(int $id): View
    {
        $dataType = $this->checkPermission('edit');

        $details = $this->model::find($id);

        $makers = VehicleMaker::pluck('name', 'id');

        return view("admin.$this->moduleName.edit", compact('dataType', 'details', 'makers'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            "name" => "required",
            "vehicle_maker_id" => "required",
        ]);

        $updatedArray = [
            "name" => $request->name,
             "vehicle_maker_id" => $request->vehicle_maker_id,
              "is_active" => $request->is_active
        ];

        $this->model::where('id', $id)->update($updatedArray);

        return redirect(route("voyager.$this->moduleName.index"))
            ->with([
                "message" => "Record has been updated successfully.",
                'alert-type' => 'success',
            ]);
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->checkPermission('delete');

        $this->model::destroy($id);

        return redirect(route("voyager.$this->moduleName.index"));
    }
}
