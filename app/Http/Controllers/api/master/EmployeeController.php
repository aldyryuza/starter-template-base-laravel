<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Master\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function getTableName()
    {
        return "employee";
    }

    public function getData(Request $request)
    {
        $query = Employee::query()
            ->select([
                'employee.id',
                'employee.name',
                'employee.contact',
                'employee.email',
                'employee.address',
                'employee.nik',
                'employee.employee_code',
                'employee.created_at',
                'employee.job_title',
                'employee.department',
                'employee.company',

                'jt.job_name as job_title',
                'd.department_name as department',
                's.type as company',
            ])
            ->leftJoin('job_title as jt', 'jt.id', '=', 'employee.job_title')
            ->leftJoin('department as d', 'd.id', '=', 'employee.department')
            ->leftJoin('subsidiary as s', 's.id', '=', 'employee.company')
            ->whereNull('employee.deleted');

        // === TERIMA FILTER DARI JAVASCRIPT ===
        if ($request->filled('subsidiary')) {
            $query->where('employee.company', $request->subsidiary);
        }

        if ($request->filled('department')) {
            $query->where('employee.department', $request->department);
        }

        if ($request->filled('job_title')) {
            $query->where('employee.job_title', $request->job_title);
        }
        // =====================================

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'created_at',
                fn($row) => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                    : ''
            )
            ->filterColumn('employee.name', fn($q, $k) => $q->where('employee.name', 'ilike', "%{$k}%"))
            ->filterColumn('employee.contact', fn($q, $k) => $q->where('employee.contact', 'ilike', "%{$k}%"))
            ->filterColumn('employee.email', fn($q, $k) => $q->where('employee.email', 'ilike', "%{$k}%"))
            ->filterColumn('employee.address', fn($q, $k) => $q->where('employee.address', 'ilike', "%{$k}%"))
            ->filterColumn('employee.nik', fn($q, $k) => $q->where('employee.nik', 'ilike', "%{$k}%"))
            ->filterColumn('employee.employee_code', fn($q, $k) => $q->where('employee.employee_code', 'ilike', "%{$k}%"))
            ->filterColumn('s.type', fn($q, $k) => $q->where('s.type', 'ilike', "%{$k}%"))
            ->filterColumn('d.department_name', fn($q, $k) => $q->where('d.department_name', 'ilike', "%{$k}%"))
            ->filterColumn('jt.job_name', fn($q, $k) => $q->where('jt.job_name', 'ilike', "%{$k}%"))
            ->orderColumn('employee.name', 'employee.name $1')
            ->orderColumn('employee.created_at', 'employee.created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {

            $data_insert = $data['id'] == '' ? new Employee() : Employee::find($data['id']);
            $data_insert->name = $data['name'];
            $data_insert->contact = $data['contact'];
            $data_insert->email = $data['email'];
            $data_insert->address = $data['address'];
            $data_insert->employee_code = $data['id'] == '' ? generateColumnCode($this->getTableName(), 'employee_code', 'EMP') : $data['employee_code'];
            $data_insert->nik = $data_insert->employee_code;
            $data_insert->company = $data['subsidiary'];
            $data_insert->job_title = $data['job_title'];
            $data_insert->department = $data['department'];
            $data_insert->save();

            DB::commit();
            $result['is_valid'] = true;
        } catch (\Throwable $th) {
            //throw $th;
            $result['message'] = $th->getMessage();
            DB::rollBack();
        }
        return response()->json($result);
    }


    public function getDetailData($id)
    {
        DB::enableQueryLog();
        $datadb = DB::table($this->getTableName() . ' as m')
            ->select([
                'm.*',
            ])->where('m.id', $id);
        $data = $datadb->first();
        $query = DB::getQueryLog();
        return response()->json($data);
    }

    public function delete($id)
    {
        dd($id);
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {
            $menu = Employee::find($id);
            $menu->deleted = date('Y-m-d H:i:s');
            $menu->save();

            DB::commit();
            $result['is_valid'] = true;
        } catch (\Throwable $th) {
            //throw $th;
            $result['message'] = $th->getMessage();
            DB::rollBack();
        }
        return response()->json($result);
    }
    public function delete_all(Request $request)
    {
        $ids = $request->input('ids', []); // langsung ambil array

        // Validasi: pastikan $ids adalah array dan tidak kosong
        if (!is_array($ids) || empty($ids)) {
            return response()->json([
                'is_valid' => false,
                'message' => 'Tidak ada data yang dipilih.'
            ], 400);
        }

        $result = ['is_valid' => false];

        DB::beginTransaction();
        try {
            // Soft delete: update deleted_at atau kolom custom
            Employee::whereIn('id', $ids)->update([
                'deleted' => now(), // atau 'deleted_at' jika pakai softdelete
            ]);

            DB::commit();
            $result['is_valid'] = true;
            $result['message'] = 'Data berhasil dihapus.';
        } catch (\Throwable $th) {
            DB::rollBack();
            $result['message'] = 'Gagal menghapus data: ' . $th->getMessage();
        }

        return response()->json($result);
    }
}
