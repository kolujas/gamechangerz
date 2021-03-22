import { NavMenu as NavMenuJS } from "../../submodules/NavMenuJS/js/NavMenu.js";

document.addEventListener('DOMContentLoaded', (e) => {
    let navmenu = new NavMenuJS({
        id: 'nav-global',
        sidebar: {
            id: ['menu', 'filters'],
            position: ['left', 'right'],
    }}, {
        current: 'home'
    });
});