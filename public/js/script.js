import { NavMenu as NavMenuJS } from '../submodules/NavMenuJS/js/NavMenu.js';

document.addEventListener('DOMContentLoaded', (e) => {
    let navmenu = new NavMenuJS({
        id: "nav-id",
        sidebar: {
            id: ["menu"],
            position: ["left"],
    }}, {
        // fixed: true,
        // hideOnScrollDown: true
    });
});