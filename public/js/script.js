import Chat from "./chat.js";
import { Dropdown as DropdownJS } from "../submodules/DropdownJS/js/Dropdown.js";
import Modal from './modal.js';
import { NavMenu as NavMenuJS } from '../submodules/NavMenuJS/js/NavMenu.js';
import { Notification as NotificationJS } from "../submodules/NotificationJS/js/Notification.js";
import Token from "./token.js";
import { URLServiceProvider as URL } from "../submodules/ProvidersJS/js/URLServiceProvider.js";

async function getChats (token) {
    const chats = await Chat.all(token.data);
    new Chat({ token: token.data }, chats);
}

function changeType (btn) {
    let input;
    for (const className of btn.classList) {
        if (/input-/.exec(className)) {
            input = document.querySelector(`input[name=${ className.split('input-')[1] }]`);
        }
    }
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
    if (btn.children[0].classList.contains('fa-eye')) {
        btn.children[0].classList.remove('fa-eye');
        btn.children[0].classList.add('fa-eye-slash');
    } else {
        btn.children[0].classList.add('fa-eye');
        btn.children[0].classList.remove('fa-eye-slash');
    }
}

document.addEventListener('DOMContentLoaded', (e) => {
    new NavMenuJS({
        id: "nav-id",
        sidebar: {
            id: ["menu"],
            position: ["left"],
    }});

    if (document.querySelectorAll('.dropdown').length) {
        for (const html of document.querySelectorAll('.dropdown')) {
            new DropdownJS({
                id: html.id
            });
        }
    }

    const token = Token.get();
    let modals = {}
    if (!authenticated) {
        modals.login = new Modal({ id: 'login' });
        modals.signin = new Modal({ id: 'signin' });
    
        if (URL.findHashParameter()) {
            switch (URL.findHashParameter()) {
                case 'login':
                    modals.login.changeModalContent();
                    modals.login.ModalJS.open();
                    break;
                case 'signin':
                    modals.signin.changeModalContent();
                    modals.signin.ModalJS.open();
                    break;
            }
        }
    }
    
    if (authenticated) {
        modals.assigment = new Modal({ id: 'assigment' });
        if (document.querySelectorAll("a[href='/logout']").length) {
            for (const html of document.querySelectorAll("a[href='/logout']")) {
                html.addEventListener('click', function (e) {
                    token.remove();
                    window.location.href = '/logout';
                });
            }
        }
        getChats(token);
        new Modal({id: 'assigment'});
    } else if (token) {
        token.remove();
    }

    if (error) {
        new NotificationJS({
            ...error,
            classes: ['russo'],
        }, {
            open: true,
        });
    }

    if (document.querySelectorAll('.seePassword').length) {
        for (const btn of document.querySelectorAll('.seePassword')) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                changeType(this);
            });
        }
    }
});