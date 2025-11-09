<?php


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
    /**
     * Cek apakah user punya akses ke path tertentu dan (opsional) action tertentu
     *
     * @param  object|null  $akses   Object berisi is_valid dan akses_menu
     * @param  string       $path    Path URL (misal: '/dashboard')
     * @param  string|null  $action  (opsional) Aksi yang ingin dicek: 'read', 'update', dll
     * @return bool
     */
    function hasMenuAccess($akses, $path, $action = null)
    {
        // Jika belum login atau tidak punya data akses
        if (!$akses || empty($akses->akses_menu) || !$akses->is_valid) {
            return false;
        }

        foreach ($akses->akses_menu as $menu) {
            // pastikan ada path
            if (isset($menu->path) && $menu->path === $path) {
                // kalau tidak butuh cek action → langsung true
                if ($action === null) {
                    return true;
                }

                // kalau mau cek action
                if (!empty($menu->action) && in_array($action, $menu->action)) {
                    return true;
                }
            }
        }

        return false;
    }
}
