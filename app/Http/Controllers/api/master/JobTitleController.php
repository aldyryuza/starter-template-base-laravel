<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Master\JobTitle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class JobTitleController extends Controller
{
    public function getTableName()
    {
        return "job_title";
    }

    public function getData(Request $request)
    {
        $query = JobTitle::query()
            ->select([
                'id',
                'job_name',
                'job_title_code',
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
            ->filterColumn('job_name', fn($q, $k) => $q->where('job_name', 'ilike', "%{$k}%"))
            ->filterColumn('job_title_code', fn($q, $k) => $q->where('job_title_code', 'ilike', "%{$k}%"))
            ->orderColumn('job_name', 'job_name $1')
            ->orderColumn('created_at', 'created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {

            $data_insert = $data['id'] == '' ? new JobTitle() : JobTitle::find($data['id']);
            $data_insert->job_name = $data['job_name'];
            $data_insert->job_title_code = $data['id'] == '' ? generateColumnCode($this->getTableName(), 'job_title_code', 'JOB') : $data['job_title_code'];
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
            $menu = JobTitle::find($id);
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
