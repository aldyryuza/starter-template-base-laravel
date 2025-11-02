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
                <!-- ---------------------------------- -->
                <!-- Home -->
                <!-- ---------------------------------- -->
                <li class="nav-small-cap">
                    <i class="bx bx-home nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#" id="get-url" aria-expanded="false">
                        <span>
                            <i class="bx bx-home"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>



                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <span class="d-flex">
                            <i class="bx bx-user"></i>
                        </span>
                        <span class="hide-menu">Master</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ url('master/users') }}" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="bx bx-circle"></i>
                                </div>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                    </ul>
                </li>

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
                    aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                    <i class="bx bx-log-out fs-6"></i>
                </button>
            </div>
        </div>
    </div>
</aside>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // ambil URL saat ini (tanpa parameter GET)
        const currentURL = window.location.pathname.split("/").pop();

        // ambil semua link di sidebar
        const sidebarLinks = document.querySelectorAll(".sidebar-link");

        sidebarLinks.forEach(link => {
            const href = link.getAttribute("href");

            // skip jika href kosong atau javascript:void(0)
            if (!href || href === "#" || href.startsWith("javascript")) return;

            // jika cocok dengan halaman saat ini
            if (currentURL === href || window.location.href.includes(href)) {
                // tambahkan class active pada link
                link.classList.add("active");

                // buka parent submenu kalau ada
                const parentItem = link.closest(".collapse");
                if (parentItem) {
                    parentItem.classList.add("show");

                    // cari parent <li> yang punya class has-arrow
                    const parentTrigger = parentItem.previousElementSibling;
                    if (parentTrigger && parentTrigger.classList.contains("has-arrow")) {
                        parentTrigger.setAttribute("aria-expanded", "true");
                        parentTrigger.classList.add("active");
                    }
                }

                // tambahkan active juga pada parent .sidebar-item
                const li = link.closest(".sidebar-item");
                if (li) li.classList.add("active");
            }
        });
    });
</script>
