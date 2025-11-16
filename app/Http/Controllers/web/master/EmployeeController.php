<?php

namespace App\Http\Controllers\web\master;

use App\Exports\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Models\Master\Departement;
use App\Models\Master\Employee;
use App\Models\Master\JobTitle;
use App\Models\Master\Subsidiary;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{

    public $akses_menu = [];


    public function getHeaderCss()
    {
        return array(
            'js-1' => asset('assets/js/controllers/master/employee.js'),
        );
    }

    public function getTitleParent()
    {
        return "Employee";
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
            'title' => 'Employee',
        ];
        $data['data_subsidiary'] = Subsidiary::whereNull('deleted')->get();
        $data['data_job_title'] = JobTitle::whereNull('deleted')->get();
        $data['data_department'] = Departement::whereNull('deleted')->get();
        $view = view('web.employee.index', $data);
        $put['title_content'] = 'Employee';
        $put['title_top'] = 'Employee';
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
            'title' => 'Employee Add',
            'action' => 'add',
        ];
        $data['data_subsidiary'] = Subsidiary::whereNull('deleted')->get();
        $data['data_job_title'] = JobTitle::whereNull('deleted')->get();
        $data['data_department'] = Departement::whereNull('deleted')->get();
        $view = view('web.employee.form.form', $data);
        $put['title_content'] = 'Employee';
        $put['title_top'] = 'Employee';
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
        $data['data'] = Employee::find($id);
        $data['data_page'] = [
            'title' => 'Employee Edit',
            'action' => 'edit',
        ];
        $data['data_subsidiary'] = Subsidiary::whereNull('deleted')->get();
        $data['data_job_title'] = JobTitle::whereNull('deleted')->get();
        $data['data_department'] = Departement::whereNull('deleted')->get();
        $view = view('web.employee.form.form', $data);
        $put['title_content'] = 'Employee';
        $put['title_top'] = 'Employee';
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

        $data['data'] = Employee::find($id);
        $data['data_page'] = [
            'title' => 'Employee Detail',
            'action' => 'detail',
        ];
        $data['data_subsidiary'] = Subsidiary::whereNull('deleted')->get();
        $data['data_job_title'] = JobTitle::whereNull('deleted')->get();
        $data['data_department'] = Departement::whereNull('deleted')->get();
        $view = view('web.employee.form.form', $data);
        $put['title_content'] = 'Employee';
        $put['title_top'] = 'Employee';
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

        $export = new EmployeeExport(
            $request->query('job_title'),
            $request->query('department'),
            $request->query('subsidiary')
        );

        $fileName = 'employee_' . now()->format('Ymd_His') . '.' . $format;

        return Excel::download($export, $fileName);
    }
}
