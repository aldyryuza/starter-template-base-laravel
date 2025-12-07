<?php

namespace App\Http\Controllers\web\request_approve;

use App\Http\Controllers\Controller;
use App\Models\Master\UserGroup;
use App\Models\Master\Users;

class RequestApproveController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/request_approve/request.js'),
        );
    }

    public function getTitleParent()
    {
        return "My Request";
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
            'title' => 'Request',
        ];
        $view = view('web.request_approve.request.index', $data);
        $put['title_content'] = 'Request';
        $put['title_top'] = 'Request';
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
            'title' => 'Request Add',
            'action' => 'add',
        ];
        $data['data_user_group'] = UserGroup::whereNull('deleted')->get();
        $view = view('web.request_approve.request.form.form', $data);
        $put['title_content'] = 'Request';
        $put['title_top'] = 'Request';
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
        $view = view('web.request_approve.request.form.form', $data);
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
        $view = view('web.request_approve.request.form.form', $data);
        $put['title_content'] = 'Permission';
        $put['title_top'] = 'Permission';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
}
