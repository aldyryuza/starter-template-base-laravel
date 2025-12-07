<?php

namespace App\Http\Controllers\api\master;

use App\Http\Controllers\Controller;
use App\Models\Master\Roles;
use App\Models\Master\MasterAplikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class MasterAplikasiController extends Controller
{
    public function getTableName()
    {
        return "master_apps";
    }

    public function getData(Request $request)
    {
        $query = MasterAplikasi::query();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn(
                'created_at',
                fn($row) => $row->created_at
                    ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                    : ''
            )
            ->filterColumn('nama', fn($q, $k) => $q->where('nama', 'ilike', "%{$k}%"))
            ->filterColumn('keterangan', fn($q, $k) => $q->where('keterangan', 'ilike', "%{$k}%"))
            ->orderColumn('name', 'name $1')
            ->orderColumn('created_at', 'created_at $1')
            ->make(true);
    }


    public function submit(Request $request)
    {
        $data = $request->all();
        $result['is_valid'] = false;
        // dd($data);
        DB::beginTransaction();
        try {

            $data_insert = $data['id'] == '' ? new MasterAplikasi() : MasterAplikasi::find($data['id']);
            $data_insert->nama = $data['nama'];
            $data_insert->keterangan = $data['keterangan'];
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
            MasterAplikasi::find($id)->delete();
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
            MasterAplikasi::whereIn('id', $ids)->delete();
            // ->update([
            //     'deleted' => now(), // atau 'deleted_at' jika pakai softdelete
            // ]);

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
