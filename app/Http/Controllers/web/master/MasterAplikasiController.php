<?php

namespace App\Http\Controllers\web\master;

use App\Exports\AplikasiExport;
use App\Http\Controllers\Controller;
use App\Models\Master\MasterAplikasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MasterAplikasiController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/master/aplikasi.js'),
        );
    }

    public function getTitleParent()
    {
        return "Aplikasi";
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
            'title' => 'Aplikasi',
        ];
        $view = view('web.aplikasi.index', $data);
        $put['title_content'] = 'Aplikasi';
        $put['title_top'] = 'Aplikasi';
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
            'title' => 'Aplikasi Add',
            'action' => 'add',
        ];
        $view = view('web.aplikasi.form.form', $data);
        $put['title_content'] = 'Aplikasi';
        $put['title_top'] = 'Aplikasi';
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
        $data['data'] = MasterAplikasi::find($id);
        $data['data_page'] = [
            'title' => 'Aplikasi Edit',
            'action' => 'edit',
        ];
        $view = view('web.aplikasi.form.form', $data);
        $put['title_content'] = 'MasterAplikasi';
        $put['title_top'] = 'MasterAplikasi';
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

        $data['data'] = MasterAplikasi::find($id);
        $data['data_page'] = [
            'title' => 'Aplikasi Detail',
            'action' => 'detail',
        ];
        $view = view('web.aplikasi.form.form', $data);
        $put['title_content'] = 'MasterAplikasi';
        $put['title_top'] = 'MasterAplikasi';
        $put['title_parent'] = $this->getTitleParent();
        $put['view_file'] = $view;
        $put['header_data'] = $this->getHeaderCss();
        return view('web.template.main', $put);
    }

    public function export(Request $request)
    {
        $format = $request->query('format', 'xlsx');
        if (!in_array($format, ['xlsx', 'csv'])) {
            return response('Format tidak valid.', 400);
        }

        $export = new AplikasiExport();
        $fileName = 'aplikasi_' . now()->format('Ymd_His') . '.' . $format;

        return Excel::download($export, $fileName);
    }
}
