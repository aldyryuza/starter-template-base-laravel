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
                                <label for="submission_date" class="form-label">SUBMISSION DATE</label>
                                <input type="text" class="form-control required" id="submission_date"
                                    error="SUBMISSION DATE" placeholder="DD-MM-YYYY"
                                    value="{{ $data['submission_date'] ?? date('d-m-Y') }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="required_date" class="form-label">REQUIRED DATE</label>
                                <input type="text" class="form-control date required" id="required_date"
                                    error="REQUIRED DATE" placeholder="DD-MM-YYYY"
                                    value="{{ $data['required_date'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="apps" class="form-label">APPS</label>
                                <br>
                                <select class="select2 form-control required" name="apps" id="apps"
                                    error="User Group" onchange="Request.changeApps()">
                                    <option value="">Select Apps</option>
                                    @foreach ($data_apps as $item)
                                        <option value="{{ $item->id }}"
                                            {{ isset($data['nama']) && $data['nama'] == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                    {{-- other / aplikasi baru maka akan muncul inputan baru dibawahnya --}}
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div id="other-apps" style="display: {{ isset($data['other_apps']) ? 'block' : 'none' }};">
                                <div class="mb-3">
                                    <label for="other_apps" class="form-label">OTHER APPS</label>
                                    <input type="text" class="form-control required" id="other_apps"
                                        error="OTHER APPS" placeholder="Enter other apps"
                                        value="{{ $data['other_apps'] ?? null }}" />
                                </div>
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

                        {{-- NAV TAB --}}
                        <div class="col-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills flex-column flex-sm-row mt-4" role="tablist">
                                <li class="nav-item flex-sm-fill text-sm-center">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#navpill-11"
                                        role="tab">
                                        <span>LAMPIRAN</span>
                                    </a>
                                </li>
                                <li class="nav-item flex-sm-fill text-sm-center">
                                    <a class="nav-link" data-bs-toggle="tab" href="#navpill-22" role="tab">
                                        <span>INFO REQUEST</span>
                                    </a>
                                </li>
                                <li class="nav-item flex-sm-fill text-sm-center">
                                    <a class="nav-link" data-bs-toggle="tab" href="#navpill-33" role="tab">
                                        <span>Tab 3</span>
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content border mt-2">
                                <div class="tab-pane active p-3" id="navpill-11" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="../assets/images/blog/blog-img2.jpg" alt="modernize-img"
                                                class="img-fluid" />
                                        </div>
                                        <div class="col-md-8">
                                            <p>
                                                Raw denim you probably haven't heard of them jean
                                                shorts Austin. Nesciunt tofu stumptown aliqua,
                                                retro synth master cleanse. Mustache cliche
                                                tempor, williamsburg carles vegan helvetica.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-22" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p>
                                                Raw denim you probably haven't heard of them jean
                                                shorts Austin. Nesciunt tofu stumptown aliqua,
                                                retro synth master cleanse. Mustache cliche
                                                tempor, williamsburg carles vegan helvetica.
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="../assets/images/blog/blog-img1.jpg" alt="modernize-img"
                                                class="img-fluid" />
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane p-3" id="navpill-33" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="../assets/images/blog/blog-img3.jpg" alt="modernize-img"
                                                class="img-fluid" />
                                        </div>
                                        <div class="col-md-8">
                                            <p>
                                                Raw denim you probably haven't heard of them jean
                                                shorts Austin. Nesciunt tofu stumptown aliqua,
                                                retro synth master cleanse. Mustache cliche
                                                tempor, williamsburg carles vegan helvetica.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- END NAV TAB --}}
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
