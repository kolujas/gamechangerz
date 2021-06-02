import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";

modals.poll = new ModalJS({
    id: "poll",
},{
    detectHash: true,
    open: true,
    outsideClick: true
});