import Chat from "./chat.js";
import Modal from './modal.js';
import { NavMenu as NavMenuJS } from '../submodules/NavMenuJS/js/NavMenu.js';
import Token from "./token.js";
import { URLServiceProvider as URL } from "../submodules/ProvidersJS/js/URLServiceProvider.js";

document.addEventListener('DOMContentLoaded', (e) => {
    let navmenu = new NavMenuJS({
        id: "nav-id",
        sidebar: {
            id: ["menu"],
            position: ["left"],
    }}, {
        // fixed: true,
        // hideOnScrollDown: true
    });

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