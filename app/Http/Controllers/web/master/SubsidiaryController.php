<?php

namespace App\Http\Controllers\web\master;

use App\Http\Controllers\Controller;
use App\Models\Master\Subsidiary;

class SubsidiaryController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/master/subsidiary.js'),
        );
    }

    public function getTitleParent()
    {
        return "Subsidiary";
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
            'title' => 'Subsidiary',
        ];
        $view = view('web.subsidiary.index', $data);
        $put['title_content'] = 'Subsidiary';
        $put['title_top'] = 'Subsidiary';
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
            'title' => 'Subsidiary Add',
            'action' => 'add',
        ];
        $view = view('web.subsidiary.form.form', $data);
        $put['title_content'] = 'Subsidiary';
        $put['title_top'] = 'Subsidiary';
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
        $data['data'] = Subsidiary::find($id);
        $data['data_page'] = [
            'title' => 'Subsidiary Edit',
            'action' => 'edit',
        ];
        $view = view('web.subsidiary.form.form', $data);
        $put['title_content'] = 'Subsidiary';
        $put['title_top'] = 'Subsidiary';
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

        $data['data'] = Subsidiary::find($id);
        $data['data_page'] = [
            'title' => 'Subsidiary Detail',
            'action' => 'detail',
        ];
        $view = view('web.subsidiary.form.form', $data);
        $put['title_content'] = 'Subsidiary';
        $put['title_top'] = 'Subsidiary';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
}
