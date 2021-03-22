import { NavMenu as NavMenuJS } from '../submodules/NavMenuJS/js/NavMenu.js';

let navmenu = new NavMenuJS({
    id: "nav-id",
    sidebar: {
        id: ["mainSidebar"],
        position: ["left"],
    }

}, {fixed: true, hideOnScrollDown: true});