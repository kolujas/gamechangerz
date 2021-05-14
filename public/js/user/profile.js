import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

if (document.querySelector(".teacher")) {
    document.querySelector(".teacher .profile .info .username input").setAttribute('style', `--width: ${ document.querySelector(".teacher .profile .info .username input").value.length }ch`);
    document.querySelector(".teacher .profile .info .name input").setAttribute('style', `--width: ${ document.querySelector(".teacher .profile .info .name input").value.length }ch`);
}
document.addEventListener('DOMContentLoaded', function (e) {
    new TabMenuJS({
        id: 'horarios'
    },{
        open: ['online'],
        active: 'online',
    });

    if (document.querySelector(".teacher")) {
        document.querySelector(".teacher .profile .info .username input").addEventListener('keyup', function (e) {
            this.setAttribute('style', `--width: ${ this.value.length }ch`);
        });

        document.querySelector(".teacher .profile .info .name input").addEventListener('keyup', function (e) {
            this.setAttribute('style', `--width: ${ this.value.length }ch`);
        });
    }

    let modals = {};
    if (authenticated) {
        if (document.querySelector('#games.modal')) {
            modals.games = new ModalJS({
                id: 'games',
            }, {
                open: URL.findHashParameter() === 'games',
                detectHash: true,
                outsideClick: true,
            });
        }
    }
});