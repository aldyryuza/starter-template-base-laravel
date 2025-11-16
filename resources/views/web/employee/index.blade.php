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
                    <p class="card-text">
                        Welcome to the {{ $data_page['title'] }}!
                    </p>

                    @if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
                        <button class="btn btn-primary" onclick="Employee.add()">
                            Tambah Data <i class="bx bx-plus"></i>
                        </button>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 table-responsive">
                            <table id="data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>EMPLOYEE CODE</th>
                                        <th>NAME</th>
                                        <th>JOB TITLE</th>
                                        <th>SUBSIDIARY</th>
                                        <th>DEPARTMENT</th>
                                        <th>CONTACT</th>
                                        <th>EMAIL</th>
                                        <th>ADDRESS</th>
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
