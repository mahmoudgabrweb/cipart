<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(): View
    {
        return view("roles.index");
    }

    public function create(): View
    {
        return view("roles.create");
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect(url("/admin/roles"))->with("message", "User has been added successfully.");
    }

    public function edit(int $id): View
    {
        return view("roles.edit");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return redirect(url("/admin/roles"))->with("message", "User has been updated successfully.");
    }

    public function delete(int $id): RedirectResponse
    {
        return redirect(url("/admin/roles"))->with("message", "User has been deleted successfully.");
    }
}
