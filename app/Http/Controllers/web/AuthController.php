<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/auth.js'),
        );
    }

    public function getTitleParent()
    {
        return "Auth";
    }

    public function getTableName()
    {
        return "";
    }

    public function index()
    {
        $put['title_content'] = 'Login';
        $put['title_top'] = 'Login';
        $put['title_parent'] = $this->getTitleParent();
        $put['header_data'] = $this->getHeaderCss();
        return view('web.auth.login', $put);
    }
    public function register()
    {
        $put['title_content'] = 'Register';
        $put['title_top'] = 'Register';
        $put['title_parent'] = $this->getTitleParent();
        $put['header_data'] = $this->getHeaderCss();
        return view('web.auth.register', $put);
    }

    public function save_session(Request $request)
    {
        $data = $request->all();
        // dd(json_decode($data['user']));
        $data['user'] = json_decode($data['user']);

        // seesion put
        Session::put('id', $data['user']->id);
        Session::put('nik', $data['user']->nik);
        Session::put('name', $data['user']->name);
        Session::put('username', $data['user']->username);
        Session::put('user_group', $data['user']->user_group);
        Session::put('employee_code', $data['user']->employee_code);

        $data['is_valid'] = true;
        return response()->json($data);
    }
}
