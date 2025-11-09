@php
    $currentPath = '/' . request()->path(); // contoh: /users
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'read'))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">
                        Welcome to the users!
                    </p>

                    {{-- contoh cek action --}}
                    @if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
                        <button class="btn btn-primary">Tambah Data</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    @include('errors.no_akes')
@endif
