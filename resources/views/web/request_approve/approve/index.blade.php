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
                                <button class="btn btn-primary" onclick="Users.add()">
                                    Tambah Data <i class="bx bx-plus"></i>
                                </button>
                            @endif
                        </div>

                        <!-- Area kosong, tombol DataTables (Copy, Excel, Kolom, dll) akan masuk ke sini otomatis -->
                        <div id="datatable-buttons"></div>
                    </div>

                    <div class="table-responsive">
                        <table id="data-table" class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Roles</th>
                                    <th>Created At</th>
                                    <th class="text-center">Action</th>
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
