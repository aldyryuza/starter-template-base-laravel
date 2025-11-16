<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

function MergeAksesMenu($permission)
{
    $data['is_valid'] = false;
    $data['akses_menu'] = [];

    if (!empty($permission)) {
        $data['is_valid'] = true;

        foreach ($permission as $p) {
            // Pastikan master_menu ada
            if (isset($p->master_menu) && !empty($p->master_menu->path)) {
                $data['akses_menu'][] = [
                    'path'   => $p->master_menu->path,
                    'action' => explode(',', $p->action), // ubah jadi array biar gampang dicek nanti
                ];
            }
        }
    }
    return $data;
}

if (!function_exists('hasMenuAccess')) {
    function hasMenuAccess($akses, $currentPath, $action = 'read')
    {
        if (!$akses || !$akses->is_valid) {
            return false;
        }

        // Pastikan path selalu diawali dengan "/"
        $currentPath = '/' . ltrim($currentPath, '/');

        foreach ($akses->akses_menu as $menu) {
            // Gunakan regex agar cocok dengan child path seperti /settings/menu/add
            if (preg_match("#^" . preg_quote($menu->path, '#') . "(/|$)#", $currentPath)) {
                if (in_array($action, $menu->action)) {
                    return true;
                }
            }
        }

        return false;
    }
}


if (!function_exists('generateBreadcrumb')) {
    function generateBreadcrumb()
    {
        $segments = Request::segments(); // contoh: ['settings', 'menu', 'add']
        if (empty($segments)) {
            return '';
        }

        $breadcrumbHtml = '<nav class="py-2" aria-label="breadcrumb">';
        $breadcrumbHtml .= '<ol class="breadcrumb mb-0">';

        $path = '';

        foreach ($segments as $index => $segment) {
            $path .= '/' . $segment;
            $isLast = $index === array_key_last($segments);

            // Label rapi
            $label = ucfirst(str_replace(['-', '_'], ' ', $segment));

            // Cek apakah path ini terdaftar di tabel menu
            $menuExists = DB::table('menu')->where('path', $path)->exists();

            if ($isLast) {
                // item terakhir = aktif
                $breadcrumbHtml .= '<li class="breadcrumb-item active" aria-current="page">' . e($label) . '</li>';
            } else {
                // Jika parent ada di DB, maka bisa diklik
                if ($menuExists) {
                    $breadcrumbHtml .= '<li class="breadcrumb-item"><a href="' . URL::to($path) . '">' . e($label) . '</a></li>';
                } else {
                    // Kalau tidak ada di DB, jadikan non-clickable
                    $breadcrumbHtml .= '<li class="breadcrumb-item text-muted">' . e($label) . '</li>';
                }
            }
        }

        $breadcrumbHtml .= '</ol>';
        $breadcrumbHtml .= '</nav>';

        return $breadcrumbHtml;
    }
}


function generateMenuCode()
{
    $data = DB::table('menu')->orderByDesc('id')->first();
    // dd($data);
    $no = $data->id + 1;
    // output : M0001

    return 'M' . str_pad($no, 4, '0', STR_PAD_LEFT);
}

function generateColumnCode($nama_tabel, $nama_kolom, $code)
{
    $currentYm = date('ym'); // ex: 2503

    // Ambil semua data di bulan ini yang belum dihapus
    $lastRecord = DB::table($nama_tabel)
        ->whereNull('deleted')
        ->where($nama_kolom, 'like', $code . '-' . $currentYm . '-%')
        ->orderByDesc($nama_kolom)
        ->first();

    if ($lastRecord) {
        // Ambil bagian nomor urut dari kode terakhir
        $lastCode = $lastRecord->{$nama_kolom};
        $parts = explode('-', $lastCode);
        $lastNumber = (int) end($parts); // ambil angka terakhir
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    // Format: INV-2503-0001
    return $code . '-' . $currentYm . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
}
