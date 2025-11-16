<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Master\Menu;
use App\Models\Master\PermissionUsers;
use App\Models\Master\Roles;
use App\Models\Master\Users;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public function getTableName()
    {
        return "users_group";
    }

    public function getData(Request $request)
    {
        $query = Roles::query()
            ->select([
                'users_group.id',
                'users_group.roles_name',
                'users_group.roles_code',
                'users_group.created_at',
            ])
            ->whereNull('users_group.deleted');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'created_at',
                fn($row) => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                    : ''
            )
            ->filterColumn('users_group.roles_name', fn($q, $k) => $q->where('users_group.roles_name', 'ilike', "%{$k}%"))
            ->filterColumn('users_group.roles_code', fn($q, $k) => $q->where('users_group.roles_code', 'ilike', "%{$k}%"))
            ->orderColumn('users_group.roles_name', 'users_group.roles_name $1')
            ->orderColumn('created_at', 'users_group.created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {

            $data_insert = $data['id'] == '' ? new Roles() : Roles::find($data['id']);
            $data_insert->roles_name = $data['roles_name'];
            $data_insert->roles_code = $data['id'] == '' ? generateColumnCode('users_group', 'roles_code', 'ROLE') : $data['roles_code'];
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
            $menu = Roles::find($id);
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
