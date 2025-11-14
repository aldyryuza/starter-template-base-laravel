@php
    $currentPath = '/' . request()->path(); // contoh: /dashboard
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'read'))
    {!! generateBreadcrumb() !!}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $data_page['title'] }}</h5>
                    <p class="card-text">
                        Welcome to the {{ $data_page['title'] }}!
                    </p>

                    @if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
                        <button class="btn btn-primary" onclick="Permission.add()">
                            Tambah Data <i class="bx bx-plus"></i>
                        </button>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 table-responsive">
                            <table id="data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAMA MENU</th>
                                        <th>ROLES</th>
                                        <th>AKSES</th>
                                        <th>CREATED AT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated by Yajra Datatables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    @include('errors.no_akes')
@endif
