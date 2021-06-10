import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { Validation as ValidationJS } from "../../submodules/ValidationJS/js/Validation.js";
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

    static setValidationJS () {
        if (validation.hasOwnProperty('languages')) {
            validation.languages.ValidationJS = new ValidationJS({
                id: 'languages-form',
                rules: validation.languages.rules,
                messages: validation.languages.messages,
            });
        } else {
            console.error(`validation.languages does not exist`);
        }
    }
}

export default Language;