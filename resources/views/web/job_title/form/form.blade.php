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
                                <label for="job_name" class="form-label">Job Name</label>
                                <input type="text" class="form-control required" id="job_name" error="Job Name"
                                    placeholder="Enter job name" value="{{ $data['job_name'] ?? null }}" />
                            </div>
                        </div>
                        @if (isset($data['job_title_code']))
                            <div class="col-sm-12 col-md-6">
                                <div class="mb-3">
                                    <label for="job_title_code" class="form-label">Job code</label>
                                    <input type="text" class="form-control required" id="job_title_code"
                                        error="Job code" placeholder="Enter job code"
                                        value="{{ $data['job_title_code'] ?? null }}" disabled />
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="p-3 border-top">
                    <div class="text-end">
                        @if ($data_page['action'] != 'detail')
                            <button type="button" class="btn btn-primary" onclick="JobTitle.submit()">
                                Save
                            </button>
                        @endif
                        <button type="button" class="btn bg-danger-subtle text-danger ms-6 px-4"
                            onclick="JobTitle.back()">
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
