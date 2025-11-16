<?php

namespace App\Http\Controllers\web\master;

use App\Http\Controllers\Controller;
use App\Models\Master\JobTitle;


class JobTitleController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/master/job_title.js'),
        );
    }

    public function getTitleParent()
    {
        return "Job Title";
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
            'title' => 'Job Title',
        ];
        $view = view('web.job_title.index', $data);
        $put['title_content'] = 'JobTitle';
        $put['title_top'] = 'JobTitle';
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
            'title' => 'Job Title Add',
            'action' => 'add',
        ];
        $view = view('web.job_title.form.form', $data);
        $put['title_content'] = 'Job Title';
        $put['title_top'] = 'Job Title';
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
        $data['data'] = JobTitle::find($id);
        $data['data_page'] = [
            'title' => 'Job Title Edit',
            'action' => 'edit',
        ];
        $view = view('web.job_title.form.form', $data);
        $put['title_content'] = 'Job Title';
        $put['title_top'] = 'Job Title';
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

        $data['data'] = JobTitle::find($id);
        $data['data_page'] = [
            'title' => 'Job Title Detail',
            'action' => 'detail',
        ];
        $view = view('web.job_title.form.form', $data);
        $put['title_content'] = 'Job Title';
        $put['title_top'] = 'Job Title';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
}
