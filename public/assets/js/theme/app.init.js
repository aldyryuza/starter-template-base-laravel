// Load user preferences from localStorage (if exist)
var savedSettings = {
    Theme: localStorage.getItem("themeMode") || "light",
    ColorTheme: localStorage.getItem("colorTheme") || "Blue_Theme",
    BoxedLayout: (localStorage.getItem("boxedMode") || "full") === "boxed",
    Direction: localStorage.getItem("dirMode") || "ltr",
    Layout: localStorage.getItem("layoutMode") || "vertical",
    cardBorder: (localStorage.getItem("cardMode") || "shadow") === "border",
    SidebarType: "full",
};

// Initialize userSettings using saved values
var userSettings = {
    Layout: savedSettings.Layout, // vertical | horizontal
    SidebarType: savedSettings.SidebarType, // full | mini-sidebar
    BoxedLayout: savedSettings.BoxedLayout, // true | false
    Direction: savedSettings.Direction, // ltr | rtl
    Theme: savedSettings.Theme, // light | dark
    ColorTheme: savedSettings.ColorTheme, // Blue_Theme | Orange_Theme | etc
    cardBorder: savedSettings.cardBorder, // true | false
};
