import { FetchServiceProvider as Fetch } from "../../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { URLServiceProvider as URL } from "../../../submodules/ProvidersJS/js/URLServiceProvider.js";

import Layout from "./Layout.js";
import { default as Model } from "../Models/Presentation.js";
import User from "../Models/User.js";
import Token from "../Token.js";
import { printVideo } from "../../functions.js";

/**
 * * Control the Presentation Modal logic.
 * @export
 * @class Presentation
 * @extends {Layout}
 */
export default class Presentation extends Layout {
    /**
     * * Creates an instance of Presentation.
     * @param {User} user
     * @memberof Presentation
     */
    constructor (user) {
        super();

        this.auth = user;

        this.setValidationJS();

        this.setState('state', 1);

        this.setHTML('#presentation-form');

        this.html.addEventListener('submit', (e) => {
            e.preventDefault();

            console.log('TODO');
        });

        this.inputs = document.querySelectorAll('#presentation.modal .form-input');

        this.setLogic('presentation', {
            back: true,
            outsideClick: true,
        });

        window.addEventListener("hashchange", (e) => {
            this.checkURL();
        });

        this.checkURL();
    }

    /**
     * * Set the Presentation ValidationJS.
     * @memberof Presentation
     */
    setValidationJS () {
        if (validation.hasOwnProperty('presentation') && validation.presentation.hasOwnProperty('make')) {
            if (!validation.presentation.make.hasOwnProperty('ValidationJS')) {
                validation.presentation.make.ValidationJS = new window.validation({
                    id: 'presentation-form',
                    rules: validation.presentation.make.rules,
                    messages: validation.presentation.make.messages.es,
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
            console.error(`validation.presentation does not exist`);
        }
    }

    /**
     * * Check the current URL hash parameter.
     * @memberof Presentation
     */
    checkURL () {
        if (/chat-([a-z0-9_]*)-assignment-([0-9]*)-presentation-([0-9]*)$/.exec(URL.findHashParameter())) {
            this.open({
                instance: this,
                slug: URL.findHashParameter().split('-assignment-')[0].split('chat-')[1],
                id_assignment: URL.findHashParameter().split('-presentation-')[0].split('-assignment-')[1],
                id_presentation: URL.findHashParameter().split('-presentation-')[1],
                section: 'list',
            });
        } else if (/chat-([a-z0-9_]*)-assignment-([0-9]*)-presentation$/.exec(URL.findHashParameter())) {
            this.open({
                instance: this,
                slug: URL.findHashParameter().split('-assignment-')[0].split('chat-')[1],
                id_assignment: URL.findHashParameter().split('-presentation-')[0].split('-assignment-')[1],
                section: 'create',
            });
        } else {
            this.close();
        }
    }

    /**
     * * Clear the Presentation Model <inputs>.
     * @memberof Presentation
     */
    clear () {
        for (const description of document.querySelectorAll('#presentation.modal h3')) {
            description.classList.remove('hidden');
        }

        document.querySelector('#presentation-video').innerHTML = '';

        for (const input of this.inputs) {
            if (input.name != '_token' && input.name != '_method') {
                input.value = '';

                input.disabled = false;
            }
        }

        document.querySelector('#presentation.modal .form-submit').classList.remove('hidden');
    }

    /**
     * * Close the Presentation Modal.
     * @param {object} [params={}]
     * @memberof Presentation
     */
    close (params = {}) {
        modals.presentation.close();
        if (/-presentation$/.exec(URL.findHashParameter())) {
            history.back();
        }
    }

    /**
     * * Open the Presentation Modal "create" section.
     * @param {object} [params={}]
     * @memberof Presentation
     */
    create (params = {}) {
        modals.presentation.open();

        params.instance.clear();
    }

    /**
     * * Fill the Presentation Model <inputs> with data.
     * @memberof Presentation
     */
    fill () {
        for (const description of document.querySelectorAll('#presentation.modal :where(h3, .extra)')) {
            description.classList.add('hidden');
        }

        for (const input of this.inputs) {
            switch (input.nodeName) {
                case 'INPUT':
                    switch (input.name.toUpperCase()) {
                        case 'URL':
                            input.disabled = true;
            
                            if (this.presentation.props.url) {
                                input.value = this.presentation.props.url;
                                
                                printVideo(input, $('#presentation-video'));
                            } else {
                                input.removeAttribute('value');
            
                                document.querySelector('#presentation-video').innerHTML = '';
                            }
                            break;
                    }
                    break;
                    default:
                        switch (input.name.toUpperCase()) {
                            case 'DESCRIPTION':
                                input.value = this.presentation.props.description;
                
                                input.disabled = true;
                                break;
                        }
                        break;
            }
        }

        document.querySelector('#presentation.modal .form-submit').classList.add('hidden');
    }

    /**
     * * Open the Presentation Modal "list" section.
     * @param {object} [params={}]
     * @memberof Presentation
     */
    list (params = {}) {
        Model.get(params.id_presentation).then(presentation => {
            params.instance.presentation = presentation;
    
            modals.presentation.open();
    
            params.instance.fill();
        });
    }

    /**
     * * Make a new Presentation.
     * @param {object} [params={}]
     * @memberof Presentation
     */
    async make (params = {}) {
        if (params.instance.state.state) {
            params.instance.setState('state', 0);

            modals.presentation.setState('outsideClick', false);
    
            params.Form.buttons[0].disabled = true;
    
            params.Form.buttons[0].children[0].classList.remove('hidden');
            params.Form.buttons[0].children[1].classList.add('hidden');

            let formData = new FormData(params.Form.html);

            let token = Token.get();

            let csrf_token = formData.get('_token');
            formData.delete('_token');

            let query = await Fetch.send({
                method: 'POST',
                url: `/api/chats/${  URL.findHashParameter().split('-assignment-')[0].split('chat-')[1].replace(/_/g, '-') }/assignments/${ URL.findHashParameter().split('-assignment-')[1].split('-presentation')[0] }/complete`,
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

                    modals.presentation.setState('outsideClick', true);
    
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
     * * Open the Presentation Modal.
     * @param {object} [params={}]
     * @memberof Presentation
     */
    open (params = {}) {
        params.instance.support();

        params.instance.html.action = `/api/lessons/chats/${ params.id_chat }/assignments/${ params.id_assignment }/complete`;

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
     * * Clear the Presentation support <inputs>.
     * @memberof Presentation
     */
    support () {
        for (const support of document.querySelectorAll('#presentation-form .support')) {
            support.innerHTML = '';
            support.classList.add('hidden');
        }
    }
}