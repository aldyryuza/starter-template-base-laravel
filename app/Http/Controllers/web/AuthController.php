<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

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
}
