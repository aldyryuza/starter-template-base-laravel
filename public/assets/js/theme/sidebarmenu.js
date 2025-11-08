var at = document.documentElement.getAttribute("data-layout");

if (at == "vertical") {
    function findMatchingElement() {
        var currentUrl = window.location.href;
        var anchors = document.querySelectorAll("#sidebarnav a");
        for (var i = 0; i < anchors.length; i++) {
            if (anchors[i].href === currentUrl) {
                return anchors[i];
            }
        }
        return null;
    }

    var elements = findMatchingElement();
    if (elements) elements.classList.add("active");

    // Expand submenu if current page inside it
    document.querySelectorAll("ul#sidebarnav ul li a.active").forEach(function (link) {
        link.closest("ul").classList.add("in");
        link.closest("ul").parentElement.classList.add("selected");
    });

    // Collapse / Expand handler for .has-arrow links
    document.querySelectorAll("#sidebarnav .has-arrow").forEach(function (link) {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const parentLi = this.closest("li");
            const subMenu = this.nextElementSibling;

            if (subMenu && subMenu.classList.contains("collapse")) {
                if (subMenu.classList.contains("in")) {
                    subMenu.classList.remove("in");
                    parentLi.classList.remove("selected");
                } else {
                    // Tutup semua menu lain
                    document.querySelectorAll("#sidebarnav .collapse.in").forEach(function (openSub) {
                        openSub.classList.remove("in");
                        openSub.parentElement.classList.remove("selected");
                    });

                    subMenu.classList.add("in");
                    parentLi.classList.add("selected");
                }
            }
        });
    });
}

if (at == "horizontal") {
    function findMatchingElement() {
        var currentUrl = window.location.href;
        var anchors = document.querySelectorAll("#sidebarnavh ul#sidebarnav a");
        for (var i = 0; i < anchors.length; i++) {
            if (anchors[i].href === currentUrl) {
                return anchors[i];
            }
        }
        return null;
    }

    var elements = findMatchingElement();
    if (elements) elements.classList.add("active");
}
