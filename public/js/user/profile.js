import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";

document.addEventListener('DOMContentLoaded', function (e) {
    new TabMenuJS({
        id: 'horarios'
    },{
        open: ['online'],
        active: 'online',
    });
});