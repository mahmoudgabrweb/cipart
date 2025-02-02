<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CountryController extends MainController
{
    public function __construct()
    {
        $this->moduleName = "countries";
        $this->model = Country::class;
    }

    public function index(): View
    {
        $dataType = $this->checkPermission('browse');

        return view("admin.$this->moduleName.index", compact("dataType"));
    }

    public function load()
    {
        $moduleName = $this->moduleName;

        $records = $this->model::select(['id', 'name','display_name','created_at']);

        return datatables()
        ->of($records)
        ->editColumn('created_at', function ($row) {
            return Carbon::createFromDate($row->created_at)->format("Y-m-d H:i");
        })
        ->addColumn('actions', function ($row) use ($moduleName) {
            $buttons = " ";

            if(auth()->user()->hasPermission("edit_$moduleName"))
            {
                $buttons .="<a href='/admin/countries/$row->id/edit' class='btn btn-sm btn-warning'>Edit</a>";
            }

            if(auth()->user()->hasPermission("delete_$moduleName"))
            {
                $buttons .="<a href='javascript:void(0);' data-url='/admin/countries/$row->id' class='delete-record btn btn-sm btn-danger'>Delete</a>";
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
            "display_name" => "required",
            "iso3" => 'required',
            "iso" => 'required',
            "phone_code" => "required",
        ]);

        $this->model::create([
            "name" => $request->name,
            "display_name" => $request->display_name,
            "iso3" => $request->iso3,
            "iso" => $request->iso,
            "phone_code" => $request->phone_code,
        ]);

        return redirect(route("voyager.$this->moduleName.index"));
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
            "display_name" => "required",
            "iso3" => 'required',
            "iso" => 'required',
            "phone_code" => "required",
        ]);

        $updatedArray = [
            "name" => $request->name,
            "display_name" => $request->display_name,
            "iso3" => $request->iso3,
            "iso" => $request->iso,
            "phone_code" => $request->phone_code,
        ];

        $this->model::where('id', $id)->update($updatedArray);

        return redirect(route("voyager.$this->moduleName.index", $id));
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->checkPermission('delete');

        $this->model::destroy($id);

        return redirect(route("voyager.$this->moduleName.index"));
    }
}
