// ? External repositories
import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";

document.addEventListener('DOMContentLoaded', function (e) {
    let tab = new TabMenuJS({
        id: 'methods'
    }, {
        open: ['skins'],
    });
});