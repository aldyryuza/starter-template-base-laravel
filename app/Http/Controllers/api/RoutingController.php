<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Master\Menu;
use App\Models\Master\RoutingHeader;
use App\Models\Master\RoutingPermission;
use App\Models\Master\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Facades\DataTables;

class RoutingController extends Controller
{
    public function getTableName()
    {
        return "routing_header";
    }

    public function getData(Request $request)
    {
        $query = RoutingHeader::query()
            ->select([
                'routing_header.id',
                'routing_header.remarks',
                'routing_header.created_at',
                'm.name as menu_name',
                'd.department_name as department_name',
                's.type as subsidiary',
            ])
            ->leftJoin('menu as m', 'routing_header.menu', '=', 'm.id')
            ->leftJoin('department as d', 'routing_header.departemen', '=', 'd.id')
            ->leftJoin('subsidiary as s', 'routing_header.subsidiary', '=', 's.id')
            ->whereNull('routing_header.deleted');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'created_at',
                fn($row) => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                    : ''
            )
            ->filterColumn('menu_name', fn($q, $k) => $q->where('m.name', 'ilike', "%{$k}%"))
            ->filterColumn('department_name', fn($q, $k) => $q->where('d.department_name', 'ilike', "%{$k}%"))
            ->filterColumn('subsidiary', fn($q, $k) => $q->where('s.type', 'ilike', "%{$k}%"))
            ->orderColumn('menu_name', 'm.name $1')
            ->orderColumn('subsidiary', 's.type $1')
            ->orderColumn('department_name', 'd.department_name $1')
            ->orderColumn('id', 'routing_header.id $1')
            ->orderColumn('created_at', 'routing_header.created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();

        $result = ['is_valid' => false];

        DB::beginTransaction();
        try {
            // Pastikan routing_list ada dan berupa array
            $routingList = $request->input('routing_list', []); // default array kosong
            if (!is_array($routingList)) {
                $routingList = [];
            }

            $data_insert = $data['id'] ? RoutingHeader::find($data['id']) : new RoutingHeader();

            if (!$data_insert) {
                throw new \Exception('Routing header tidak ditemukan');
            }

            $data_insert->menu = $data['menu'];
            $data_insert->remarks = $data['remarks'];
            $data_insert->subsidiary = $data['subsidiary'] ?? null;
            $data_insert->departemen = $data['department'] ?? null;
            $data_insert->save();

            // Bangun data permission
            $data_permission = [];
            foreach ($routingList as $value) {
                // Validasi minimal (opsional, tapi bagus)
                if (empty($value['routing_type_id']) || empty($value['user_id'])) {
                    continue; // skip row yang tidak valid
                }

                $data_permission[] = [
                    'routing_header' => $data_insert->id,
                    'menu' => $data_insert->menu,
                    'prev_state' => null, // atau logika prev_state jika Anda pakai chain
                    'state' => $value['routing_type_id'],
                    'users' => $value['user_id'],
                    'is_active' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Hapus lama, insert baru
            RoutingPermission::where('routing_header', $data_insert->id)->delete();

            if (!empty($data_permission)) {
                RoutingPermission::insert($data_permission);
            }

            DB::commit();
            $result['is_valid'] = true;
            $result['message'] = 'Routing berhasil disimpan';
        } catch (\Throwable $th) {
            DB::rollBack();
            $result['message'] = $th->getMessage();
            \Log::error('Routing submit error: ' . $th->getMessage());
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
            $menu = RoutingHeader::find($id)->delete();

            RoutingPermission::where('routing_header', $id)->delete();

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
