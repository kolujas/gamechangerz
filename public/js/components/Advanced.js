import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

export default class Advanced extends Class{
    static setModalJS() {
        if (!modals.hasOwnProperty('advanced')) {
            modals.advanced = new ModalJS({
                id: 'advanced',
            }, {
                open: /advanced/.exec(URL.findHashParameter()),
                detectHash: true,
                outsideClick: true,
            });
        }
    } 
}