<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Models\DataType;

class MainController extends Controller
{
    protected string $moduleName;
    protected string $model;

    /**
     * @param string $action
     * @return DataType
     * @throws AuthorizationException
     */
    final protected function checkPermission(string $action): DataType
    {
        $dataType = Voyager::model('DataType')->where('slug', '=', $this->moduleName)->first();

        $permissionName = $action . "_" . $this->moduleName;

        if (!auth()->user()->hasPermission($permissionName)) {
            abort(401);
        }

        return $dataType;
    }
}
