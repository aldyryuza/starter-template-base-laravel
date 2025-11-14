<?php

namespace App\Http\Controllers\api\template;

use App\Http\Controllers\Controller;
use App\Models\Master\PermissionUsers;
use Illuminate\Support\Facades\Session;

class TemplateMenuController extends Controller
{
    public function generateMenuWeb()
    {
        // jika session tidak ada, kembali
        if (!Session::has('user_group')) {
            return "<li class='sidebar-item'><span class='hide-menu text-muted'>Tidak ada menu</span></li>";
        }
        $userGroup = Session::get('user_group')->id;

        // Ambil permission dan relasi MasterMenu
        $permissions = PermissionUsers::with('MasterMenu')
            ->where('user_group', $userGroup)
            // whereHas MasterMenu deleted null
            ->whereHas('MasterMenu', function ($query) {
                $query->whereNull('deleted');
            })
            ->whereNull('deleted')
            ->get();

        if ($permissions->isEmpty()) {
            return "<li class='sidebar-item'><span class='hide-menu text-muted'>Tidak ada menu</span></li>";
        }

        // Ambil hanya menu valid dan urutkan berdasarkan sort
        $menus = $permissions->pluck('MasterMenu')->filter()->sortBy('sort');

        // Bangun struktur menu rekursif mulai dari menu tanpa parent
        return $this->buildMenu($menus);
    }

    private function buildMenu($menus, $parentCode = '')
    {
        $html = '';

        foreach ($menus as $menu) {
            if (!is_object($menu)) continue;

            // Bandingkan parent berdasarkan menu_code
            if (($menu->parent ?? '') != $parentCode) continue;

            $hasChild = $this->hasChild($menus, $menu->menu_code);

            // Tentukan URL
            $url = (!empty($menu->path) && $menu->path != '-' && $menu->path != '/')
                ? url($menu->path)
                : 'javascript:void(0)';

            $icon = $menu->icon ?: 'bx bx-circle';
            $menuName = e($menu->name ?: '-');

            if ($hasChild) {
                // Menu dengan sub-menu
                $html .= "
                <li class='sidebar-item'>
                    <a class='sidebar-link has-arrow' href='javascript:void(0)' aria-expanded='false'>
                        <span class='d-flex'>
                            <i class='{$icon}'></i>
                        </span>
                        <span class='hide-menu'>{$menuName}</span>
                    </a>
                    <ul aria-expanded='false' class='collapse first-level'>
                        " . $this->buildMenu($menus, $menu->menu_code) . "
                    </ul>
                </li>";
            } else {
                // Submenu atau menu tanpa anak
                $html .= "
                <li class='sidebar-item'>
                    <a href='{$url}' class='sidebar-link'>
                        <div class='round-16 d-flex align-items-center justify-content-center'>
                            <i class='{$icon}'></i>
                        </div>
                        <span class='hide-menu'>{$menuName}</span>
                    </a>
                </li>";
            }
        }

        return $html;
    }

    private function hasChild($menus, $menuCode)
    {
        foreach ($menus as $menu) {
            if (!is_object($menu)) continue;
            if (($menu->parent ?? '') == $menuCode) {
                return true;
            }
        }
        return false;
    }
}
