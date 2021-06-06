import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { Notification as NotificationJS } from "../../submodules/NotificationJS/js/Notification.js";
import { Validation as ValidationJS } from "../../submodules/ValidationJS/js/Validation.js";

import Token from "./Token.js";

export class Auth extends Class {
    static setEvents () {
        if (document.querySelectorAll(`a[href='#login']`).length) {
            for (const btn of document.querySelectorAll(`a[href='#login']`)) {
                btn.addEventListener('click', function (e) {
                    modals.auth.open();
                    Auth.changeContent('login');
                });
            }
        }
        if (document.querySelectorAll(`a[href='#signin']`).length) {
            for (const btn of document.querySelectorAll(`a[href='#signin']`)) {
                btn.addEventListener('click', function (e) {
                    modals.auth.open();
                    Auth.changeContent('signin');
                });
            }
        }
        document.querySelector(`#auth.modal .modal-content #login [type=submit]`).addEventListener('click', function (e) {
            e.preventDefault();
            Auth.submitForm('login');
        });
        document.querySelector(`#auth.modal .modal-content #login`).addEventListener('submit', function (e) {
            e.preventDefault();
            Auth.submitForm('login');
        });
        document.querySelector(`#auth.modal .modal-content #signin [type=submit]`).addEventListener('click', function (e) {
            e.preventDefault();
            Auth.submitForm('signin');
        });
        document.querySelector(`#auth.modal .modal-content #signin`).addEventListener('submit', function (e) {
            e.preventDefault();
            Auth.submitForm('signin');
        });
    }

    static setModalJS () {
        modals.auth = new ModalJS({
            id: 'auth',
        }, {
            outsideClick: true
        });
        this.setValidationJS();
        this.setEvents();
    }

    static setValidationJS () {
        if (validation.hasOwnProperty('login')) {
            validation.login.ValidationJS = new ValidationJS({
                id: 'login',
                rules: validation.login.rules,
                messages: validation.login.messages,
            }, {
                submit: false,
            });
        } else {
            console.error(`validation.login does not exist`);
        }
        if (validation.hasOwnProperty('signin')) {
            validation.signin.ValidationJS = new ValidationJS({
                id: 'signin',
                rules: validation.signin.rules,
                messages: validation.signin.messages,
            }, {
                submit: false,
            });
        } else {
            console.error(`validation.signin does not exist`);
        }
    }

    static changeContent (section) {
        document.querySelector(`#auth.modal .modal-content #${ (section === 'login' ? 'login' : 'signin') }`).classList.remove('hidden');
        document.querySelector(`#auth.modal .modal-content #${ (section === 'login' ? 'login' : 'signin') }`).classList.add('block');
        document.querySelector(`#auth.modal .modal-content #${ (section === 'login' ? 'signin' : 'login') }`).classList.remove('block');
        document.querySelector(`#auth.modal .modal-content #${ (section === 'login' ? 'signin' : 'login') }`).classList.add('hidden');
    }

    static async submitForm (section) {
        if (!validation[section].ValidationJS.form.html.classList.contains('invalid')) {
            let formData = new FormData(validation[section].ValidationJS.form.html);
            let token = formData.get('_token');
            formData.delete('_token');
            let query = await Fetch.send({
                method: 'POST',
                url: `/api/${ section }`,
            }, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
                'X-CSRF-TOKEN': token,
            }, formData);
            if (query.response.code === 200) {
                Token.save(query.response.data.token);
                validation[section].ValidationJS.form.html.submit();
            }
            if (query.response.code !== 200) {
                new NotificationJS(query.response, {
                    open: true,
                });
                for (const key in query.response.data.errors) {
                    if (Object.hasOwnProperty.call(query.response.data.errors, key)) {
                        const errors = query.response.data.errors[key];
                        let span = document.querySelector(`form#${ section } .support-${ section }_${ key }`);
                        for (const error of errors) {
                            span.innerHTML = error;
                            span.classList.remove('hidden');
                        }
                    }
                }
            }
        }
    }
}

export default Auth;