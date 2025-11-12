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
                                <label for="parent_menu" class="form-label">Parent Menu</label>
                                <br>
                                <select class="select2 form-control" name="parent_menu" id="parent_menu">
                                    <option value="">Select Parent Menu</option>
                                    @foreach ($data_menu as $item)
                                        <option value="{{ $item->menu_code }}"
                                            {{ isset($data['parent']) && $data['parent'] == $item->menu_code ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control required" id="name" error="Name"
                                    placeholder="Enter name" value="{{ $data['name'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="path_url" class="form-label">Path URL</label>
                                <input type="text" class="form-control required" id="path_url" error="Path URL"
                                    placeholder="/<parent>/<child>" value="{{ $data['path'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="icon_menu" class="form-label">Icon Menu</label>
                                <input type="text" class="form-control" id="icon_menu" placeholder="bx bx-card"
                                    value="{{ $data['icon'] ?? null }}" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline align-items-center d-flex">
                                <input class="form-check-input success check-outline outline-success me-1"
                                    type="checkbox" id="is_routing" value="1"
                                    {{ isset($data['routing']) && $data['routing'] == 1 ? 'checked' : '' }} />
                                <label class="form-check-label mb-0" for="is_routing">Is Routing</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-top">
                    <div class="text-end">
                        @if ($data_page['action'] != 'detail')
                            <button type="button" class="btn btn-primary" onclick="Menu.submit()">
                                Save
                            </button>
                        @endif
                        <button type="button" class="btn bg-danger-subtle text-danger ms-6 px-4" onclick="Menu.back()">
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
