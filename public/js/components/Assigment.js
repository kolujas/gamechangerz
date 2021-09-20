import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";
import { Html } from "../../submodules/HTMLCreatorJS/js/HTMLCreator.js";

import Presentation from "./Presentation.js";
import Token from "./Token.js";

export class Assigment extends Class {
    constructor (props) {
        super(props);
        for (const support of document.querySelectorAll("#assigment-form .support")) {
            support.innerHTML = "";
            support.classList.add("hidden");
        }

        document.querySelector("#assigment-form").action = `/api/lessons/chats/${ this.props.id_chat }/assigments/make`;

        if (this.props.id_assigment) {
            this.createAssigmentView();
        } else {
            this.createAssigmentUpdate();
            modals.assigment.open();
        }
    }

    async createAssigmentView () {
        const instance = this;
        for (const input of document.querySelectorAll("#assigment.modal .form-input")) {
            switch (input.nodeName) {
                case "INPUT":
                    switch (input.name.toUpperCase()) {
                        case "URL":
                            if (this.props.url) {
                                input.value = this.props.url;
                                var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                                var match = input.value.match(regExp);
                                let videoId;
                                if (match && match[2].length == 11) {
                                    videoId = match[2];
                                }else {
                                    videoId = "error";
                                }
                                
                                if (videoId == "error") {
                                    $("#assigment-video").html(`<a href="${ input.value }" class="w-full russo color-black btn btn-one btn-outline" target="_blank"><span class="px-4 py-2 text-lg">Link</span></a>`);
                                }
                                if (videoId != "error") {
                                    $("#assigment-video").html(`<iframe src="//www.youtube.com/embed/${ videoId }" frameborder="0" allowfullscreen></iframe>`);
                                }
                            }
                            break;
                    }
                    input.disabled = true;
                    for (const child of input.parentNode.children) {
                        if (child.nodeName === "H3") {
                            child.classList.add("hidden");
                        }
                    }
                    break;
                default:
                    switch (input.name.toUpperCase()) {
                        case "DESCRIPTION":
                            input.value = this.props.description;
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === "H3" || child.classList.contains("extra")) {
                                    child.classList.add("hidden");
                                }
                            }
                            break;
                    }
                    input.disabled = true;
                    break;
            }
        }
        document.querySelector("#assigment.modal .form-submit").classList.add("hidden");
        let link;
        if (document.querySelector("#assigment.modal .form-submit + a")) {
            link = document.querySelector("#assigment.modal .form-submit + a");
            link.parentNode.removeChild(link);
        }
        let classes = ["btn", "btn-background", "btn-one", "flex", "justify-center", "w-full", "rounded", "p-1", "md:h-12", "md:items-center", "mt-12", "russo"];
        let innerHTML = "Entregar";

        if (this.props.id_role === 0) {
            if (this.hasProp("presentation") && this.props.presentation) {
                innerHTML = "Revisar entrega";
            }
            if (!this.hasProp("presentation") || !this.props.presentation) {
                classes.push("hidden");
            }
        }
        if (this.props.id_role === 1) {
            if (this.hasProp("presentation") && this.props.presentation) {
                innerHTML = "Revisar entrega";
            }
        }
        link = new Html("a", {
            props: {
                url: `#`,
                classes: classes
            }, innerHTML: [
                ["div", {
                    props: {
                        classes: ["loading", "hidden"],
                    }, innerHTML: [
                        ["i", {
                            props: {
                                classes: ["spinner-icon"],
                            },
                        }],
                    ],
                }],
                ["span", {
                    props: {
                        classes: ["py-2", "px-4"]
                    }, innerHTML: innerHTML
                }]
            ], callback: {
                function: instance.createPresentation,
                params: {
                    instance: this,
                }
            }, state: {
                preventDefault: true,
            }
        });
        document.querySelector("#assigment.modal .form-submit").parentNode.appendChild(link.html);
    }

    createPresentation (params) {
        modals.assigment.close();
        new Presentation({
            ...params.instance.props
        });
    }

    createAssigmentUpdate () {
        for (const input of document.querySelectorAll("#assigment.modal .form-input")) {
            switch (input.nodeName) {
                case "INPUT":
                    switch (input.name.toUpperCase()) {
                        case "URL":
                            input.value = "";
                            $("#assigment-video").html("");
                            break;
                    }
                    input.disabled = false;
                    for (const child of input.parentNode.children) {
                        if (child.nodeName === "H3") {
                            child.classList.remove("hidden");
                        }
                    }
                    break;
                default:
                    switch (input.name.toUpperCase()) {
                        case "DESCRIPTION":
                            input.value = "";
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === "H3") {
                                    child.classList.remove("hidden");
                                }
                            }
                            break;
                    }
                    input.disabled = false;
                    break;
            }
        }
        document.querySelector("#assigment.modal .form-submit").classList.remove("hidden");
        if (document.querySelector("#assigment.modal .form-submit + a")) {
            let link = document.querySelector("#assigment.modal .form-submit + a");
            link.parentNode.removeChild(link);
        }
    }

    static setModalJS () {
        if (!modals.hasOwnProperty("assigment")) {
            modals.assigment = new ModalJS({
                id: "assigment",
            }, {
                outsideClick: true,
            }, {
                open: { function: Assigment.open },
                close: { function: Assigment.close }
            });
            this.setURLEvent();
        }
    }
    
    static close (params) {
        window.history.pushState({}, document.title, `#chat`);
    }
    
    static open (params) {
        if (params.hasOwnProperty("id_chat")) {
            new Assigment({
                id_chat: params.id_chat,
                ...params.assigment,
                id_role: params.id_role,
            });
        }
    }

    static setURLEvent () {
        document.querySelector("#assigment.modal input[name=url]").addEventListener("change", function(){
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = this.value.match(regExp);
            let videoId;
            if (match && match[2].length == 11) {
                videoId = match[2];
            }else {
                videoId = "error";
            }
            
            if (videoId == "error") {
                $("#assigment-video").html(`<a href="${ this.value }" class="w-full russo color-black btn btn-one btn-outline" target="_blank"><span class="px-4 py-2 text-lg">Link</span></a>`);
            }
            if (videoId != "error") {
                $("#assigment-video").html(`<iframe src="//www.youtube.com/embed/${ videoId }" frameborder="0" allowfullscreen></iframe>`);
            }
        });
    }

    static setValidationJS (callback) {
        if (validation.hasOwnProperty("assigment")) {
            if (!validation.assigment.hasOwnProperty("ValidationJS")) {
                validation.assigment.ValidationJS = new ValidationJS({
                    id: "assigment-form",
                    rules: validation.assigment.rules,
                    messages: validation.assigment.messages,
                }, {
                    submit: false,
                }, {
                    valid: {
                        function: callback.function,
                        params: callback.params
                }});
            }
        } else {
            console.error(`validation.assigment does not exist`);
        }
    }

    static async submit () {
        const token = Token.get();

        if (!validation.assigment.ValidationJS.html.classList.contains("invalid")) {
            let formData = new FormData(document.querySelector(`#assigment.modal #assigment-form`));
            let _token = formData.get("_token");
            formData.delete("_token");

            let query = await Fetch.send({
                method: "POST",
                url: document.querySelector("#assigment-form").action,
            }, {
                "Accept": "application/json",
                "Content-type": "application/json; charset=UTF-8",
                "X-CSRF-TOKEN": _token,
                "Authorization": "Bearer " + token.data,
            }, formData);

            return query.response;
        }
    }

    static async one (id_assigment) {
        const token = Token.get();

        let query = await Fetch.get(`/api/assigments/${ id_assigment }`, {
            "Accept": "application/json",
            "Authorization": "Bearer " + token.data,
        });

        if (query.response.code != 200) {
            return 404;
        }

        return query.response.data.assigment;
    }
}

export default Assigment;