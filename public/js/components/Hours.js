import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";



export class Hours extends Class{

    static setModalJS () {
        if (!modals.hasOwnProperty("hours")) {
            modals.hours = new ModalJS({
                id: "hours",
            },{
                detectHash: true,
                outsideClick: true
            });
        }
    }
}

export default Hours;

