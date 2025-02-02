<?php

namespace App\Http\Controllers\Admin;

use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CurrencyController extends MainController
{
    public function __construct()
    {
        $this->moduleName = "currencies";
        $this->model = Currency::class;
    }

    public function index(): View
    {
        $dataType = $this->checkPermission('browse');

        return view("admin.$this->moduleName.index", compact("dataType"));
    }

    public function load()
    {
        $moduleName = $this->moduleName;

        $records = $this->model::select(['id', "name", "code", 'created_at']);

        return datatables()
            ->of($records)
            ->editColumn("created_at", function ($row) {
                return Carbon::createFromDate($row->created_at)->format("Y-m-d H:i");
            })
            ->addColumn('actions', function ($row) use ($moduleName) {
                $buttons = "";
                if (auth()->user()->hasPermission("edit_$moduleName")) {
                    $buttons .= "<a href='/admin/currencies/$row->id/edit' class='btn btn-sm btn-warning'>Edit</a>";
                }
                if (auth()->user()->hasPermission("delete_$moduleName")) {
                    $buttons .= "<a href='javascript:void(0);' data-url='/admin/currencies/$row->id' class='delete-record btn btn-sm btn-danger'>Delete</a>";
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
            "name" => "required",
            "code" => "required",
        ]);

        $this->model::create([
            "name" => $request->name,
            "code" => $request->code
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
            "code" => "required",
        ]);

        $updatedArray = ["name" => $request->name, "code" => $request->code];

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

        return redirect(route("voyager.$this->moduleName.index"))
            ->with([
                "message" => "Record has been deleted successfully.",
                'alert-type' => 'success',
            ]);
    }
}
