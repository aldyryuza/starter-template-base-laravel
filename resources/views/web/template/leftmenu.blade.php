<style>
    /* agar tampilan search konsisten seperti item menu Sneat */
    .menu-search-wrapper {
        margin-bottom: 5px;
    }

    .layout-menu-collapsed .menu-search-input {
        display: none !important;
    }

    .layout-menu-collapsed .menu-search-wrapper .input-group-text {
        border-radius: 50%;
        width: 45px;
        height: 45px;
        justify-content: center;
        padding: 0;
    }

    .layout-menu-collapsed .menu-search-wrapper {
        padding-left: .5rem !important;
    }

    .brand-logo {
        max-height: 80px;
        width: auto;
        height: auto;
        transition: all .25s ease;
    }

    .layout-menu-collapsed .brand-logo {
        max-height: 40px !important;
        opacity: .8;
    }
</style>

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo justify-content-center align-items-center">
        <a href="#" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/satoria/satoriapharma_logo.png') }}" class="brand-logo" alt="Logo">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item menu-search-wrapper" style="padding: 0.75rem 1rem;">
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-search"></i></span>
                <input type="text" class="form-control menu-search-input" placeholder="Search menu..."
                    onkeyup="Template.SearchMenuFunction($(this))">
            </div>
        </li>


        {!! app(\App\Http\Controllers\api\template\TemplateMenuController::class)->generateMenuWeb() !!}


    </ul>

</aside>
