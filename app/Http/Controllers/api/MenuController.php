<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Master\Menu;
use App\Models\Master\Users;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function getTableName()
    {
        return "menu";
    }

    public function getData(Request $request)
    {
        $query = Menu::select(['id', 'name', 'icon', 'path', 'menu_code', 'created_at'])->whereNull('deleted')->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn() // <=== penting untuk DT_RowIndex
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
                // atau: ->translatedFormat('d F Y H:i') untuk "31 Desember 2024 09:15"
            })
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        DB::beginTransaction();
        try {
            //code...
            list($nik, $name) = explode('-', $data['nik']);
            $roles = $data['id'] == '' ? new Users() : Users::find($data['id']);
            $roles->user_group = $data['roles'];
            $roles->username = $data['username'];
            $roles->password = Hash::make($request->get('password'));
            $roles->nik = trim($nik);
            $roles->save();
            $user = User::create([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
            ]);
            $token = JWTAuth::fromUser($user);

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

    public function delete(Request $request)
    {
        $data = $request->all();
        return view('web.users.modal.confirmdelete', $data);
    }

    public function showDataKaryawan(Request $request)
    {
        $data = $request->all();
        return view('web.users.modal.datakaryawan', $data);
    }
}
