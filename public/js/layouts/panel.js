import { TabMenu as TabMenuJS } from "../../../submodules/TabMenuJS/js/TabMenu.js";

import Token from "../components/Token.js";

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
    // TODO: Get inputs & switch disable state
    // TODO: Set ValidationJS
    const editBtn = document.querySelector('.editBtn');
    editBtn.addEventListener('click', function(){
        enable();
    })    

    const cancelBtn = document.querySelector('.cancelBtn');
    cancelBtn.addEventListener('click', function(){
        disable();
    })

    const deleteBtn = document.querySelector('.deleteBtn');
    deleteBtn.addEventListener('click', function(){
        deleteEnable();
    })
}

let info = {}

function enable(){
    for (const input of document.querySelectorAll('.editable')) {
        input.disabled = false;

        info[input.name] = input.value;  
        if(input.type == 'checkbox'){
            info[input.name] = input.checked;
        }
    }

    document.querySelector('.editBtn').classList.add('hidden');
    document.querySelector('.deleteBtn').classList.add('hidden');
    document.querySelector('.submitBtn').classList.remove('hidden');
    document.querySelector('.cancelBtn').classList.remove('hidden');
}

function disable(){
    for (const input of document.querySelectorAll('.editable')) {
        input.disabled = true;
        input.value = info[input.name];
        if(input.type == 'checkbox'){
            input.checked = info[input.name];
        }
    }

    document.querySelector('.editBtn').classList.remove('hidden');
    document.querySelector('.deleteBtn').classList.remove('hidden');
    document.querySelector('.submitBtn').classList.add('hidden');
    document.querySelector('.cancelBtn').classList.add('hidden');
    document.querySelector('.msg-modal').classList.add('hidden');
}

function deleteEnable(){
    document.querySelector('.msg-modal').classList.remove('hidden');
    document.querySelector('.editBtn').classList.add('hidden');
    document.querySelector('.deleteBtn').classList.add('hidden');
    document.querySelector('.submitBtn').classList.remove('hidden');
    document.querySelector('.cancelBtn').classList.remove('hidden');
}

let token = new Token();

document.querySelector('a.tab-link').addEventListener('click', function (e) {
    token.remove();
});