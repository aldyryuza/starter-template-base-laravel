@php
    $currentPath = '/' . request()->path();
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
    {!! generateBreadcrumb() !!}

    <div class="row">
        <div class="col-12">
            <div class="card w-100">
                <div class="card-body pb-0">
                    <h4 class="card-title text-uppercase">FORM {{ $data_page['title'] }}</h4>
                    <p class="card-subtitle mb-3">Plese fill the form</p>
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="subsidiary" class="form-label">Subsidiary</label>
                                <br>
                                <select class="select2 form-control required" name="subsidiary" id="subsidiary"
                                    error="Subsidiary">
                                    <option value="">Select Subsidiary</option>
                                    @foreach ($data_subsidiary as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['company']) && $data['company'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="job_title" class="form-label">Job title</label>
                                <br>
                                <select class="select2 form-control required" name="job_title" id="job_title"
                                    error="Job title">
                                    <option value="">Select Job title</option>
                                    @foreach ($data_job_title as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['job_title']) && $data['job_title'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->job_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <br>
                                <select class="select2 form-control required" name="department" id="department"
                                    error="Department">
                                    <option value="">Select Department</option>
                                    @foreach ($data_department as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['department']) && $data['department'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <input type="text" name="id" id="id" value="{{ $data['id'] ?? null }}"
                                    hidden>
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control required" id="name" error="Name"
                                    placeholder="Enter name" value="{{ $data['name'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="contact" error="Contact"
                                    placeholder="Enter contact" value="{{ $data['contact'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" error="Email"
                                    placeholder="Enter email" value="{{ $data['email'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="10">{{ $data['address'] ?? null }}</textarea>
                            </div>
                        </div>
                        @if (isset($data['employee_code']))
                            <div class="col-sm-12 col-md-6">
                                <div class="mb-3">
                                    <label for="employee_code" class="form-label">Employee code</label>
                                    <input type="text" class="form-control required" id="employee_code"
                                        error="Employee code" placeholder="Enter Employee code"
                                        value="{{ $data['employee_code'] ?? null }}" disabled />
                                </div>
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" class="form-control" id="nik" error="NIK"
                                        placeholder="Enter NIK" value="{{ $data['nik'] ?? null }}" disabled />
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="p-3 border-top">
                    <div class="text-end">
                        @if ($data_page['action'] != 'detail')
                            <button type="button" class="btn btn-primary" onclick="Employee.submit()">
                                Save
                            </button>
                        @endif
                        <button type="button" class="btn bg-danger-subtle text-danger ms-6 px-4"
                            onclick="Employee.back()">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    @include('errors.no_akes')
@endif
