<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Master\Menu;
use App\Models\Master\PermissionUsers;
use App\Models\Master\Users;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function getTableName()
    {
        return "permission_users";
    }

    public function getData(Request $request)
    {
        $query = PermissionUsers::query()
            ->select([
                'permission_users.id',
                'permission_users.menu',
                'permission_users.menu_code',
                'permission_users.user_group',
                'permission_users.action',
                'permission_users.created_at',
                'm.name as menu_name',
                'ug.roles_name as roles_name',
            ])
            ->leftJoin('menu as m', 'permission_users.menu', '=', 'm.id')
            ->leftJoin('users_group as ug', 'permission_users.user_group', '=', 'ug.id')
            ->whereNull('permission_users.deleted');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'created_at',
                fn($row) => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                    : ''
            )
            ->filterColumn('menu_name', fn($q, $k) => $q->where('m.name', 'ilike', "%{$k}%"))
            ->filterColumn('roles_name', fn($q, $k) => $q->where('ug.roles_name', 'ilike', "%{$k}%"))
            ->orderColumn('menu_name', 'm.name $1')
            ->orderColumn('roles_name', 'ug.roles_name $1')
            ->orderColumn('id', 'permission_users.id $1')
            ->orderColumn('menu_code', 'permission_users.menu_code $1')
            ->orderColumn('action', 'permission_users.action $1')
            ->orderColumn('created_at', 'permission_users.created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {
            // ambil menu code dari db
            $menu = Menu::find($data['menu']);
            $data['menu_code'] = $menu->menu_code;

            $data_insert = $data['id'] == '' ? new PermissionUsers() : PermissionUsers::find($data['id']);
            $data_insert->menu = $data['menu'];
            $data_insert->user_group = $data['user_group'];
            $data_insert->action = is_array($data['action']) ? implode(',',  $data['action']) : '';
            $data_insert->menu_code = $data['menu_code'] ?? null;
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

    public function confirmDelete(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {
            //code...
            $menu = Users::find($data['id']);
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
            $menu = PermissionUsers::find($id);
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

    public function showDataKaryawan(Request $request)
    {
        $data = $request->all();
        return view('web.users.modal.datakaryawan', $data);
    }
}
