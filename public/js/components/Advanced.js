import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";
import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

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
            this.setValidationJS();
        }
    } 

    static setValidationJS () {
        if (validation.hasOwnProperty("advanced")) {
            if (!validation.advanced.hasOwnProperty("ValidationJS")) {
                validation.advanced.ValidationJS = new ValidationJS({
                    id: "advanced-form",
                    rules: validation.advanced.rules,
                    messages: validation.advanced.messages,
                });
            }
        } else {
            console.error(`validation.advanced does not exist`);
        }
    }
}