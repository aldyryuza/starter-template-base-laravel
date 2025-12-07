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
                                <label for="number_ticket" class="form-label">TICKET NUMBER</label>
                                <input type="text" class="form-control" id="number_ticket" error="TICKET NUMBER"
                                    placeholder="REQ-XXX-XXX" value="{{ $data['number_ticket'] ?? null }}" readonly />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="requestor" class="form-label">REQUESTOR</label>
                                <input type="text" class="form-control" id="requestor" error="REQUESTOR"
                                    placeholder="Mr. XXX" value="{{ $data['requestor'] ?? null }}" readonly />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="apps" class="form-label">APPS</label>
                                <br>
                                <select class="select2 form-control required" name="apps" id="apps"
                                    error="User Group">
                                    <option value="">Select User Group</option>
                                    {{-- @foreach ($data_apps as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['apps']) && $data['apps'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->roles_name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="submission_date" class="form-label">SUBMISSION DATE</label>
                                <input type="text" class="form-control required" id="submission_date"
                                    error="SUBMISSION DATE" placeholder="DD-MM-YYYY"
                                    value="{{ $data['submission_date'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="required_date" class="form-label">REQUIRED DATE</label>
                                <input type="text" class="form-control required" id="required_date"
                                    error="REQUIRED DATE" placeholder="DD-MM-YYYY"
                                    value="{{ $data['required_date'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="request" class="form-label">Request</label>
                                <input type="text" class="form-control required" id="request" error="Request"
                                    placeholder="Enter request" value="{{ $data['request'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control required" error="Description" id="description" cols="30"
                                    rows="10" placeholder="Enter description">{{ $data['description'] ?? null }}</textarea>
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
