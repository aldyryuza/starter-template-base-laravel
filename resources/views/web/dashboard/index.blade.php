@php
    $currentPath = '/' . request()->path(); // contoh: /dashboard
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'read'))
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Dashboard</h5>
                    <p class="card-text">
                        Welcome to the dashboard!
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
