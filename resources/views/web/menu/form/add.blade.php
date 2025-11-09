@php
    $currentPath = '/' . request()->path();
@endphp

@if (hasMenuAccess($akses ?? null, $currentPath, 'create'))
    {!! generateBreadcrumb() !!}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $data_page['title'] }}</h5>
                    <p class="card-text">
                        Welcome to the {{ $data_page['title'] }}!
                    </p>
                </div>
            </div>
        </div>
    </div>

    @include('web.menu.modal.index')
@else
    @include('errors.no_akes')
@endif
