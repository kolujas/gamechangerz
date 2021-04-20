import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../submodules/ModalJS/js/Modal.js";
import Token from "./token.js";
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
        this.setModalJS('auth');
        this.setModalButtonEvent();
        this.setModalSubmitButonEvent();
    }

    generateSignInModalLogic () {
        this.setValidationJS();
        this.setModalJS('auth');
        this.setModalButtonEvent();
        this.setModalSubmitButonEvent();
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

    setModalJS (id) {
        this.ModalJS = new ModalJS({
            id: id,
        }, {
            outsideClick: true,
        });
    }

    changeAuthModalContent () {
        document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? this.props.id : 'signin') }`).classList.remove('hidden');
        document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? this.props.id : 'signin') }`).classList.add('block');
        document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? 'signin' : this.props.id) }`).classList.remove('hblock');
        document.querySelector(`#auth.modal .modal-content #${ (this.props.id === 'login' ? 'signin' : this.props.id) }`).classList.add('hidden');
    }

    setModalButtonEvent () {
        const instance = this;
        const btn = document.querySelector(`a[href='#${ this.props.id }']`);
        if (btn) {
            btn.addEventListener('click', function (e) {
                instance.ModalJS.open();
                instance.changeAuthModalContent();
            });
        }
    }

    setModalSubmitButonEvent () {
        const instance = this;
        document.querySelector(`#auth.modal .modal-content #${ this.props.id } [type=submit]`).addEventListener('click', function (e) {
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