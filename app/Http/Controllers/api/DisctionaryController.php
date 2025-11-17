<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Master\Dictionary;

class DisctionaryController extends Controller
{
    public function getListApproval()
    {
        $data['is_valid'] = false;
        try {
            $data['data'] = Dictionary::where('context', 'RT_ACCESS')->get();
            $data['is_valid'] = true;
        } catch (\Throwable $th) {
            $data['message'] = $th->getMessage();
        }
        return response()->json($data);
    }
}
