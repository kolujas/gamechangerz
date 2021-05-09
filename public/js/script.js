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

    const token = Token.get();
    let modals = {}
    if (!authenticated) {
        modals.login = new Modal({ id: 'login' });
        modals.signin = new Modal({ id: 'signin' });
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
        new NotificationJS(error, {
            show: true,
        });
    }
});