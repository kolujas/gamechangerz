import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

export class Lesson extends Class {
    static setModalJS () {
        modals.lessons = new ModalJS({
            id: 'lessons',
        }, {
            open: URL.findHashParameter() === 'lessons',
            detectHash: true,
            outsideClick: true,
        });
    }
}

export default Lesson;