<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Master\Roles;
use App\Models\Master\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getTableName()
    {
        return "users";
    }

    public function getData(Request $request)
    {
        $query = Users::query()
            ->select([
                'users.id',
                'users.name',
                'users.username',
                'users.created_at',

                'ug.roles_name',
            ])
            ->leftJoin('users_group as ug', 'ug.id', '=', 'users.user_group')
            ->whereNull('users.deleted');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'created_at',
                fn($row) => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                    : ''
            )
            ->filterColumn('users.name', fn($q, $k) => $q->where('users.name', 'ilike', "%{$k}%"))
            ->filterColumn('users.username', fn($q, $k) => $q->where('users.username', 'ilike', "%{$k}%"))
            ->filterColumn('roles_name', fn($q, $k) => $q->where('ug.roles_name', 'ilike', "%{$k}%"))
            ->orderColumn('users.name', 'users.name $1')
            ->orderColumn('created_at', 'users.created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        dd($data);
        DB::beginTransaction();
        try {

            $data_insert = $data['id'] == '' ? new Users() : Users::find($data['id']);
            $data_insert->name = $data['name'];
            $data_insert->username = $data['username'];
            $data_insert->password = Hash::make($data['password']);
            $data_insert->user_group = $data['user_group'];
            $data_insert->employee_code = $data['employee'];
            $data_insert->nik = $data['employee'];
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

    public function delete($id)
    {
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {
            $menu = Users::find($id);
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
        return view('web.users.modal.dataEmployee', $data);
    }
}
