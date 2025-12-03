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
                                <label for="menu" class="form-label">Menu</label>
                                <br>
                                <select class="select2 form-control required" name="menu" id="menu"
                                    error="Menu">
                                    <option value="">Select Menu</option>
                                    @foreach ($data_menu as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['menu']) && $data['menu'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subsidiary" class="form-label">Subsidiary</label>
                                <br>
                                <select class="select2 form-control" name="subsidiary" id="subsidiary"
                                    error="Subsidiary">
                                    <option value="">Select Subsidiary</option>
                                    @foreach ($data_subsidiary as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['subsidiary']) && $data['subsidiary'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department</label>
                                <br>
                                <select class="select2 form-control" name="department" id="department"
                                    error="Department">
                                    <option value="">Select Department</option>
                                    @foreach ($data_department as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['departemen']) && $data['departemen'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->department_name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control required" error="Remarks" name="remarks" id="remarks" cols="30" rows="10">{{ $data['remarks'] ?? null }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="mb-2">
                                <label for="routing_list" class="form-label">Routing List</label>
                            </div>
                            <div class="mb-2">
                                {{-- alert warning --}}
                                <div class="alert alert-warning text-warning" role="alert">
                                    <strong>Perhatian - </strong> Jika mau mengedit routing list, pastikan hapus
                                    terlebih dahulu baru add +
                                </div>
                            </div>
                            <div class="table-responsive" id="routing_list">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ROUTING TYPE</th>
                                            <th class="text-center">USERS</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        {{-- {{ dd($data->RoutingPermission) }} --}}
                                        @if (isset($data->RoutingPermission) && $data->RoutingPermission->count() > 0)
                                            @foreach ($data->RoutingPermission as $index => $item)
                                                @php
                                                    // Buat rowId unik agar select2 & button select user bisa kerja
                                                    $rowId = 'existing-' . $item->id;
                                                @endphp
                                                <tr data-routing-detail-id="{{ $item->id }}"
                                                    data-row-id="{{ $rowId }}">
                                                    <td class="text-center">
                                                        <select class="form-control select2 routing-type-select"
                                                            style="width:100%" required>
                                                            <option value="{{ $item->Dictionary->term_id }}" selected>
                                                                {{ $item->Dictionary->keterangan }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="input-group">
                                                            <button type="button"
                                                                class="btn btn-success btn-select-user"
                                                                data-row="{{ $rowId }}">
                                                                Select
                                                            </button>
                                                            <input type="text" class="form-control user-name"
                                                                value="{{ $item->Users->name ?? '' }}" readonly>
                                                            <input type="hidden" class="user-id"
                                                                value="{{ $item->Users->id ?? '' }}">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-delete-row">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        <!-- Placeholder tombol Add -->
                                        <tr class="add-row-placeholder">
                                            <td colspan="3" class="text-left">
                                                <button type="button" class="btn btn-primary btn-add-row">
                                                    Add <i class="bx bx-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 border-top">
                        <div class="text-end">
                            @if ($data_page['action'] != 'detail')
                                <button type="button" class="btn btn-primary" onclick="Routing.submit()">
                                    Save
                                </button>
                            @endif
                            <button type="button" class="btn bg-danger-subtle text-danger ms-6 px-4"
                                onclick="Routing.back()">
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
