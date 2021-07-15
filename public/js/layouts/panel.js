import { TabMenu as TabMenuJS } from "../../../submodules/TabMenuJS/js/TabMenu.js";

new TabMenuJS({
    id: "panel",
},{
    open: document.querySelector("#panel.tab-menu li.tab-content").id,
});

for (const tr of document.querySelectorAll("#panel.tab-menu li.tab-content table tbody tr")) {
    tr.addEventListener("click", function (e) {
        if (this.dataset.hasOwnProperty("href")) {
            window.location = this.dataset.href;
        }
    });
}

if (document.querySelector("#panel.tab-menu li.tab-content > form")) {
    console.log(document.querySelectorAll("#panel.tab-menu li.tab-content > form .form-input"));
}