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
                                <input type="text" name="id" id="id" value="{{ $data['id'] ?? null }}"
                                    hidden>
                                <label for="department_name" class="form-label">Departement Name</label>
                                <input type="text" class="form-control required" id="department_name"
                                    error="Departement Name" placeholder="Enter departement name"
                                    value="{{ $data['department_name'] ?? null }}" />
                            </div>
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="10">{{ $data['remarks'] ?? null }}</textarea>
                            </div>
                        </div>
                        @if (isset($data['code']))
                            <div class="col-sm-12 col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Departement code</label>
                                    <input type="text" class="form-control required" id="code"
                                        error="Departement code" placeholder="Enter departement code"
                                        value="{{ $data['code'] ?? null }}" disabled />
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="p-3 border-top">
                    <div class="text-end">
                        @if ($data_page['action'] != 'detail')
                            <button type="button" class="btn btn-primary" onclick="Departement.submit()">
                                Save
                            </button>
                        @endif
                        <button type="button" class="btn bg-danger-subtle text-danger ms-6 px-4"
                            onclick="Departement.back()">
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
