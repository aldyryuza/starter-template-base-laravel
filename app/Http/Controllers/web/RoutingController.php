<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Master\Departement;
use App\Models\Master\Menu;
use App\Models\Master\RoutingHeader;
use App\Models\Master\Subsidiary;
use Illuminate\Http\Request;

class RoutingController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/routing.js'),
        );
    }

    public function getTitleParent()
    {
        return "Routing";
    }

    public function getTableName()
    {
        return "routing_header";
    }

    public function index()
    {
        $this->akses_menu = json_decode(session('akses_menu'));
        // dd($this->akses_menu);
        $data['akses'] = $this->akses_menu;

        $data['data'] = [];
        $data['data_page'] = [
            'title' => 'Routing',
        ];
        $view = view('web.routing.index', $data);
        $put['title_content'] = 'Routing';
        $put['title_top'] = 'Routing';
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
            'title' => 'Routing Add',
            'action' => 'add',
        ];
        $data['data_menu'] = Menu::whereNull('deleted')->whereNotNull('routing')->get();
        $data['data_department'] = Departement::whereNull('deleted')->get();
        $data['data_subsidiary'] = Subsidiary::whereNull('deleted')->get();
        $view = view('web.routing.form.form', $data);
        $put['title_content'] = 'Routing';
        $put['title_top'] = 'Routing';
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
        $data['data'] = RoutingHeader::with('RoutingPermission.Users', 'RoutingPermission.Dictionary')->find($id);

        $data['data_page'] = [
            'title' => 'Routing Edit',
            'action' => 'edit',
        ];
        $data['data_menu'] = Menu::whereNull('deleted')->whereNotNull('routing')->get();
        $data['data_department'] = Departement::whereNull('deleted')->get();
        $data['data_subsidiary'] = Subsidiary::whereNull('deleted')->get();
        $view = view('web.routing.form.form', $data);
        $put['title_content'] = 'Routing';
        $put['title_top'] = 'Routing';
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

        $data['data'] = RoutingHeader::with('RoutingPermission')->find($id);
        $data['data_page'] = [
            'title' => 'Routing Detail',
            'action' => 'detail',
        ];
        $data['data_menu'] = Menu::whereNull('deleted')->whereNotNull('routing')->get();
        $data['data_department'] = Departement::whereNull('deleted')->get();
        $data['data_subsidiary'] = Subsidiary::whereNull('deleted')->get();
        $view = view('web.routing.form.form', $data);
        $put['title_content'] = 'Routing';
        $put['title_top'] = 'Routing';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }
}
