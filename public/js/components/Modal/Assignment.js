import { FetchServiceProvider as Fetch } from "../../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { URLServiceProvider as URL } from "../../../submodules/ProvidersJS/js/URLServiceProvider.js";

import Layout from "./Layout.js";
import { default as Model } from "../Models/Assignment.js";
import User from "../Models/User.js";
import Token from "../Token.js";
import { printVideo } from "../../functions.js";

/**
 * * Control the Assignment Modal logic.
 * @export
 * @class Assignment
 * @extends {Layout}
 */
export default class Assignment extends Layout {
    /**
     * * Creates an instance of Assignment.
     * @param {User} user
     * @memberof Assignment
     */
    constructor (user) {
        super();

        this.auth = user;

        this.setValidationJS();

        this.setState('state', 1);

        this.setHTML('#assignment-form');

        this.inputs = document.querySelectorAll('#assignment.modal .form-input');

        this.setLogic('assignment', {
            back: true,
            outsideClick: true,
        });

        window.addEventListener("hashchange", (e) => {
            this.checkURL();
        });

        this.checkURL();
    }

    /**
     * * Set the Assignment ValidationJS.
     * @memberof Assignment
     */
    setValidationJS () {
        if (validation.hasOwnProperty('assignment') && validation.assignment.hasOwnProperty('make')) {
            if (!validation.assignment.make.hasOwnProperty('ValidationJS')) {
                validation.assignment.make.ValidationJS = new window.validation({
                    id: 'assignment-form',
                    rules: validation.assignment.make.rules,
                    messages: validation.assignment.make.messages.es,
                }, {
                    submit: false,
                }, {
                    valid: {
                        function: this.make,
                        params: {
                            instance: this,
                        },
                    },
                });
            }
        } else {
            console.error(`validation.assignment does not exist`);
        }
    }

    /**
     * * Check the current URL hash parameter.
     * @memberof Assignment
     */
    checkURL () {
        if (/chat-([a-z0-9_]*)-assignment-([0-9]*)$/.exec(URL.findHashParameter())) {
            this.open({
                instance: this,
                slug: URL.findHashParameter().split('-assignment-')[0].split('chat-')[1],
                id_assignment: URL.findHashParameter().split('-assignment-')[1],
                section: 'list',
            });
        } else if (/chat-([a-z0-9_]*)-assignment$/.exec(URL.findHashParameter())) {
            this.open({
                instance: this,
                slug: URL.findHashParameter().split('-assignment')[0].split('chat-')[1],
                section: 'create',
            });
        } else {
            this.close();
        }
    }

    /**
     * * Clear the Assignment Model <inputs>.
     * @memberof Assignment
     */
    clear () {
        for (const input of this.inputs) {
            switch (input.nodeName) {
                case 'INPUT':
                    switch (input.name.toUpperCase()) {
                        case 'URL':
                            input.value = '';

                            $('#assignment-video').html('');
                            break;
                    }

                    input.disabled = false;

                    for (const child of input.parentNode.children) {
                        if (child.nodeName == 'H3') {
                            child.classList.remove('hidden');
                        }
                    }
                    break;
                default:
                    switch (input.name.toUpperCase()) {
                        case 'DESCRIPTION':
                            input.value = '';

                            for (const child of input.parentNode.children) {
                                if (child.nodeName == 'H3') {
                                    child.classList.remove('hidden');

                                    child.innerHTML = 'Describí que queres mejorar:';
                                }
                            }
                            break;
                    }
                    input.disabled = false;
                    break;
            }
        }
    }

    /**
     * * Close the Assignment Modal.
     * @param {object} [params={}]
     * @memberof Assignment
     */
    close (params = {}) {
        modals.assignment.close();
        if (/-assignment$/.exec(URL.findHashParameter())) {
            history.back();
        }
    }

    /**
     * * Open the Assignment Modal "create" section.
     * @param {object} [params={}]
     * @memberof Assignment
     */
    create (params = {}) {
        modals.assignment.open();

        params.instance.clear();

        document.querySelector('#assignment.modal .form-submit').classList.remove('hidden');

        if (document.querySelector('#assignment.modal .form-submit + a')) {
            let link = document.querySelector('#assignment.modal .form-submit + a');
            
            link.parentNode.removeChild(link);
        }
    }

    /**
     * * Fill the Assignment Model <inputs> with data.
     * @memberof Assignment
     */
    fill () {
        for (const input of this.inputs) {
            switch (input.nodeName) {
                case 'INPUT':
                    switch (input.name.toUpperCase()) {
                        case 'URL':
                            if (this.assignment.props.url) {
                                input.value = this.assignment.props.url;
                                
                                printVideo(input, $('#assignment-video'));
                            } else {
                                input.removeAttribute('value');

                                document.querySelector('#assignment-video').innerHTML = '';
                            }
                            break;
                    }

                    input.disabled = true;

                    for (const child of input.parentNode.children) {
                        if (child.nodeName == 'H3') {
                            child.classList.add('hidden');
                        }
                    }
                    break;
                default:
                    switch (input.name.toUpperCase()) {
                        case 'DESCRIPTION':
                            input.value = this.assignment.props.description;

                            for (const child of input.parentNode.children) {
                                if (child.nodeName == 'H3') {
                                    switch (this.auth.props.id_role) {
                                        case 0:
                                            child.innerHTML = 'Tu mensaje:';
                                            break;
                                        case 1:
                                            child.innerHTML = 'Mensaje del alumno:';
                                            break;
                                    }
                                }

                                if (child.classList.contains('extra')) {
                                    child.classList.add('hidden');
                                }
                            }
                            break;
                    }

                    input.disabled = true;
                    break;
            }
        }
    }

