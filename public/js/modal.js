import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../submodules/ModalJS/js/Modal.js";
import Token from "./token.js";
import { URLServiceProvider as URL } from "../submodules/ProvidersJS/js/URLServiceProvider.js";
import { Validation as ValidationJS } from "../submodules/ValidationJS/js/Validation.js";

export class Modal extends Class {
    constructor (props = {
        id: undefined,
    }) {
        super(props);
        this.checkModalID();
    }

    checkModalID () {
        switch (this.props.id) {
            case 'assigment':
                this.generateAssigmentModalLogic();
                break;
            case 'details':
                this.generateChatDetailsModalLogic();
                break;
            case 'list':
                this.generateChatListModalLogic();
                break;
            case 'login':
                this.generateLogInModalLogic();
                break;
            case 'signin':
                this.generateSignInModalLogic();
                break;
        }
    }

    generateLogInModalLogic () {
        this.setValidationJS();
        this.setModalJS('auth', {
            outsideClick: true,
        });
        this.setModalButtonEvent();
        this.setModalSubmitButonEvent();
    }

    generateSignInModalLogic () {
        this.setValidationJS();
        this.setModalJS('auth', {
            outsideClick: true,
        });
        this.setModalButtonEvent();
        this.setModalSubmitButonEvent();
    }

    generateAssigmentModalLogic () {
        this.setModalJS('assigment', {
            detectHash: true,
            outsideClick: true,
        });
    }

    generateChatListModalLogic () {
        this.setModalJS('chat', {
            detectHash: true,
            open: /chat-/.exec(URL.findHashParameter()),
        });
        this.setModalReturnButtonEvent();
    }

    generateChatDetailsModalLogic () {
        // 
    }

    setValidationJS () {
        if (validation[this.props.id]) {
            this.ValidationJS = new ValidationJS({
                id: this.props.id,
            }, {
                submit: false,
            }, validation[this.props.id].rules, validation[this.props.id].messages);
        } else {
            console.error(`validation.${ this.props.id } does not exist`);
        }
    }

    setModalJS (id, states) {
        this.ModalJS = new ModalJS({
            id: id,
        }, states);
    }

    changeModalContent () {
        switch (this.props.id) {
            case 'login':
            case 'signin':
                document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? 'login' : 'signin') }`).classList.remove('hidden');
                document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? 'login' : 'signin') }`).classList.add('block');
                document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? 'signin' : 'login') }`).classList.remove('block');
                document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? 'signin' : 'login') }`).classList.add('hidden');
                break;
            case 'list':
            case 'details':
                document.querySelector(`#chat.modal .modal-content #${ (this.props.id === 'list' ? 'list' : 'details') }`).classList.remove('block');
                document.querySelector(`#chat.modal .modal-content #${ (this.props.id === 'list' ? 'list' : 'details') }`).classList.add('hidden');
                document.querySelector(`#chat.modal .modal-content #${ (this.props.id === 'list' ? 'details' : 'list') }`).classList.remove('hidden');
                document.querySelector(`#chat.modal .modal-content #${ (this.props.id === 'list' ? 'details' : 'list') }`).classList.add('block');
                break;
        }
    }

    setModalReturnButtonEvent () {
        const instance = this;
        const btn = document.querySelector(`#chat.modal #details header > a`);
        if (btn) {
            btn.addEventListener('click', function (e) {
                instance.setProps('id', 'details');
                instance.changeModalContent();
            });
        }
    }

    setModalButtonEvent () {
        const instance = this;
        const btn = document.querySelectorAll(`a[href='#${ this.props.id }']`);
        if (document.querySelectorAll(`a[href='#${ this.props.id }']`).length) {
            for (const btn of document.querySelectorAll(`a[href='#${ this.props.id }']`)) {
                btn.addEventListener('click', function (e) {
                    instance.ModalJS.open();
                    instance.changeModalContent();
                });
            }
        }
    }

    setModalSubmitButonEvent () {
        const instance = this;
        document.querySelector(`#auth.modal .modal-content #${ this.props.id } [type=submit]`).addEventListener('click', function (e) {
            e.preventDefault();
            instance.submitModalForm();
        });
        document.querySelector(`#auth.modal .modal-content #${ this.props.id }`).addEventListener('submit', function (e) {
            e.preventDefault();
            instance.submitModalForm();
        });
    }

    async submitModalForm () {
        let formData = new FormData(this.ValidationJS.form.html);
        let token = formData.get('_token');
        formData.delete('_token');
        let query = await Fetch.send({
            method: 'POST',
            url: `/api/${ this.props.id }`,
        }, {
            'Accept': 'application/json',
            'Content-type': 'application/json; charset=UTF-8',
            'X-CSRF-TOKEN': token,
        }, formData);
        if (!this.ValidationJS.form.html.classList.contains('invalid')) {
            if (query.response.code === 200) {
                Token.save(query.response.data.token);
                this.ValidationJS.form.html.submit();
            }
        }
    }
}

export default Modal;