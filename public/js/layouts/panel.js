import Token from "../components/Token.js";

new window.tabmenu({
    id: "panel",
},{
    open: document.querySelector("#panel.tab-menu li.tab-content").id,
});

new window.sidebar({
    id: "panel-menu",
    position: "left",
}, {
    open: true,
    viewport: {
        "1024": true,
}});

for (const tr of document.querySelectorAll("#panel.tab-menu li.tab-content table tbody tr")) {
    tr.addEventListener("click", function (e) {
        if (this.dataset.hasOwnProperty("href")) {
            if (e.target.nodeName !== "A" || e.target.parentNode.nodeName !== "A") {
                window.location = this.dataset.href;
            }
        }
    });
}

if (document.querySelector("#panel.tab-menu li.tab-content > form:not(.not)")) {
    if (document.querySelector(".editBtn")) {
        document.querySelector(".editBtn").addEventListener('click', function(){
            enable();
        });
    }
    if (document.querySelector(".cancelBtn")) {
        document.querySelector(".cancelBtn").addEventListener('click', function(){
            disable();
        }); 
    }
    if (document.querySelector(".deleteBtn")) {
        document.querySelector(".deleteBtn").addEventListener('click', function(){
            deleteEnable();
        }); 
    }
}

let info = {}

function enable(button = true){
    for (const input of document.querySelectorAll('.editable')) {
        if (button || !input.classList.contains("not-default")) {
            input.disabled = false;
            if (input.nodeName === "BUTTON") {
                input.classList.remove("hidden");
            }
    
            if (input.type !== "file") {
                info[input.name] = input.value;  
            }
            if(input.type === 'checkbox'){
                info[input.name] = input.checked;
            }
        }
    }

    document.querySelector('.editBtn').classList.add('hidden');
    document.querySelector('.deleteBtn').classList.add('hidden');
    if (document.querySelector(".checkBtn")) {
        document.querySelector('.checkBtn').classList.add('hidden');
    }
    document.querySelector('.submitBtn').classList.remove('hidden');
    document.querySelector('.cancelBtn').classList.remove('hidden');
}

function disable(){
    for (const input of document.querySelectorAll('.editable')) {
        input.disabled = true;
        if (input.nodeName === "BUTTON") {
            input.classList.add("hidden");
        }

        if (input.type !== "file") {
            input.value = info[input.name];
        }
        if(input.type === 'checkbox'){
            input.checked = info[input.name];
        }
    }

    for (const support of document.querySelectorAll('.support')) {
        support.classList.add("hidden");
        support.innerHTML = "";
    }

    document.querySelector('.editBtn').classList.remove('hidden');
    document.querySelector('.deleteBtn').classList.remove('hidden');
    if (document.querySelector(".checkBtn")) {
        document.querySelector('.checkBtn').classList.remove('hidden');
    }
    document.querySelector('.submitBtn').classList.add('hidden');
    document.querySelector('.cancelBtn').classList.add('hidden');
    document.querySelector('.msg-modal').classList.add('hidden');
}

function deleteEnable(){
    for (const input of document.querySelectorAll('.editable')) {
        input.disabled = false;
        if (input.nodeName === "BUTTON") {
            input.classList.remove("hidden");
        }

        if (input.type !== "file") {
            info[input.name] = input.value;  
        }
        if(input.type === 'checkbox'){
            info[input.name] = input.checked;
        }
    }

    document.querySelector('.msg-modal').classList.remove('hidden');
    document.querySelector('.editBtn').classList.add('hidden');
    if (document.querySelector(".checkBtn")) {
        document.querySelector('.checkBtn').classList.add('hidden');
    }
    document.querySelector('.deleteBtn').classList.add('hidden');
    document.querySelector('.submitBtn').classList.remove('hidden');
    document.querySelector('.cancelBtn').classList.remove('hidden');
}

let token = new Token();

document.querySelector('a.tab-link').addEventListener('click', function (e) {
    token.remove();
});

document.addEventListener("DOMContentLoaded", function () {
    if (/update/.exec(window.url.findHashParameter())) {
        enable(false);
    }
    
    if (/delete/.exec(window.url.findHashParameter())) {
        deleteEnable();
    }
    
    if (/create/.exec(window.url.findCompleteRoute())) {
        enable(false);
    }
});