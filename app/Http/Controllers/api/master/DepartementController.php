<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Master\Departement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DepartementController extends Controller
{
    public function getTableName()
    {
        return "department";
    }

    public function getData(Request $request)
    {
        $query = Departement::query()
            ->select([
                'id',
                'department_name',
                'code',
                'created_at',
            ])
            ->whereNull('deleted');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'created_at',
                fn($row) => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                    : ''
            )
            ->filterColumn('department_name', fn($q, $k) => $q->where('department_name', 'ilike', "%{$k}%"))
            ->filterColumn('code', fn($q, $k) => $q->where('code', 'ilike', "%{$k}%"))
            ->orderColumn('department_name', 'department_name $1')
            ->orderColumn('created_at', 'created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {

            $data_insert = $data['id'] == '' ? new Departement() : Departement::find($data['id']);
            $data_insert->department_name = $data['department_name'];
            $data_insert->code = $data['id'] == '' ? generateColumnCode($this->getTableName(), 'code', 'DR') : $data['code'];
            $data_insert->remarks = $data['remarks'];
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
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {
            $menu = Departement::find($id);
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
}