    /**
     * * Set the Presentation Link.
     * @param {string} slug
     * @memberof Assignment
     */
    link (slug) {
        document.querySelector('#assignment.modal .form-submit').classList.add('hidden');

        let link;
        if (document.querySelector('#assignment.modal .form-submit + a')) {
            link = document.querySelector('#assignment.modal .form-submit + a');

            link.parentNode.removeChild(link);
        }

        let classes = ['btn', 'btn-background', 'btn-one', 'flex', 'justify-center', 'w-full', 'rounded', 'p-1', 'md:h-12', 'md:items-center', 'mt-12', 'russo'];

        let innerHTML = 'Responder';

        switch (this.auth.props.id_role) {
            case 0:
                document.querySelector('#assignment.modal form .title').classList.remove('hidden');

                if (this.assignment.props.presentation) {
                    innerHTML = 'Ver respuesta del coach';
                } else {
                    classes.push('hidden');
                }
                break;
            case 1:
                document.querySelector('#assignment.modal form .title').classList.add('hidden');

                if (this.assignment.props.presentation) {
                    innerHTML = 'Revisar entrega';
                }
                break;
        }

        link = new window.html('a', {
            props: {
                url: this.assignment.props.presentation
                    ? `#chat-${ slug }-assignment-${ this.assignment.props.id_assignment }-presentation-${ this.assignment.props.presentation.id_presentation }`
                    : `#chat-${ slug }-assignment-${ this.assignment.props.id_assignment }-presentation`,
                classes: classes
            }, innerHTML: [
                ['div', {
                    props: {
                        classes: ['loading', 'hidden'],
                    }, innerHTML: [
                        ['i', {
                            props: {
                                classes: ['spinner-icon'],
                            },
                        }],
                    ],
                }], ['span', {
                    props: {
                        classes: ['py-2', 'px-4']
                    }, innerHTML: innerHTML
                }]
            ],
        });

        document.querySelector('#assignment.modal .form-submit').parentNode.appendChild(link.html);
    }

    /**
     * * Open the Assignment Modal "list" section.
     * @param {object} [params={}]
     * @memberof Assignment
     */
    list (params = {}) {
        Model.get(params.id_assignment).then(assignment => {
            params.instance.assignment = assignment;
    
            modals.assignment.open();
    
            params.instance.fill();

            params.instance.link(params.slug);
        });
    }

    /**
     * * Make a new Assignment.
     * @param {object} [params={}]
     * @memberof Assignment
     */
    async make (params = {}) {
        if (params.instance.state.state) {
            params.instance.setState('state', 0);

            modals.assignment.setState('outsideClick', false);
    
            params.Form.buttons[0].disabled = true;
    
            params.Form.buttons[0].children[0].classList.remove('hidden');
            params.Form.buttons[0].children[1].classList.add('hidden');
    
            let formData = new FormData(params.Form.html);
    
            let token = Token.get();
    
            let csrf_token = formData.get('_token');
            formData.delete('_token');
    
            let query = await Fetch.send({
                method: 'POST',
                url: `/api/chats/${ URL.findHashParameter().split('-assignment')[0].split('chat-')[1].replace(/_/g, '-') }/assignments/make`,
            }, {
                'Accept': 'application/json',
                'Authorization': `Bearer ${ token.data }`,
                'Content-type': 'application/json; charset=UTF-8',
                'X-CSRF-TOKEN': csrf_token,
            }, formData);
    
            switch (query.response.code) {
                case 200:
                    params.instance.setState('state', 1);
    
                    params.Form.buttons[0].disabled = false;
            
                    params.Form.buttons[0].children[0].classList.add('hidden');
                    params.Form.buttons[0].children[1].classList.remove('hidden');

                    modals.assignment.setState('outsideClick', true);
    
                    params.instance.close();
                    break;
                default:
                    new window.notification({
                        ...query.response,
                        classes: ["russo"],
                    }, {
                        open: true,
                    });
            }
        }
    }

    /**
     * * Open the Assignment Modal.
     * @param {object} [params={}]
     * @memberof Assignment
     */
    open (params = {}) {
        params.instance.support();

        params.instance.html.action = `/api/lessons/chats/${ params.id_chat }/assignments/make`;

        switch (params.section) {
            case 'create':
                params.instance.create(params);
                break;
            case 'list':
                params.instance.list(params);
                break;
        }
    }

    /**
     * * Clear the Assignment support <inputs>.
     * @memberof Assignment
     */
    support () {
        for (const support of document.querySelectorAll('#assignment-form .support')) {
            support.innerHTML = '';
            support.classList.add('hidden');
        }
    }
}