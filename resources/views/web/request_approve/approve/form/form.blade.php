@php
    $currentPath = '/' . request()->path();
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
    {!! generateBreadcrumb() !!}

    <button type="button" id="btn-show-modal" class="" style="display: none;" data-bs-toggle="modal"
        data-bs-target="#data-modal-karyawan"></button>
    <div id="content-modal-form"></div>

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
                                <input type="text" name="id" id="id" value="{{ $data['id'] ?? null }}"
                                    hidden>
                                <label for="employee" class="form-label">Employee Name</label>
                                <div class="input-group">
                                    <button class="btn bg-success-subtle text-success " type="button"
                                        onclick="Users.showDataKaryawan(this)">
                                        Select
                                    </button>
                                    <input type="text" class="form-control required"
                                        placeholder="Please select data..." id="employee" error="Employee Name"
                                        value="{{ $data['employee_code'] ?? null }}" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control required" id="name" error="Name"
                                    placeholder="Enter name" value="{{ $data['name'] ?? null }}" readonly />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="user_group" class="form-label">User Group</label>
                                <br>
                                <select class="select2 form-control required" name="user_group" id="user_group"
                                    error="User Group">
                                    <option value="">Select User Group</option>
                                    @foreach ($data_user_group as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['user_group']) && $data['user_group'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->roles_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control required" id="username" error="Username"
                                    placeholder="Enter username" value="{{ $data['username'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control required" id="password" error="Password"
                                    placeholder="Enter password" value="{{ $data['password'] ?? null }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-top">
                    <div class="text-end">
                        @if ($data_page['action'] != 'detail')
                            <button type="button" class="btn btn-primary" onclick="Users.submit()">
                                Save
                            </button>
                        @endif
                        <button type="button" class="btn bg-danger-subtle text-danger ms-6 px-4"
                            onclick="Users.back()">
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
