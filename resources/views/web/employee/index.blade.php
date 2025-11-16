@php
    $currentPath = '/' . request()->path(); // contoh: /dashboard
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'read'))
    {!! generateBreadcrumb() !!}
    <input type="hidden" name="update" id="update"
        value="{{ hasMenuAccess($akses ?? null, $currentPath, 'update') ? 1 : 0 }}">
    <input type="hidden" name="delete" id="delete"
        value="{{ hasMenuAccess($akses ?? null, $currentPath, 'delete') ? 1 : 0 }}">

    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="accordion" id="accordionFilter">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <b>FILTER DATA</b>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#accordionFilter">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="subsidiary" class="form-label">Subsidiary</label>
                                        <br>
                                        <select class="select2 form-control required" name="subsidiary"
                                            id="f-subsidiary" error="Subsidiary">
                                            <option value="">Select Subsidiary</option>
                                            @foreach ($data_subsidiary as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="job_title" class="form-label">Job title</label>
                                        <br>
                                        <select class="select2 form-control required" name="job_title" id="f-job_title"
                                            error="Job title">
                                            <option value="">Select Job title</option>
                                            @foreach ($data_job_title as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->job_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <br>
                                        <select class="select2 form-control required" name="department"
                                            id="f-department" error="Department">
                                            <option value="">Select Department</option>
                                            @foreach ($data_department as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->department_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 text-end">
                                    <div class="mb-3">
                                        <button class="btn btn-primary" onclick="Employee.getData()">
                                            Filter Data
                                        </button>
                                        <button class="btn btn-danger" onclick="Employee.ResetFilter()">
                                            Reset Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $data_page['title'] }}</h5>
                    <p class="card-text">
                        Welcome to the {{ $data_page['title'] }}!
                    </p>

                    <!-- Tombol di kiri dan kanan -->
                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                        @if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
                            <button class="btn btn-primary" onclick="Employee.add()">
                                Tambah Data <i class="bx bx-plus"></i>
                            </button>
                        @endif

                        <!-- Kanan: Export + Trash dengan jarak -->
                        <div class="btn-group gap-1" role="group">
                            <div class="btn-group" role="group">
                                <button class="btn bg-success-subtle text-success dropdown-toggle" type="button"
                                    id="export-btn" data-bs-toggle="dropdown">
                                    Export Data
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><button class="dropdown-item" format="xlsx"
                                            onclick="Employee.exportData(this)">Excel</button></li>
                                    <li><button class="dropdown-item" format="csv"
                                            onclick="Employee.exportData(this)">CSV</button></li>
                                </ul>
                            </div>
                            <button class="btn btn-danger" onclick="Employee.deleteAll()" title="Hapus Semua">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Tabel -->
                    <div class="row mt-3">
                        <div class="col-12 table-responsive">
                            <table id="data-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
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
                                <tbody></tbody>
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
