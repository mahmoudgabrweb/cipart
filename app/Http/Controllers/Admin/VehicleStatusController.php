<?php

namespace App\Http\Controllers\Admin;

use App\Models\VehicleStatus;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VehicleStatusController extends MainController
{
    public function __construct()
    {
        $this->moduleName = "vehicle_statuses";
        $this->model = VehicleStatus::class;
    }

    public function index(): View
    {
        $dataType = $this->checkPermission('browse');

        return view("admin.$this->moduleName.index", compact("dataType"));
    }

    public function load()
    {
        $moduleName = $this->moduleName;

        $records = $this->model::select(['id', "name", "key", "is_active", 'created_at']);

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
            ->rawColumns(['is_active', 'actions'])
            ->make(true);
    }

    public function create(): View
    {
        $dataType = $this->checkPermission('add');

        return view("admin.$this->moduleName.create", compact('dataType'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => "required",
            "key" => "required",
        ]);

        $this->model::create([
            "name" => $request->name,
            "is_active" => $request->is_active,
            "key" => $request->key
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

        return view("admin.$this->moduleName.edit", compact('dataType', 'details'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            "name" => "required",
            "key" => "required",
        ]);

        $updatedArray = [
            "name" => $request->name,
            "is_active" => $request->is_active,
            "key" => $request->key
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
