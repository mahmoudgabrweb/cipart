<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        return view("users.index");
    }

    public function create(): View
    {
        return view("users.create");
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect(url("/admin/users"))->with("message", "User has been added successfully.");
    }

    public function edit(int $id): View
    {
        return view("users.edit");
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        return redirect(url("/admin/users"))->with("message", "User has been updated successfully.");
    }

    public function delete(int $id): RedirectResponse
    {
        return redirect(url("/admin/users"))->with("message", "User has been deleted successfully.");
    }
}
