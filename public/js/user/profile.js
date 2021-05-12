import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";

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
});