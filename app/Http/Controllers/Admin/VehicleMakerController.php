<?php

namespace App\Http\Controllers\Admin;

use App\Models\VehicleMaker;
use App\Services\UploaderService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleMakerController extends MainController
{
    public function __construct()
    {
        $this->moduleName = "vehicle_makers";
        $this->model = VehicleMaker::class;
    }

    public function index(): View
    {
        $dataType = $this->checkPermission('browse');

        return view("admin.$this->moduleName.index", compact("dataType"));
    }

    public function load()
    {
        $moduleName = $this->moduleName;

        $records = $this->model::select(['id', "name", "logo", "is_active", 'created_at']);

        return datatables()
            ->of($records)
            ->editColumn("is_active", function ($row) {
                if ($row->is_active) {
                    return "<span class='btn btn-sm btn-success'>Active</span>";
                }
                return "<span class='btn btn-sm btn-danger'>Inactive</span>";
            })
            ->editColumn("logo", function ($row) {
                $imageUrl = Storage::url($row->logo);
                return "<img src='$imageUrl' width='50px' />";
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
            ->rawColumns(["logo", "is_active", 'actions'])
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
            "logo" => 'required|image|mimes:jpeg,png,jpg|max:4000',
        ]);

        if ($request->hasFile('logo')) {
            $uploadFileService = new UploaderService();
            $folderName = "vehicle_makers";
            list($isUploaded, $uploadedImage) = $uploadFileService->uploadImage($request->file('logo'), $folderName);

            // If upload fails, return error before creating resource
            if (!$isUploaded) {
                return back()->withErrors(['image' => 'Image upload failed']);
            }

            $this->model::create([
                "name" => $request->name,
                "is_active" => $request->is_active,
                "logo" => $uploadedImage
            ]);
        }

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
            "logo" => 'mimes:jpeg,png,jpg|max:4000',
        ]);

        $updatedArray = ["name" => $request->name, "is_active" => $request->is_active];

        if ($request->hasFile('logo')) {
            $uploadFileService = new UploaderService();
            $folderName = "vehicle_makers";
            list($_, $uploadedImage) = $uploadFileService->uploadImage($request->file('logo'), $folderName);
            $updatedArray['logo'] = $uploadedImage;
        }

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
