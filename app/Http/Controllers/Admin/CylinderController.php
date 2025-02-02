<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cylinder;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CylinderController extends MainController
{
    public function __construct()
    {
        $this->moduleName = "cylinders";
        $this->model = Cylinder::class;
    }

    public function index(): View
    {
        $dataType = $this->checkPermission('browse');

        return view("admin.$this->moduleName.index", compact("dataType"));
    }

    public function load()
    {
        $moduleName = $this->moduleName;

        $records = $this->model::select(['id', 'count_of_cylinders', 'created_at']);

        return datatables()
            ->of($records)
            ->editColumn("created_at", function ($row) {
                return Carbon::createFromDate($row->created_at)->format("Y-m-d H:i");
            })
            ->addColumn('actions', function ($row) use ($moduleName) {
                $buttons = "";
                if (auth()->user()->hasPermission("edit_$moduleName")) {
                    $buttons .= "<a href='/admin/cylinders/$row->id/edit' class='btn btn-sm btn-warning'>Edit</a>";
                }
                if (auth()->user()->hasPermission("delete_$moduleName")) {
                    $buttons .= "<a href='javascript:void(0);' data-url='/admin/cylinders/$row->id' class='delete-record btn btn-sm btn-danger'>Delete</a>";
                }
                return $buttons;
            })
            ->rawColumns(['actions'])
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
            "count_of_cylinders" => "required",
        ]);

        $this->model::create([
            "count_of_cylinders" => $request->count_of_cylinders,
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
            "count_of_cylinders" => "required",
        ]);

        $updatedArray = ["count_of_cylinders" => $request->count_of_cylinders];

        $this->model::where('id', $id)->update($updatedArray);

        return redirect(route("voyager.$this->moduleName.index"))
            ->with([
                "message" => "Record has been updated successfully.",
                'alert-type' => 'success',
            ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->checkPermission('delete');

        $this->model::destroy($id);

        return response()->json(["status" => true, "message" => "Record has been deleted successfully.", "data" => []]);
    }
}
