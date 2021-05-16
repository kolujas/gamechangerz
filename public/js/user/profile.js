import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import Modal from "../modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";
import { Validation as ValidationJS } from "../../submodules/ValidationJS/js/Validation.js";

function changeProfileState (state) {
    switch (state) {
        case 'update':
            for (const input of document.querySelectorAll('.update-input')) {
                if (input.disabled) {
                    input.disabled = false;
                    if (input.classList.contains('hidden') && input.name === 'name') {
                        input.classList.remove('hidden');
                    }
                } else {
                    input.disabled = true;
                    if (!input.classList.contains('hidden') && input.name === 'name') {
                        input.classList.add('hidden');
                    }
                }
            }
            for (const btn of document.querySelectorAll('.update-button')) {
                if (btn.classList.contains('confirm')) {
                    btn.classList.remove('hidden');
                }
                if (btn.classList.contains('cancel')) {
                    btn.classList.remove('hidden');
                }
                if (!btn.classList.contains('confirm') && !btn.classList.contains('cancel')) {
                    btn.classList.add('hidden');
                }
            }
            break;
    }
}

document.addEventListener('DOMContentLoaded', function (e) {
    new TabMenuJS({
        id: 'horarios'
    },{
        open: ['online'],
        active: 'online',
    });

    if (document.querySelector(".teacher")) {
        let username_input = document.querySelector(".teacher .profile .info .username input");
        let username_text = document.querySelector(".teacher .profile .info .username span");
        username_text.innerHTML = document.querySelector(".teacher .profile .info .username input").value;
        username_input.setAttribute('style', `width: ${ username_text.offsetWidth }px`);
        let name_input = document.querySelector(".teacher .profile .info .name input");
        let name_text = document.querySelector(".teacher .profile .info .name span");
        name_text.innerHTML = document.querySelector(".teacher .profile .info .name input").value;
        name_input.setAttribute('style', `width: ${ name_text.offsetWidth }px`);
        username_input.addEventListener('keyup', function (e) {
            e.preventDefault();
            username_text.innerHTML = username_input.value;
            username_input.setAttribute('style', `width: ${ username_text.offsetWidth }px`);
        });
        name_input.addEventListener('keyup', function (e) {
            e.preventDefault();
            name_text.innerHTML = name_input.value;
            name_input.setAttribute('style', `width: ${ name_text.offsetWidth }px`);
        });
    }

    let modals = {};
    if (authenticated) {
        if (document.querySelector('#games.modal')) {
            modals.games = new Modal({
                id: 'games',
            });
        }
        if (document.querySelector('#lessons.modal')) {
            modals.lessons = new ModalJS({
                id: 'lessons',
            }, {
                open: URL.findHashParameter() === 'lessons',
                detectHash: true,
                outsideClick: true,
            });
        }
        if (document.querySelector('#friends.modal')) {
            modals.friends = new ModalJS({
                id: 'friends',
            }, {
                open: URL.findHashParameter() === 'friends',
                detectHash: true,
                outsideClick: true,
            });
        }
        if (document.querySelector('#achievements.modal')) {
            console.log();
            modals.achievements = new ModalJS({
                id: 'achievements',
            }, {
                open: URL.findHashParameter() === 'achievements',
                detectHash: true,
                outsideClick: true,
            });
        }

        if (document.querySelectorAll('.update-button').length) {
            validation['update'].ValdiationJS = new ValidationJS({
                id: 'update-form',
            }, { }, validation['update']['rules'], validation['update']['messages']);
            if (URL.findHashParameter() === 'update') {
                changeProfileState('update');
            }
            for (const btn of document.querySelectorAll('a.update-button')) {
                btn.addEventListener('click', function (e) {
                    changeProfileState('update');
                });
            }
            for (const btn of document.querySelectorAll('button.update-button')) {
                btn.addEventListener('click', function (e) {
                    if (btn.classList.contains('cancel')) {
                        window.location.href = window.location.href.split('#')[0];
                    }
                    changeProfileState((btn.classList.contains('confirm') ? 'confirm' : 'cancel'));
                });
            }
        }
    }
});