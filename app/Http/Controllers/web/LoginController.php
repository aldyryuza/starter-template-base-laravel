<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Master\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/login.js'),
        );
    }

    public function getTitleParent()
    {
        return "Login";
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
        return view('web.login.index', $put);
    }
}
