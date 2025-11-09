var layoutType = document.documentElement.getAttribute("data-layout");

if (layoutType === "vertical") {
    // ==============================
    // Fungsi untuk mencari menu aktif
    // ==============================
    function findMatchingElement() {
        var currentUrl = window.location.href.split(/[?#]/)[0]; // abaikan query
        var anchors = document.querySelectorAll("#sidebarnav a");
        for (var i = 0; i < anchors.length; i++) {
            if (anchors[i].href === currentUrl) {
                return anchors[i];
            }
        }
        return null;
    }

    var activeLink = findMatchingElement();
    if (activeLink) {
        activeLink.classList.add("active");

        // buka parent menu jika ada
        var parentUl = activeLink.closest("ul");
        if (parentUl) {
            parentUl.classList.add("in");
            var parentLi = parentUl.closest("li");
            if (parentLi) parentLi.classList.add("selected");
        }
    }

    // ==============================
    // Klik handler: buka/tutup submenu
    // ==============================
    document.querySelectorAll("#sidebarnav .has-arrow").forEach(function (link) {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const parentLi = this.closest("li");
            const subMenu = this.nextElementSibling;

            if (!subMenu || !subMenu.classList.contains("collapse")) return;

            const isOpen = subMenu.classList.contains("in");

            // Tutup semua submenu lain
            document.querySelectorAll("#sidebarnav .collapse.in").forEach(function (openSub) {
                if (openSub !== subMenu) {
                    openSub.classList.remove("in");
                    openSub.parentElement.classList.remove("selected");
                    const aTag = openSub.parentElement.querySelector("a.has-arrow");
                    if (aTag) aTag.classList.remove("active");
                }
            });

            // Toggle submenu sekarang
            if (isOpen) {
                subMenu.classList.remove("in");
                parentLi.classList.remove("selected");
                this.classList.remove("active");
            } else {
                subMenu.classList.add("in");
                parentLi.classList.add("selected");
                this.classList.add("active");
            }
        });
    });

    // ==============================
    // Tambah highlight ke li.selected > a
    // ==============================
    document.querySelectorAll("#sidebarnav li.selected > a").forEach(function (a) {
        a.classList.add("active");
    });
}

// ==============================
// HORIZONTAL LAYOUT HANDLER
// ==============================
if (layoutType === "horizontal") {
    function findMatchingElementH() {
        var currentUrl = window.location.href.split(/[?#]/)[0];
        var anchors = document.querySelectorAll("#sidebarnavh ul#sidebarnav a");
        for (var i = 0; i < anchors.length; i++) {
            if (anchors[i].href === currentUrl) {
                return anchors[i];
            }
        }
        return null;
    }

    var elements = findMatchingElementH();
    if (elements) {
        elements.classList.add("active");
        var parentUl = elements.closest("ul");
        if (parentUl) parentUl.parentElement.classList.add("selected");
    }
}
