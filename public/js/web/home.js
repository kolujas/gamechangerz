import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";

modals.poll = new ModalJS({
    id: "poll",
},{
    detectHash: true,
    open: true,
    outsideClick: true
});

const sr = ScrollReveal();

sr.reveal('#poll.modal .modal-content', {
    duration: 1500,
    ease: 'ease-in-out',
})

