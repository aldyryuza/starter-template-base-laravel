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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">Test Modal</button>
                        <button class="btn btn-primary" onclick="Menu.add()">
                            Tambah Data <i class="bx bx-plus"></i>
                        </button>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 table-responsive">
                            <table id="data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAMA</th>
                                        <th>ICON</th>
                                        <th>PATH</th>
                                        <th>MENU CODE</th>
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
    @include('web.menu.modal.index')
@else
    @include('errors.no_akes')
@endif
