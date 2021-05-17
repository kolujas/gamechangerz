import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../submodules/ModalJS/js/Modal.js";
import { Notification as NotificationJS } from "../submodules/NotificationJS/js/Notification.js";
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
                this.youtubeConverter();
                break;
            case 'details':
                this.generateChatDetailsModalLogic();
                break;
            case 'games':
                this.generateGamesModalLogic();
                break;
            case 'list':
                this.generateChatListModalLogic();
                break;
            case 'details':
                this.generateChatDetailsModalLogic();
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
            open: /assigment-/.exec(URL.findHashParameter()),
        });
    }

    generateGamesModalLogic () {
        this.setModalJS('games', {
            open: URL.findHashParameter() === 'games',
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
                rules: validation[this.props.id].rules,
                messages: validation[this.props.id].messages,
            }, {
                submit: false,
            }, {});
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
        if (!this.ValidationJS.form.html.classList.contains('invalid')) {
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
            if (query.response.code === 200) {
                Token.save(query.response.data.token);
                this.ValidationJS.form.html.submit();
            }
            if (query.response.code !== 200) {
                new NotificationJS(query.response, {
                    open: true,
                });
                for (const key in query.response.data.errors) {
                    if (Object.hasOwnProperty.call(query.response.data.errors, key)) {
                        const errors = query.response.data.errors[key];
                        let span = document.querySelector(`form#${ this.props.id } .support-${ this.props.id }_${ key }`);
                        for (const error of errors) {
                            span.innerHTML = error;
                            span.classList.remove('hidden');
                        }
                    }
                }
            }
        }
    }

    youtubeConverter(){
        document.querySelector('#url').addEventListener("change", function(){
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = this.value.match(regExp);
            let videoId;
            if (match && match[2].length == 11) {
                videoId = match[2];
            }else {
                videoId = 'error';
            }
            
            $('#myVideo').html('<iframe src="//www.youtube.com/embed/' + videoId + '" frameborder="0" allowfullscreen></iframe>');
        })
    }
}

export default Modal;