<?php

use App\Http\Controllers\Admin\HeightController;
use App\Http\Controllers\Admin\LengthController;
use App\Http\Controllers\Admin\PackageHeightController;
use App\Http\Controllers\Admin\PackageLengthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WidthController;
use App\Http\Controllers\Admin\WeightController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\BodyTypeController;
use App\Http\Controllers\Admin\CylinderController;
use App\Http\Controllers\Admin\GearTypeController;
use App\Http\Controllers\Admin\PetrolTypeController;
use App\Http\Controllers\Admin\PackageWidthController;
use App\Http\Controllers\Admin\ReturnReasonController;
use App\Http\Controllers\Admin\VehicleMakerController;
use App\Http\Controllers\Admin\VehicleModelController;
use App\Http\Controllers\Admin\PackageWeightController;
use App\Http\Controllers\Admin\VehicleStatusController;
use App\Http\Controllers\Admin\PropulsionTypeController;
use App\Http\Controllers\Admin\ManufactureYearController;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Route::get("/cylinders/load", [CylinderController::class, "load"]);
    Route::get("/body_types/load", [BodyTypeController::class, "load"]);
    Route::get("/propulsion_types/load", [PropulsionTypeController::class, "load"]);
    Route::get("/gear_types/load", [GearTypeController::class, "load"]);
    Route::get("/petrol_types/load", [PetrolTypeController::class, "load"]);
    Route::get("/vehicle_statuses/load", [VehicleStatusController::class, "load"]);
    Route::get("/manufacture_years/load", [ManufactureYearController::class, "load"]);
    Route::get("/vehicle_makers/load", [VehicleMakerController::class, "load"]);
    Route::get("/return_reasons/load", [ReturnReasonController::class, "load"]);
    Route::get("/faqs/load", [FaqController::class, "load"]);
    Route::get("/cities/load", [CityController::class, "load"]);
    Route::get("/countries/load", [CountryController::class, "load"]);
    Route::get("/vehicle_models/load", [VehicleModelController::class, "load"]);
    Route::get("/package_weights/load", [PackageWeightController::class, "load"]);
    Route::get("/weights/load", [WeightController::class, "load"]);
    Route::get("/package_widths/load", [PackageWidthController::class, "load"]);
    Route::get("/widths/load", [WidthController::class, "load"]);
    Route::get("/package_heights/load", [PackageHeightController::class, "load"]);
    Route::get("/heights/load", [HeightController::class, "load"]);
    Route::get("/package_lengths/load", [PackageLengthController::class, "load"]);
    Route::get("/lengths/load", [LengthController::class, "load"]);

    Voyager::routes();

    Route::resource("users", UserController::class);
    Route::resource("roles", RoleController::class);
});
