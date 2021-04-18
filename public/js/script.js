import Chat from "./chat.js";
import { Dropdown as DropdownJS } from "../submodules/DropdownJS/js/Dropdown.js";
import Modal from './modal.js';
import { NavMenu as NavMenuJS } from '../submodules/NavMenuJS/js/NavMenu.js';
import Token from "./token.js";
import { URLServiceProvider as URL } from "../submodules/ProvidersJS/js/URLServiceProvider.js";

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

    const modals = {
        login: new Modal({ id: 'login' }),
        signin: new Modal({ id: 'signin' }),
    };
    if (URL.findHashParameter()) {
        switch (URL.findHashParameter()) {
            case 'login':
                modals.login.changeAuthModalContent();
                modals.login.ModalJS.open();
                break;
            case 'signin':
                modals.signin.changeAuthModalContent();
                modals.signin.ModalJS.open();
                break;
        }
    }

    const token = Token.get();
    if (authenticated) {
        const chats = Chat.all(token.data);
    } else if (token) {
        token.remove();
    }
});