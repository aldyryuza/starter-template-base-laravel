<aside class="left-sidebar with-vertical">
    <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="index-2.html" class="text-nowrap logo-img">
                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/dark-logo.svg"
                    class="dark-logo" alt="Logo-Dark" />
                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/logos/light-logo.svg"
                    class="light-logo" alt="Logo-light" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="bx bx-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                {!! app(\App\Http\Controllers\api\template\TemplateMenuController::class)->generateMenuWeb() !!}
            </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40"
                        height="40" alt="modernize-img" />
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                    <span class="fs-2">Designer</span>
                </div>
                <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button"
                    aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout"
                    onclick="Auth.signOut()">
                    <i class="bx bx-log-out fs-6"></i>
                </button>
            </div>
        </div>
    </div>
</aside>
