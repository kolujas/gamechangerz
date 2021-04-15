import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { LocalStorageServiceProvider as LocalStorage } from "../submodules/ProvidersJS/js/LocalStorageServiceProvider.js";
import { Modal as ModalJS } from "../submodules/ModalJS/js/Modal.js";
import { NavMenu as NavMenuJS } from '../submodules/NavMenuJS/js/NavMenu.js';
import { URLServiceProvider as URL } from "../submodules/ProvidersJS/js/URLServiceProvider.js";
import { Validation as ValidationJS } from "../submodules/ValidationJS/js/Validation.js";

async function getChats () {
    let query = await Fetch.get('/api/chats', {
        'Accept': 'application/json',
        'Content-type': 'application/json; charset=UTF-8',
        'X-CSRF-TOKEN': 'Bearer ' + LocalStorage.get('access_token').data,
    });
    if (query.response.code === 200) {
        console.log(query.response);
    } else {
        console.error(query.response);
    }
}

function switchModalContent (hash) {
    switch (hash) {
        case 'login':
            document.querySelector("#auth.modal .modal-content #login").classList.remove('hidden');
            document.querySelector("#auth.modal .modal-content #login").classList.add('block');
            document.querySelector("#auth.modal .modal-content #signin").classList.remove('hblock');
            document.querySelector("#auth.modal .modal-content #signin").classList.add('hidden');
            break;
        case 'signin':
            document.querySelector("#auth.modal .modal-content #signin").classList.remove('hidden');
            document.querySelector("#auth.modal .modal-content #signin").classList.add('block');
            document.querySelector("#auth.modal .modal-content #login").classList.remove('block');
            document.querySelector("#auth.modal .modal-content #login").classList.add('hidden');
            break;
    }
}

async function send () {
    let formData = new FormData(validation.login.ValidationJS.form.html);
    let token = formData.get('_token');
    formData.delete('_token');
    // setLoadingState();
    let query = await Fetch.send({
        method: 'POST',
        url: `/api/login`,
    }, {
        'Accept': 'application/json',
        'Content-type': 'application/json; charset=UTF-8',
        'X-CSRF-TOKEN': token,
    }, formData);
    // setFinishState();
    if (!validation.login.ValidationJS.form.html.classList.contains('invalid')) {
        if (query.response.code === 200) {
            LocalStorage.set('access_token', query.response.data.token, true);
            validation.login.ValidationJS.form.html.submit();
        } else {
            console.error(query.response);
        }
    }
}

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

    validation.login.ValidationJS = new ValidationJS({
        id: 'login',
    }, {
        submit: false,
    }, validation.login.rules, validation.login.messages);

    let modals = {
        auth: new ModalJS({
            id: 'auth',
        }),
    };

    if (URL.findHashParameter()) {
        switch (URL.findHashParameter()) {
            case 'login':
                modals.auth.open();
                switchModalContent('login');
                break;
            case 'signin':
                modals.auth.open();
                switchModalContent('signin');
                break;
        }
    }

    if (document.querySelector("a[href='#login']")) {
        document.querySelector("a[href='#login']").addEventListener('click', function (e) {
            modals.auth.open();
            switchModalContent('login');
        });
    }

    document.querySelector("#auth.modal .modal-content #login [type=submit]").addEventListener('click', send);

    getChats();
});