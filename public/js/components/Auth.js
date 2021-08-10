import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { Notification as NotificationJS } from "../../submodules/NotificationJS/js/Notification.js";
import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

import Token from "./Token.js";

export class Auth extends Class {
    constructor () {
        super({  }, {
            section: "login",
            status: "waiting",
        });

        this.setValidationJS();
        this.setModalJS();
        if (modals.hasOwnProperty("auth")) {
            this.htmls = {
                login: modals.auth.html.children[0].children[0],
                signin: modals.auth.html.children[0].children[1],
            };
        }
        this.setEvents();
    }

    setEvents () {
        if (document.querySelectorAll(`a[href="#login"]`).length) {
            for (const btn of document.querySelectorAll(`a[href="#login"]`)) {
                btn.addEventListener("click", (e) => {
                    modals.auth.open();
                    this.changeSectionState("login");
                });
            }
        }
        if (document.querySelectorAll(`a[href="#signin"]`).length) {
            for (const btn of document.querySelectorAll(`a[href="#signin"]`)) {
                btn.addEventListener("click", (e) => {
                    modals.auth.open();
                    this.changeSectionState("signin");
                });
            }
        }
    }

    setFinishState () {
        this.setState("status", "waiting");
        for (const btn of document.querySelectorAll("#auth.modal button[type=submit]")) {
            for (const child of [...btn.children]) {
                child.classList.add("hidden");
                if (child.nodeName === "SPAN") {
                    child.classList.remove("hidden");
                }
            }
        }
    }

    setLoadingState () {
        this.setState("status", "loading");
        for (const btn of document.querySelectorAll("#auth.modal button[type=submit]")) {
            for (const child of [...btn.children]) {
                child.classList.add("hidden");
                if (child.nodeName === "DIV") {
                    child.classList.remove("hidden");
                }
            }
        }
    }

    setModalJS () {
        if (!modals.hasOwnProperty("auth")) {
            modals.auth = new ModalJS({
                id: "auth",
            }, {
                outsideClick: true
            });
        }
    }

    setValidationJS () {
        if (validation.hasOwnProperty("login")) {
            validation.login.ValidationJS = new ValidationJS({
                id: "login",
                rules: validation.login.rules,
                messages: validation.login.messages,
            }, {
                submit: false,
            }, {
                valid: {
                    function: this.submit,
                    params: {
                        section: "login",
                        authenticated: this,
                    }
                }
            });
        } else {
            console.error(`validation.login does not exist`);
        }
        if (validation.hasOwnProperty("signin")) {
            validation.signin.ValidationJS = new ValidationJS({
                id: "signin",
                rules: validation.signin.rules,
                messages: validation.signin.messages,
            }, {
                submit: false,
            }, {
                valid: {
                    function: this.submit,
                    params: {
                        section: "signin",
                        authenticated: this,
                    }
                }
            });
        } else {
            console.error(`validation.signin does not exist`);
        }
    }

    changeSectionState (section) {
        if (this.state.status === "waiting") {
            this.setState("section", section);
            this.htmls[this.state.section].classList.add("block");
            this.htmls[this.state.section].classList.remove("hidden");
            this.htmls[this.state.section === "signin" ? "login" : "signin"].classList.add("hidden");
            this.htmls[this.state.section === "signin" ? "login" : "signin"].classList.remove("block");
        }
    }

    async submit (params = []) {
        if (params.authenticated.state.status === "waiting") {
            params.authenticated.setLoadingState();
            let formData = new FormData(params.Form.html);
            let token = formData.get("_token");
            formData.delete("_token");
            let query = await Fetch.send({
                method: "POST",
                url: `/api/${ params.section }`,
            }, {
                "Accept": "application/json",
                "Content-type": "application/json; charset=UTF-8",
                "X-CSRF-TOKEN": token,
            }, formData);
            if (query.response.code === 200) {
                Token.save(query.response.data.token);
                params.Form.html.submit();
            }
            if (query.response.code !== 200) {
                new NotificationJS(query.response, {
                    open: true,
                });
                for (const key in query.response.data.errors) {
                    if (Object.hasOwnProperty.call(query.response.data.errors, key)) {
                        const errors = query.response.data.errors[key];
                        let span = document.querySelector(`form#${ params.section } .support-${ params.section }_${ key }`);
                        for (const error of errors) {
                            span.innerHTML = error;
                            span.classList.remove("hidden");
                        }
                    }
                }
                params.authenticated.setFinishState(query.response.code);
            }
        }
    }
}

export default Auth;