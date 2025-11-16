<?php

namespace App\Http\Controllers\web\master;

use App\Http\Controllers\Controller;
use App\Models\Master\UserGroup;
use App\Models\Master\Users;

class UsersController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/master/users.js'),
        );
    }

    public function getTitleParent()
    {
        return "Users";
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
            'title' => 'Users',
        ];
        $view = view('web.users.index', $data);
        $put['title_content'] = 'Users';
        $put['title_top'] = 'Users';
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
            'title' => 'Users Add',
            'action' => 'add',
        ];
        $data['data_user_group'] = UserGroup::whereNull('deleted')->get();
        $view = view('web.users.form.form', $data);
        $put['title_content'] = 'Users';
        $put['title_top'] = 'Users';
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
        $data['data'] = Users::find($id);
        $data['data_page'] = [
            'title' => 'Permission Edit',
            'action' => 'edit',
        ];
        $data['data_user_group'] = UserGroup::whereNull('deleted')->get();
        $view = view('web.users.form.form', $data);
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

        $data['data'] = Users::find($id);
        $data['data_page'] = [
            'title' => 'Permission Detail',
            'action' => 'detail',
        ];
        $data['data_user_group'] = UserGroup::whereNull('deleted')->get();
        $view = view('web.users.form.form', $data);
        $put['title_content'] = 'Permission';
        $put['title_top'] = 'Permission';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
}
