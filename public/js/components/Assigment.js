import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";
import { Validation as ValidationJS } from "../../submodules/ValidationJS/js/Validation.js";

import Asset from "./Asset.js";

let hash = 'chat';

export class Assigment extends Class {
    constructor (props) {
        super(props);
        if (this.props.games) {
            this.createGameOptions(this.props.games);
            this.createAssigmentUpdate();
            modals.assigment.open();
        }
        if (this.props.id_assigment) {
            this.createGameOptions();
            this.createAssigmentView();
        }
    }

    createAssigmentView () {
        this.changeAbilities();
        for (const input of document.querySelectorAll('#assigment.modal .form-input')) {
            switch (input.nodeName) {
                case 'INPUT':
                    switch (input.type.toUpperCase()) {
                        case 'CHECKBOX':
                            for (const ability of this.props.abilities) {
                                if (parseInt(input.value) === parseInt(ability.id_ability)) {
                                    input.checked = true;
                                }
                            }
                            input.disabled = true;
                            break;
                        default:
                            switch (input.name.toUpperCase()) {
                                case 'TITLE':
                                    input.value = this.props.title;
                                    break;
                                case 'URL':
                                    input.value = this.props.url;
                                    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                                    var match = input.value.match(regExp);
                                    let videoId;
                                    if (match && match[2].length == 11) {
                                        videoId = match[2];
                                    }else {
                                        videoId = 'error';
                                    }
                                    
                                    $('#myVideo').html('<iframe src="//www.youtube.com/embed/' + videoId + '" frameborder="0" allowfullscreen></iframe>');
                                    break;
                            }
                            input.disabled = true;
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === 'H3') {
                                    child.classList.add("hidden");
                                }
                            }
                            break;
                    }
                    break;
                default:
                    switch (input.name.toUpperCase()) {
                        case 'DESCRIPTION':
                            input.value = this.props.description;
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === 'H3') {
                                    child.classList.add("hidden");
                                }
                            }
                            break;
                        case 'ID_GAME':
                            for (const game of input.options) {
                                if (parseInt(game.value) === parseInt(this.props.id_game)) {
                                    game.selected = true;
                                }
                            }
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === 'H3') {
                                    child.innerHTML = "Juego";
                                }
                            }
                            break;
                    }
                    input.disabled = true;
                    break;
            }
        }
        document.querySelector('#assigment.modal .form-submit').classList.add('hidden');
    }

    createAssigmentUpdate () {
        document.querySelector('#assigment.modal .abilities h3').classList.add('hidden');
        let parent = document.querySelector('#assigment.modal .abilities div');
        parent.innerHTML = '';
        for (const input of document.querySelectorAll('#assigment.modal .form-input')) {
            switch (input.nodeName) {
                case 'INPUT':
                    switch (input.type.toUpperCase()) {
                        case 'CHECKBOX':
                            input.disabled = false;
                            break;
                        default:
                            switch (input.name.toUpperCase()) {
                                case 'TITLE':
                                    input.value = '';
                                    break;
                                case 'URL':
                                    input.value = '';
                                    $('#myVideo').html('');
                                    break;
                            }
                            input.disabled = false;
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === 'H3') {
                                    child.classList.remove("hidden");
                                }
                            }
                            break;
                    }
                    break;
                default:
                    switch (input.name.toUpperCase()) {
                        case 'DESCRIPTION':
                            input.value = '';
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === 'H3') {
                                    child.classList.remove("hidden");
                                }
                            }
                            break;
                        case 'ID_GAME':
                            for (const child of input.parentNode.children) {
                                if (child.nodeName === 'H3') {
                                    child.innerHTML = "Elegí un juego";
                                }
                            }
                            break;
                    }
                    input.disabled = false;
                    break;
            }
        }
        document.querySelector('#assigment.modal .form-submit').classList.remove('hidden');
    }

    createGameOptions (games = [this.props.game]) {
        let instance = this;
        let select = document.querySelector('#assigment.modal select');
        select.innerHTML = "";
            let option = document.createElement('option');
            option.selected = true;
            option.disabled = true;
            option.classList.add('overpass');
            option.innerHTML = "Elegi un juego";
            select.appendChild(option);
        select.addEventListener('change', function (e) {
            let game;
            for (game of games) {
                if (game === this.options[this.selectedIndex]) {
                    break;
                }
            }
            instance.changeAbilities(game.abilities);
        });
        for (const game of games) {
            option = document.createElement('option');
            option.value = game.id_game;
            option.innerHTML = game.name;
            option.classList.add('overpass');
            select.appendChild(option);
        }
    }

    changeAbilities (abilities = this.props.game.abilities) {
        document.querySelector('#assigment.modal .abilities h3').classList.remove('hidden');
        let parent = document.querySelector('#assigment.modal .abilities div');
        parent.innerHTML = '';
        for (const ability of abilities) {
            let label = document.createElement('label');
            parent.appendChild(label);
                let input = document.createElement('input');
                input.classList.add("hidden", "abilitie", "form-input");
                input.name = `abilities[${ ability.id_ability }]`;
                input.value = ability.id_ability;
                input.type = "checkbox";
                label.appendChild(input);
                
                let div = document.createElement('div');
                div.classList.add("flex", "justify-between", "p-2", "flex", "items-center");
                label.appendChild(div);
                    let span = document.createElement('span');
                    span.classList.add("color-white", "mr-1", "overpass");
                    span.innerHTML = ability.name;
                    div.appendChild(span);

                    let figure = document.createElement('figure');
                    div.appendChild(figure);
                        let image = document.createElement('img');
                        image.src = new Asset(`img/abilities/${ ability.icon }.svg`).route;
                        figure.appendChild(image);
        }
    }
    
    static getChatHash (params) {
        if (/chat/.exec(URL.findHashParameter())) {
            hash = URL.findHashParameter();
        }
        new Assigment({
            ...params.assigment
        });
    }
    
    static setChatHash (params) {
        window.history.pushState({}, document.title, `#${ hash }`);
    }

    static setModalJS (callback) {
        modals.assigment = new ModalJS({
            id: 'assigment',
        }, {
            outsideClick: true,
            open: /^assigment-/.exec(URL.findHashParameter()),
        }, {
            open: { function: Assigment.getChatHash },
            close: { function: Assigment.setChatHash }
        });
        this.setURLEvent();
    }

    static setURLEvent () {
        document.querySelector('#assigment.modal input[name=url]').addEventListener("change", function(){
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = this.value.match(regExp);
            let videoId;
            if (match && match[2].length == 11) {
                videoId = match[2];
            }else {
                videoId = 'error';
            }
            
            $('#myVideo').html('<iframe src="//www.youtube.com/embed/' + videoId + '" frameborder="0" allowfullscreen></iframe>');
        });
    }

    static setValidationJS (callback) {
        if (validation.hasOwnProperty('assigment')) {
            if (!validation.assigment.hasOwnProperty('ValidationJS')) {
                validation.assigment.ValidationJS = new ValidationJS({
                    id: 'assigment-form',
                    rules: validation.assigment.rules,
                    messages: validation.assigment.messages,
                }, {
                    submit: false,
                }, {
                    submit: {
                        function: callback.function,
                        params: callback.params
                }});
            }
        } else {
            console.error(`validation.assigment does not exist`);
        }
    }

    static async submitForm (id_chat, BearerToken) {
        if (!validation.assigment.ValidationJS.form.html.classList.contains('invalid')) {
            let formData = new FormData(document.querySelector(`#assigment.modal #assigment-form`));
            let token = formData.get('_token');
            formData.delete('_token');
            let query = await Fetch.send({
                method: 'POST',
                url: `/api/lessons/chats/${ id_chat }/assigments/make`,
            }, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
                'X-CSRF-TOKEN': token,
                'Authorization': "Bearer " + BearerToken,
            }, formData);
            return query.response;
        }
    }
}

export default Assigment;