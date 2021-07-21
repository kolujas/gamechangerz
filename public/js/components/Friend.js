import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

export class Friend extends Class {
    static setModalJS () {
        if (!modals.hasOwnProperty("friends")) {
            modals.friends = new ModalJS({
                id: 'friends',
            }, {
                open: URL.findHashParameter() === 'friends',
                detectHash: true,
                outsideClick: true,
            });
        }
    }
}

export default Friend;