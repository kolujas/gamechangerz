import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

export class Language extends Class {
    static setModalJS () {
        modals.languages = new ModalJS({
            id: 'languages',
        }, {
            open: URL.findHashParameter() === 'languages',
            detectHash: true,
            outsideClick: true,
        });
    }
}

export default Language;