<aside class="left-sidebar with-vertical">
    <div>
        <!-- ---------------------------------- -->
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
            <!-- 🔍 Search Bar -->
            <div class="p-3 pb-2">
                <div class="position-relative">
                    <i class="bx bx-search position-absolute top-50 start-0 translate-middle-y ms-2 text-muted"></i>
                    <input type="text" id="menuSearch" class="form-control form-control-sm ps-5"
                        placeholder="Cari menu..." onkeyup="filterMenu()" />
                </div>
            </div>


            <!-- Menu List -->
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
                    <h6 class="mb-0 fs-4 fw-semibold">{{ session('name') ?? '' }}</h6>
                    <span class="fs-2">{{ session('user_group')->roles_name ?? '' }}</span>
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

<!-- 🧠 Script Filter Menu -->
<script>
    function filterMenu() {
        const input = document.getElementById('menuSearch');
        const filter = input.value.toLowerCase();
        const items = document.querySelectorAll('#sidebarnav li');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            // tampilkan hanya menu yang mengandung teks pencarian
            item.style.display = text.includes(filter) ? '' : 'none';
        });
    }
</script>
