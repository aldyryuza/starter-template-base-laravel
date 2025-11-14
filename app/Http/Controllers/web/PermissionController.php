<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Master\Menu;
use App\Models\Master\PermissionUsers;
use App\Models\Master\UserGroup;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/permission.js'),
        );
    }

    public function getTitleParent()
    {
        return "Permission";
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
            'title' => 'Permission',
        ];
        $view = view('web.permission.index', $data);
        $put['title_content'] = 'Permission';
        $put['title_top'] = 'Permission';
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
        $data['data_menu'] = Menu::whereNull('deleted')->get();
        $data['data_user_group'] = UserGroup::whereNull('deleted')->get();
        $data['data_action'] = ['create', 'read', 'update', 'delete'];
        $data['data_page'] = [
            'title' => 'Permission Add',
            'action' => 'add',
        ];
        $view = view('web.permission.form.form', $data);
        $put['title_content'] = 'Permission';
        $put['title_top'] = 'Permission';
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
        $data['data'] = PermissionUsers::find($id);
        $data['data_page'] = [
            'title' => 'Permission Edit',
            'action' => 'edit',
        ];
        $data['data_menu'] = Menu::whereNull('deleted')->get();
        $data['data_user_group'] = UserGroup::whereNull('deleted')->get();
        $data['data_action'] = ['create', 'read', 'update', 'delete'];
        $view = view('web.permission.form.form', $data);
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

        $data['data'] = PermissionUsers::find($id);
        $data['data_page'] = [
            'title' => 'Permission Detail',
            'action' => 'detail',
        ];
        $data['data_menu'] = Menu::whereNull('deleted')->get();
        $data['data_user_group'] = UserGroup::whereNull('deleted')->get();
        $data['data_action'] = ['create', 'read', 'update', 'delete'];
        $view = view('web.permission.form.form', $data);
        $put['title_content'] = 'Permission';
        $put['title_top'] = 'Permission';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
}
