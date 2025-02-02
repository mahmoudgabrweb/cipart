<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

if (!function_exists("generateMenu")) {
    function generateMenu(): string
    {
        $allUserRolesIds = auth()->user()->roles_all()->pluck("id")->toArray();

        $userPermissionsIds = DB::table('permission_role')->whereIn("role_id", $allUserRolesIds)->pluck("permission_id")->toArray();

        $allBrowsePermissions = Permission::where("key", "LIKE", "browse%")->whereIn("id", $userPermissionsIds)->pluck("id")->toArray();

        $menuItems = MenuItem::with("children")->whereNull("parent_id")->orderBy("order", "ASC")->get();

        checkIfItemActive($menuItems);

        $menuHtml = "<ul class='menu-inner py-1'>";

        foreach ($menuItems as $menuItem) {
            $status = (isset($menuItem->active) && $menuItem->active) ? "active" : "";
            if (in_array($menuItem->permission_id, $allBrowsePermissions) || is_null($menuItem->permission_id)) {
                $isDropDownActiveClass = "";
                if ($menuItem->children->count() > 0) {
                    $children = $menuItem->children()->orderBy("order", "ASC")->get();
                    checkIfItemActive($children);
                    $activeChildrenCount = 0;
                    $childrenHtml  = "";
                    foreach ($children as $child) {
                        $childStatus = (isset($child->active) && $child->active) ? "active" : "";
                        if (in_array($child->permission_id, $allBrowsePermissions) || is_null($child->permission_id)) {
                            $childrenHtml .= generateOneMenuItemHtml($childStatus, $child);
                            $activeChildrenCount++;
                        }
                        if ($childStatus === "active") {
                            $isDropDownActiveClass = "open";
                        }
                    }

                    if ($activeChildrenCount === 0) continue;

                    $menuHtml .= "
                        <li class='menu-item $isDropDownActiveClass'>
                            <a href='javascript:void(0);' class='menu-link menu-toggle'>
                                <i class='menu-icon tf-icons ti ti-smart-home'></i>
                                <div data-i18n='Dashboards'>Dashboards</div>
                                <div class='badge bg-danger rounded-pill ms-auto'>5</div>
                            </a>
                            <ul class='menu-sub'>$childrenHtml</ul>
                        </li>
                    ";
                } else {
                    $menuHtml .= generateOneMenuItemHtml($status, $menuItem);
                }
            }
        }

        $menuHtml .= "</ul>";

        return $menuHtml;
    }
}

if (!function_exists("generateOneMenuItemHtml")) {
    function generateOneMenuItemHtml(string $status, Model $menuItem)
    {
        return "
            <li class='menu-item $status'>
                <a href='$menuItem->href' class='menu-link'>
                    <div data-i18n='$menuItem->title'>$menuItem->title</div>
                </a>
            </li>
        ";
    }
}

if (!function_exists("checkIfItemActive")) {
    function checkIfItemActive(Collection &$items): void
    {
        foreach ($items as &$item) {
            $item->href = $item->link(true);

            if ($item->href == url()->current() && $item->href != '') {
                // The current URL is exactly the URL of the menu-item
                $item->active = true;
            } elseif (Str::startsWith(url()->current(), Str::finish($item->href, '/'))) {
                // The current URL is "below" the menu-item URL. For example "admin/posts/1/edit" => "admin/posts"
                $item->active = true;
            }
            if (($item->href == url('') || $item->href == route('voyager.dashboard')) && $item->children->count() > 0) {
                // Exclude sub-menus
                $item->active = false;
            } elseif ($item->href == route('voyager.dashboard') && url()->current() != route('voyager.dashboard')) {
                // Exclude dashboard
                $item->active = false;
            }
        }
    }
}

if (!function_exists("checkIfOneMenuItemActive")) {
    function checkIfOneMenuItemActive($item): string
    {
        $item->href = $item->link(true);

        if ($item->href == url()->current() && $item->href != '') {
            // The current URL is exactly the URL of the menu-item
            return "active";
        } elseif (Str::startsWith(url()->current(), Str::finish($item->href, '/'))) {
            // The current URL is "below" the menu-item URL. For example "admin/posts/1/edit" => "admin/posts"
            return "active";
        }
        if (($item->href == url('') || $item->href == route('voyager.dashboard')) && $item->children->count() > 0) {
            // Exclude sub-menus
            return "";
        } elseif ($item->href == route('voyager.dashboard') && url()->current() != route('voyager.dashboard')) {
            // Exclude dashboard
            return "";
        }
        return "";
    }
}
