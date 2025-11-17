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
                        {{-- {{ dd($data) }} --}}
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label for="action" class="form-label">Action</label>
                                <br>
                                <select class="select2 form-control" name="action[]" id="action" multiple="multiple">
                                    <option value="">Select Action</option>
                                    @foreach ($data_action as $item)
                                        @php
                                            // Ubah string koma menjadi array, jika ada
                                            $selectedActions = isset($data['action'])
                                                ? array_map('trim', explode(',', $data['action']))
                                                : [];
                                        @endphp
                                        <option value="{{ $item }}"
                                            {{ in_array($item, $selectedActions) ? 'selected' : '' }}>
                                            {{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 border-top">
                    <div class="text-end">
                        @if ($data_page['action'] != 'detail')
                            <button type="button" class="btn btn-primary" onclick="Permission.submit()">
                                Save
                            </button>
                        @endif
                        <button type="button" class="btn bg-danger-subtle text-danger ms-6 px-4"
                            onclick="Permission.back()">
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
