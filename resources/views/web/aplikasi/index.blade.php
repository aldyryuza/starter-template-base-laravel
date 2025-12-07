@php
    $currentPath = '/' . request()->path(); // contoh: /dashboard
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'read'))
    {!! generateBreadcrumb() !!}
    <input type="hidden" name="update" id="update"
        value="{{ hasMenuAccess($akses ?? null, $currentPath, 'update') ? 1 : 0 }}">
    <input type="hidden" name="delete" id="delete"
        value="{{ hasMenuAccess($akses ?? null, $currentPath, 'delete') ? 1 : 0 }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $data_page['title'] }}</h5>
                    <p class="card-text">Welcome to the {{ $data_page['title'] }}!</p>

                    <!-- Button Tambah + Area untuk Buttons DataTables (akan otomatis ke kanan) -->
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                        <div>
                            @if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
                                <button class="btn btn-primary" onclick="Aplikasi.add()">
                                    Tambah Data <i class="bx bx-plus"></i>
                                </button>
                            @endif
                        </div>

                        <div class="btn-group gap-1" role="group">
                            <div class="btn-group" role="group">
                                <button class="btn bg-success-subtle text-success dropdown-toggle" type="button"
                                    id="export-btn" data-bs-toggle="dropdown">
                                    Export Data
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><button class="dropdown-item" format="xlsx"
                                            onclick="Aplikasi.exportData(this)">Excel</button></li>
                                    <li><button class="dropdown-item" format="csv"
                                            onclick="Aplikasi.exportData(this)">CSV</button></li>
                                </ul>
                            </div>
                            <button class="btn btn-danger" onclick="Aplikasi.deleteAll()" title="Hapus Semua">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered table-hover text-nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th class="text-uppercase">No</th>
                                    <th class="text-uppercase">Nama</th>
                                    <th class="text-uppercase">Keterangan</th>
                                    <th class="text-uppercase">Created At</th>
                                    <th class="text-uppercase text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    @include('errors.no_akes')
@endif
