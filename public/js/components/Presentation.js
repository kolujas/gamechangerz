import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

import Token from "./Token.js";

export default class Presentation extends Class {
    constructor (props) {
        super(props);
        for (const support of document.querySelectorAll("#presentation-form .support")) {
            support.innerHTML = "";
            support.classList.add("hidden");
        }

        document.querySelector("#presentation-form").action = `/api/lessons/chats/${ this.props.id_chat }/assigments/${ this.props.id_assigment }/complete`;

        modals.presentation.open();
        if (this.hasProp('presentation') && this.props.presentation) {
            this.setPresentation();
        }
        if (!this.hasProp('presentation') || !this.props.presentation) {
            this.setForm();
        }
    }

    setPresentation () {
        for (const description of document.querySelectorAll('#presentation.modal :where(h3, .extra)')) {
            description.classList.add("hidden");
        }
        for (const input of document.querySelectorAll("#presentation-form .form-input")) {
            if (input.name === "description") {
                input.value = this.props.presentation.description;
                input.disabled = true;
            }
            if (input.name === "url") {
                input.disabled = true;
                if (this.props.presentation.url) {
                    input.value = this.props.presentation.url;
    
                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                    var match = input.value.match(regExp);
                    let videoId;
                    if (match && match[2].length == 11) {
                        videoId = match[2];
                    }else {
                        videoId = 'error';
                    }
    
                    if (videoId == "error") {
                        $("#presentation-video").html(`<a href="${ input.value }" class="w-full russo color-black btn btn-one btn-outline" target="_blank"><span class="px-4 py-2 text-lg">Link</span></a>`);
                    }
                    if (videoId != "error") {
                        $("#presentation-video").html(`<iframe src="//www.youtube.com/embed/${ videoId }" frameborder="0" allowfullscreen></iframe>`);
                    }
                }
            }
        }
        document.querySelector('#presentation.modal .form-submit').classList.add('hidden');
    }

    setForm () {
        for (const description of document.querySelectorAll('#presentation.modal h3')) {
            description.classList.remove("hidden");
        }
        $('#presentation-video').html('');
        for (const input of document.querySelectorAll("#presentation-form .form-input")) {
            if (input.name !== "_token" && input.name !== "_method") {
                input.value = "";
                input.disabled = false;
            }
        }
        document.querySelector('#presentation.modal .form-submit').classList.remove('hidden');
    }

    static setModalJS () {
        if (!modals.hasOwnProperty('presentation')) {
            modals.presentation = new ModalJS({
                id: 'presentation',
            }, {
                outsideClick: true,
            }, {
                close: { function: Presentation.close }
            });
            this.setURLEvent();
        }
    }
    
    static close (params) {
        window.history.pushState({}, document.title, `#chat`);
    }

    static setURLEvent () {
        document.querySelector('#presentation.modal input[name=url]').addEventListener("change", function(){
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = this.value.match(regExp);
            let videoId;
            if (match && match[2].length == 11) {
                videoId = match[2];
            }else {
                videoId = 'error';
            }
            
            if (videoId == "error") {
                $("#presentation-video").html(`<a href="${ this.value }" class="w-full russo color-black btn btn-one btn-outline" target="_blank"><span class="px-4 py-2 text-lg">Link</span></a>`);
            }
            if (videoId != "error") {
                $("#presentation-video").html(`<iframe src="//www.youtube.com/embed/${ videoId }" frameborder="0" allowfullscreen></iframe>`);
            }
        });
    }

    static setValidationJS (callback) {
        if (validation.hasOwnProperty('presentation')) {
            if (!validation.presentation.hasOwnProperty('ValidationJS')) {
                validation.presentation.ValidationJS = new ValidationJS({
                    id: 'presentation-form',
                    rules: validation.presentation.rules,
                    messages: validation.presentation.messages,
                }, {
                    submit: false,
                }, {
                    valid: {
                        function: callback.function,
                        params: callback.params
                }});
            }
        } else {
            console.error(`validation.presentation does not exist`);
        }
    }

    static async submit () {
        const token = Token.get();

        if (!validation.presentation.ValidationJS.html.classList.contains('invalid')) {
            let formData = new FormData(document.querySelector(`#presentation.modal #presentation-form`));
            let _token = formData.get('_token');
            formData.delete('_token');

            let query = await Fetch.send({
                method: 'POST',
                url: document.querySelector("#presentation-form").action,
            }, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
                'X-CSRF-TOKEN': _token,
                'Authorization': "Bearer " + token.data,
            }, formData);

            return query.response;
        }
    }
}