<?php

namespace App\Http\Controllers\web\master;

use App\Http\Controllers\Controller;
use App\Models\Master\Menu;
use App\Models\Master\Roles;
use App\Models\Master\UserGroup;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/master/roles.js'),
        );
    }

    public function getTitleParent()
    {
        return "Roles";
    }

    public function getTableName()
    {
        return "";
    }

    public function index()
    {
        $this->akses_menu = json_decode(session('akses_menu'));
        // dd($this->akses_menu);
        $data['akses'] = $this->akses_menu;

        $data['data'] = [];
        $data['data_page'] = [
            'title' => 'Roles',
        ];
        $view = view('web.roles.index', $data);
        $put['title_content'] = 'Roles';
        $put['title_top'] = 'Roles';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
    public function create()
    {
        $this->akses_menu = json_decode(session('akses_menu'));
        // dd($this->akses_menu);
        $data['akses'] = $this->akses_menu;
        $data['data'] = [];
        $data['data_page'] = [
            'title' => 'Roles Add',
            'action' => 'add',
        ];
        $view = view('web.roles.form.form', $data);
        $put['title_content'] = 'Roles';
        $put['title_top'] = 'Roles';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
    public function edit($id)
    {
        $this->akses_menu = json_decode(session('akses_menu'));
        // dd($this->akses_menu);
        $data['akses'] = $this->akses_menu;
        $data['data'] = Roles::find($id);
        $data['data_page'] = [
            'title' => 'Permission Edit',
            'action' => 'edit',
        ];
        $view = view('web.roles.form.form', $data);
        $put['title_content'] = 'Permission';
        $put['title_top'] = 'Permission';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
    public function detail($id)
    {
        $this->akses_menu = json_decode(session('akses_menu'));
        // dd($this->akses_menu);
        $data['akses'] = $this->akses_menu;

        $data['data'] = Roles::find($id);
        $data['data_page'] = [
            'title' => 'Permission Detail',
            'action' => 'detail',
        ];
        $view = view('web.roles.form.form', $data);
        $put['title_content'] = 'Permission';
        $put['title_top'] = 'Permission';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
}
