<?php

namespace App\Http\Controllers\api\template;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class TemplateMenuController extends Controller
{
    public function generateMenuWeb()
    {
        // $user_id = session('user_id');
        $user_id = Session::get('user_id');
        $dataMenu = DB::table('menu as m')
            ->distinct()
            ->select([
                'm.id',
                'm.name',
                'm.icon',
                'm.menu_alias',
                'm.path as url',
                'm.parent',
                'm.sort',
                'up.action',
            ])
            ->join('permission_users as up', 'up.menu', 'm.id')
            ->join('users_group as ug', 'ug.id', 'up.user_group')
            ->join('users as u', 'u.user_group', 'ug.id')
            ->where('u.id', $user_id)
            ->whereNull('up.deleted')
            ->orderBy('m.parent')
            ->orderBy('m.sort')
            ->get()->toArray();
        $dataFix = $dataMenu;
        return $this->buildMenu($dataFix);
    }

    public function buildMenu($rows, $parent = 0)
    {
        $result = "";
        foreach ($rows as $key => $row) {
            if ($row->parent == $parent) {
                $url = trim($row->url) == '' || trim($row->url) == '-' ? 'javascript: void(0);' : URL::to($row->url);
                $url_has_index = $row->url . '/index';
                $url_has_add = $row->url . '/add';
                $url_has_ubah = $row->url . '/ubah';
                $menu_togle = trim($row->url) == '-' || trim($row->url) == '' ? 'has-arrow' : '';
                $menu_active = request()->is($row->url) || request()->is($url_has_index) || request()->is($url_has_add) || request()->is($url_has_ubah) ? 'active' : '';
                $linkName = "<i class='" . $row->icon . "'></i>
                <span>" . $row->nama . "</span>";
                if ($row->parent != '') {
                    $linkName = $row->menu_alias == '' ? $row->nama : $row->menu_alias;
                }
                $result .= "<li data_id='" . $row->id . "' id='left-menu-" . $row->id . "' parent_menu='" . $row->parent . "' class='menu-item parent-menu-" . $row->parent . " " . $menu_active . "' >
                <a  href='" . $url . "' class='waves-effect " . $menu_togle . "'>
                    " . $linkName . "
                </a>
                ";
                $result .= "
                        <ul class='sub-menu' aria-expanded='false'>
                    ";
                if ($this->hasChild($rows, $row->id)) {
                    $result .= $this->buildMenu($rows, $row->id);
                }
                $result .= "</ul>";
                $result .= "</li>";
            }
        }
        return $result;
    }

    public function hasChild($rows, $id)
    {
        foreach ($rows as $key => $row) {
            if ($row->parent == $id)
                return true;
        }
        return false;
    }
}
