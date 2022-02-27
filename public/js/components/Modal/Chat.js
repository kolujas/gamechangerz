import { FetchServiceProvider as Fetch } from "../../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { URLServiceProvider as URL } from "../../../submodules/ProvidersJS/js/URLServiceProvider.js";

import Layout from "./Layout.js";
import Asset from "../Asset.js";
import { default as Model } from "../Models/Chat.js";
import Token from "../Token.js";

/**
 * * Control the Chat Modal logic.
 * @export
 * @class Chat
 * @extends {Layout}
 */
export default class Chat extends Layout {
    /**
     * * Creates an instance of Chat.
     * @param {User} user
     * @memberof Chat
     */
    constructor (user) {
        super();

        this.auth = user;

        this.setState('state', 1);

        this.setHTML('#chat.modal .modal-content');

        this.setState('current', 'closed');

        this.sections = {
            closed: {
                html: document.querySelector('a[href="#chat"].modal-button'),
            }, details: {
                html: this.html.children[1],
                header: this.html.children[1].children[0].children[1],
                main: this.html.children[1].children[1],
                footer: {
                    html: this.html.children[1].children[2],
                },
            }, list: {
                html: this.html.children[0],
                lessons: this.html.children[0].children[1].children[1],
                friends: this.html.children[0].children[1].children[2],
                empty: this.html.children[0].children[1].children[3],
            }, 
        };

        this.timer = this.CountDown();

        this.load();
    }

    /**
     * * Set the Chat Filter.
     * @memberof Chat
     */
    setFilter () {
        if (!this.filter) {
            this.filter = new window.filter({
                id: 'filter-chats',
                order: {
                    'props.updated_at': 'DESC',
                }, rules: {
                    'props.not_auth.username|name': null,
                }
            }, {}, {
                run: {
                    function: this.list,
                    params: {
                        instance: this,
                    },
                }
            }, this.chats);
        }
    }

    /**
     * * Set the CHat details footer type to "abilities".
     * @memberof Chat
     */
    abilities () {
        if (this.state.chat.props.available) {
            let paragraph = new window.html('p', {
                props: {
                    classes: ['overpass', 'color-grey', 'py-2', 'px-4'],
                }, innerHTML: `${ parseInt([...this.state.chat.props.lessons].pop()['quantity-of-assignments']) - [...this.state.chat.props.lessons].pop().assignments.length } tareas pendientes`,
            });

            this.sections.details.footer.paragraph = paragraph;

            this.sections.details.footer.html.appendChild(paragraph.html);
            
            if (this.state.chat.props.auth.id_role == 0) {
                let button = new window.html('button', {
                    props: {
                        classes: ['my-2', 'py-2', 'px-4', 'flex', 'items-center', 'overpass', 'modal-button'],
                    }, innerHTML: [
                        ['div', {
                            props: {
                                classes: ['loading', 'hidden'],
                            }, innerHTML: [
                                ['icon', {
                                    props: {
                                        classes: ['spinner-icon'],
                                    },
                                }],
                            ],
                        }], ['span', {
                            props: {
                                classes: ['overpass', 'color-white'],
                            }, innerHTML: this.state.chat.props.id_type == 1
                                ? 'Enviar'
                                : 'Confirmar habilidades',
                        }],
                    ], callback: {
                        function: this.send,
                        params: {
                            instance: this,
                        },
                    },
                });

                this.sections.details.footer.button = button;

                this.sections.details.footer.html.appendChild(button.html);
            }
        } else {
            let paragraph = new window.html('p', {
                props: {
                    classes: ['overpass', 'color-grey', 'py-2', 'px-4', 'unavailable'],
                }, innerHTML: this.state.chat.props.auth.id_role == 1
                    ? 'El chat no se encuentra activo'
                    : `${ parseInt([...this.state.chat.props.lessons].pop()['quantity-of-assignments']) - [...this.state.chat.props.lessons].pop().assignments.length } tareas pendientes`,
            });

            this.sections.details.footer.paragraph = paragraph;

            this.sections.details.footer.html.appendChild(paragraph.html);
        }
    }

    /**
     * * Add a new Chat.
     * @param {object} [data={}]
     * @memberof Chat
     */
    add (data = {}) {
        this.chats.push(data);
    }

    /**
     * * Set the CHat details footer type to "assignments".
     * @memberof Chat
     */
    assignments () {
        if (this.state.chat.props.available) {
            let paragraph = new window.html('p', {
                props: {
                    classes: ['overpass', 'color-grey', 'py-2', 'px-4'],
                }, innerHTML: `${ parseInt([...this.state.chat.props.lessons].pop()['quantity-of-assignments']) - [...this.state.chat.props.lessons].pop().assignments.length } tareas pendientes`,
            });

            this.sections.details.footer.paragraph = paragraph;

            this.sections.details.footer.html.appendChild(paragraph.html);
            
            if (this.state.chat.props.auth.id_role == 0) {
                let link = new window.html('a', {
                    props: {
                        classes: ['my-2', 'py-2', 'px-4', 'flex', 'items-center', 'overpass', 'modal-button', 'assignment'],
                        url: `#chat-${ this.state.chat.props.not_auth.slug.replace(/-/g, '_') }-assignment`,
                    }, innerHTML: [
                        ['span', {
                            props: {
                                classes: ['color-white','overpass'],
                            }, innerHTML: 'Enviar tarea',
                        }],
                    ], state: {
                        preventDefault: [...this.state.chat.props.lessons].pop()['quantity-of-assignments'] == [...this.state.chat.props.lessons].pop().assignments.length || ([...this.state.chat.props.lessons].pop().assignments.length && [...[...this.state.chat.props.lessons].pop().assignments].pop().presentation == null),
                    },
                });

                this.sections.details.footer.link = link;

                this.sections.details.footer.html.appendChild(link.html);
            }
        } else {
            let paragraph = new window.html('p', {
                props: {
                    classes: ['overpass', 'color-grey', 'py-2', 'px-4', 'unavailable'],
                }, innerHTML: 'Clase terminada',
            });

            this.sections.details.footer.paragraph = paragraph;

            this.sections.details.footer.html.appendChild(paragraph.html);
        }
    }

    /**
     * * Check the current URL hash parameter.
     * @memberof Chat
     */
    checkURL () {
        if (/chat-([a-z0-9_]*)$/.exec(URL.findHashParameter())) {
            this.open({
                instance: this,
                slug: URL.findHashParameter().split('chat-')[1],
                section: 'details',
            });
        } else if (/chat$/.exec(URL.findHashParameter())) {
            this.open({
                instance: this,
                section: 'list',
            });
        } else {
            this.close();
        }
    }

    /**
     * * Close the Chat Modal.
     * @param {object} [params={}]
     * @memberof Chat
     */
    close (params = {}) {
        modals.chat.close();

        this.tooltip();

        this.setState('current', 'closed');
    }

    /**
     * * Creates the Chat Modal CountDown.
     * @returns {CountDown}
     * @memberof Chat
     */
    CountDown () {
        let date = new Date();
        date.setMinutes(date.getMinutes() + 1);

        let timer = new window.countdown({
            scheduled_date_time: date,
        }, {
            end: {
                function: this.reload,
                params: {
                    instance: this,
                },
            },
        });

        return timer;
    }

    /**
     * * Set the Chat in finish state.
     * @memberof Chat
     */
    finish () {
        this.setState('state', 1);
        
        this.html.children[2].classList.add('hidden');

        this.html.children[2].classList.remove('flex');
    }

    /**
     * * Remove a Chat.
     * @param {object} [data={}]
     * @memberof Chat
     */
    delete (data = {}) {
        let index, chat;

        for (index in this.chats) {
            if (Object.hasOwnProperty.call(this.chats, index)) {
                chat = this.chats[index];

                if (chat.props.id_chat == data.props.id_chat) {
                    break;    
                }
            }
            index = null;
            chat = null;
        }

        this.chats.splice(index, 1);

        let item = new window.html('li', {
            props: {
                classes: ['color-white'],
            }, innerHTML: 'No se encontraron resultados',
        });

        switch (this.state.current) {
            case 'details':
                if (this.state.chat.props.id_chat == chat.props.id_chat) {
                    history.back();
                }
                break;
            case 'list':
                if (chat.item.html.parentNode) {
                    chat.item.html.parentNode.removeChild(chat.item.html);

                    switch (chat.props.id_type) {
                        case 1:
                            if (!this.sections.list.friends.children[1].children.length) {
                                this.sections.list.friends.children[1].appendChild(item.html);
                            }
                            break;
                        case 2:
                            if (!this.sections.list.lessons.children[1].children.length) {
                                this.sections.list.lessons.children[1].appendChild(item.html);
                            }
                            break;
                    }
                }
                break;
        }
    }

    /**
     * * List all the Chat Messages.
     * @param {object} [params={}]
     * @memberof Chat
     */
    details (params = {}) {
        modals.chat.open();

        let chat;

        for (chat of params.instance.chats) {
            if (chat.props.not_auth.slug == params.slug.replace(/_/g, '-')) {
                params.instance.setState('chat', chat);

                break;
            }

            chat = null;

            params.instance.setState('chat', null);
        }

        if (!chat) {
            history.back();
        }

        params.instance.sections.details.html.classList.remove('hidden');
        
        params.instance.sections.list.html.classList.add('hidden');
        
        params.instance.sections.details.main.children[1].innerHTML = '';

        params.instance.profile();

        params.instance.footer(params.instance.state.chat.props.from.id_role == 1
            ? [...params.instance.state.chat.messages].pop().props.id_type == 2
                ? ![...params.instance.state.chat.messages].pop().props.selected
                    ? 2
                    : 3
                : 3
            : 1);

        params.instance.listMessages();
    }

    /**
     * * Set the Chat "details" footer actions.
     * @memberof Chat
     */
    footer (id_type = 1) {
        this.sections.details.footer.html.innerHTML = '';
        
        switch (id_type) {
            case 1:
                this.says();
                break;
            case 2:
                this.abilities();
                break;
            case 3:
                this.assignments();
                break;
        }
    }

    /**
     * * List all the User Chats type = "friends".
     * @param {array} [chats=[]]
     * @memberof Chat
     */
    friends (chats = []) {
        this.listChats({
            ul: this.sections.list.friends.children[1],
            id_type: 1,
        }, chats);

        switch (this.auth.props.id_role) {
            case 0:
                this.sections.list.friends.classList.remove('hidden');
                this.sections.list.lessons.classList.remove('hidden');
                this.sections.list.empty.classList.add('hidden');
                break;
        }
    }

    /**
     * * List all the User Chats type = "lessons".
     * @param {array} [chats=[]]
     * @memberof Chat
     */
    lessons (chats = []) {
        this.listChats({
            ul: this.sections.list.lessons.children[1],
            id_type: 2,
        }, chats);

        switch (this.auth.props.id_role) {
            case 1:
                this.sections.list.friends.classList.add('hidden');
                this.sections.list.lessons.classList.remove('hidden');
                this.sections.list.lessons.children[0].classList.add("hidden");
                this.sections.list.empty.classList.add('hidden');
                break;
        }
    }

    /**
     * * List all the User Chats.
     * @param {object} [params={}]
     * @memberof Chat
     */
    list (params = {}) {
        modals.chat.open();

        params.instance.setState('chat', null);

        params.instance.sections.details.html.classList.add('hidden');
        
        params.instance.sections.list.html.classList.remove('hidden');

        params.instance.friends(params.hasOwnProperty('current') ? params.current : params.instance.chats);

        params.instance.lessons(params.hasOwnProperty('current') ? params.current : params.instance.chats);
    }


    /**
     * * List the Chats in an <ul>.
     * @param {object} [type={}]
     * @param {HTMLElement} [type.ul=this.sections.list.friends.children[1]] ,
     * @param {number} [type.id_type=1]
     * @param {Chats[]} [chats=[]]
     * @memberof Chat
     */
    listChats (type = {
            ul: this.sections.list.friends.children[1],
            id_type: 1,
        }, chats = []) {
        type.ul.innerHTML = '';

        let item = new window.html('li', {
            props: {
                classes: ['color-white'],
            }, innerHTML: 'No se encontraron resultados',
        });

        if (chats.length) {
            for (const chat of chats) {
                if (chat.props.id_type == type.id_type) {
                    if (!chat.item.html.parentNode) {
                        chat.append(type.ul);
                    }
                }
            }

            if (!type.ul.children.length) {
                type.ul.appendChild(item.html);
            }
        } else {
            type.ul.appendChild(item.html);
        }
    }

    /**
     * * List all the CHat Messages.
     * @memberof Chat
     */
    listMessages () {
        let found = false;
        
        for (const chat of this.chats) {
            if (chat.props.not_auth.slug == this.state.chat.props.not_auth.slug) {
                for (const message of chat.messages) {
                    if (!message.item.html.parentNode) {
                        this.sections.details.main.children[1].appendChild(message.item.html);
                    }
                }
                
                this.sections.details.main.children[1].scrollTo(0, this.sections.details.main.children[1].scrollHeight);

                found = true;
                break;
            }
        }

        if (!found) {
            window.location.href = '#chat';
        }
    }

    /**
     * * Load the Chat Modal correctly.
     * @async
     * @memberof Chat
     */
    async load () {
        this.chats = await Model.all();
        
        this.setLogic('chat');

        modals.chat.model = this;

        this.setFilter();

        window.addEventListener("hashchange", (e) => {
            this.checkURL();
        });

        this.checkURL();

        this.notify();
    }

    /**
     * * Log the authenticated User in a Chat.
     * @memberof Chat
     */
    login () {
        let slug = URL.findHashParameter().split('chat-')[1].replace(/_/g, '-');

        for (const chat of this.chats) {
            if (chat.props.not_auth.slug == slug) {
                chat.login();
            }
        }
    }

    /**
     * * Notify the Chat changes.
     * @memberof Chat
     */
    notify () {
        switch (this.state.current) {
            case 'closed':
                this.tooltip();
                break;
            case 'details':
                for (const chat of this.chats) {
                    if (chat.props.not_auth.slug != URL.findHashParameter().split('chat-')[1].replace(/_/g, '-')) {
                        continue;
                    }
                    for (const message of chat.messages) {
                        if (!message.item.html.parentNode) {
                            message.append(this.sections.details.main.children[1]);
                        }
                    }
                }

                this.sections.details.main.children[1].scrollTo(0, this.sections.details.main.children[1].scrollHeight);
                
                this.footer(this.state.chat.props.from.id_role == 1
                    ? [...this.state.chat.messages].pop().props.id_type == 2
                        ? ![...this.state.chat.messages].pop().props.selected
                            ? 2
                            : 3
                        : 3
                    : 1);
                break;
            case 'list':
                for (const chat of this.chats) {
                    if (!chat.item.html.parentNode) {
                        switch (chat.props.id_type) {
                            case 1:
                                if (!this.sections.list.friends.children[1].children.length) {
                                    chat.append(this.sections.list.friends.children[1]);
                                }
                                break;
                            case 2:
                                if (!this.sections.list.lessons.children[1].children.length) {
                                    chat.append(this.sections.list.lessons.children[1]);
                                }
                                break;
                        }
                    }
                }
                break;
        }
    }

    /**
     * * Open the Chat Modal.
     * @param {object} [params={}]
     * @memberof Chat
     */
    open (params = {}) {
        params.instance.timer.stop(params);
    }

    /**
     * * Set the User profile data.
     * @memberof Chat
     */
    profile () {
        this.sections.details.header.innerHTML = '';

        for (const chat of this.chats) {
            if (chat.props.not_auth.slug == this.state.chat.props.not_auth.slug) {
                this.sections.details.header.href = `/users/${ chat.props.not_auth.slug }/profile`;

                let figure = document.createElement('figure');
                this.sections.details.header.appendChild(figure);
                    let image = document.createElement('img');
                    image.alt = `${ chat.props.not_auth.username } profile image`;
                    if (!chat.props.not_auth.files || !chat.props.not_auth.files['profile']) {
                        image.src = new Asset(`img/resources/ProfileSVG.svg`).route;
                    } else {
                        image.src = new Asset(`storage/${ chat.props.not_auth.files['profile'] }`).route;
                    }
                    figure.appendChild(image);

                    let span = document.createElement('span');
                    span.classList.add('ml-2');
                    this.sections.details.header.appendChild(span);
                    span.innerHTML = `${ chat.props.not_auth.username } (${ chat.props.not_auth.name })`;
                break;
            }
        }
    }

    /**
     * * Reload the Modal.
     * @param {object} [params={}]
     * @memberof Chat
     */
    reload (params = {}) {
        if (params.hasOwnProperty('section')) {
            params.instance.tooltip(false);
            
            params.instance.setState('current', params.section);

            switch (params.section) {
                case 'details':
                    // params.instance.login();
                    
                    params.instance.details(params);
                    break;
                case 'list':
                    params.instance.list(params);
                    break;
            }
        }

        if (params.instance.state.state) {    
            params.instance.update();
        }
        
        params.instance.timer = params.instance.CountDown();
    }

    /**
     * * Set the Chat details footer type to "says".
     * @memberof Chat
     */
    says () {
        let form = new window.html('form', {
            props: {
                action: `/api/chats/${ this.state.chat.props.not_auth.id_user }`,
            }, callback: {
                function: this.send,
                params: {
                    instance: this,
                },
            }, innerHTML: [
                ['input', {
                    props: {
                        defaultValue: document.querySelector('meta[name=csrf-token]').content,
                        name: '_token',
                        type: 'hidden',
                    },
                }], ['input', {
                    props: {
                        classes: ['py-2', 'px-4', 'overpass'],
                        name: 'message',
                        placeholder: 'Escribe tu mensaje',
                        type: 'text',
                        defaultValue: this.state.says,
                    }, callbacks: {
                        keyup: {
                            function: params => {
                                params.instance.setState('says', params.value)
                            }, params: {
                                instance: this,
                            },
                        },
                    },
                }],
            ],
        });

        
        let button = document.createElement('button');
        button.classList.add('py-2', 'px-4');
        button.type = 'submit';

        form.appendChild(button);

        let div = new window.html('div', {
            props: {
                classes: ['loading', 'hidden'],
            }, innerHTML: [
                ['icon', {
                    props: {
                        classes: ['spinner-icon'],
                    },
                }],
            ],
        });

        button.appendChild(div.html);

        let img = new window.html('img', {
            props: {
                url: new Asset('img/resources/SendSVG.svg').route,
                name: 'Send button icon',
            },
        })

        button.appendChild(img.html);

        this.sections.details.footer.form = form;

        this.sections.details.footer.html.appendChild(form.html);
    }

    /**
     * * Send a Chat Message.
     * @async
     * @param {object} [params={}]
     * @memberof Chat
     */
    async send (params = {}) {
        if (params.instance.state.state) {
            params.instance.setState('state', 0);
    
            let formData;
    
            switch (params.instance.state.chat.props.id_type) {
                case 1:                    
                    formData = new FormData(params.instance.sections.details.footer.form.html);
                    
                    params.instance.sections.details.footer.form.children[1].html.disabled = true;

                    params.instance.sections.details.footer.form.html.children[2].children[0].disabled = true;

                    params.instance.sections.details.footer.form.html.children[2].children[0].classList.remove('hidden');
                    params.instance.sections.details.footer.form.html.children[2].children[1].classList.add('hidden');
                    break;
                case 2:
                    formData = new FormData();
    
                    for (const child of [...params.instance.state.chat.messages].pop().item.children) {
                        if (child.props.nodeName == 'INPUT') {
                            formData.append(child.props.name, child.html.checked
                                ? 'on'
                                : 'off');
                        }
                    }
                    break;
            }
    
            formData.append('id_type', params.instance.state.chat.props.id_type);
    
            let token = Token.get();
    
            let csrf_token = formData.get('_token');
            formData.delete('_token');
    
            let query = await Fetch.send({
                method: 'PUT',
                url: `/api/chats/${ params.instance.state.chat.props.not_auth.id_user }/send`,
            }, {
                'Accept': 'application/json',
                'Authorization': `Bearer ${ token.data }`,
                'Content-type': 'application/json; charset=UTF-8',
                'X-CSRF-TOKEN': csrf_token,
            }, formData);
    
            switch (query.response.code) {
                case 200:
                    params.instance.setState('state', 1);
                    params.instance.timer.stop(params);
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
     * * Toogle the Chat button tooltip.
     * @memberof Chat
     */
    tooltip (status = true) {
        let child;

        for (child of this.sections.closed.html.children) {
            if (child.nodeName == 'SPAN') {
                child.classList.add('hidden');

                child.innerHTML = '';

                break;
            }
        }

        this.sections.closed.html.classList.remove('alert');

        if (status) {
            let quantity = 0;
    
            for (const chat of this.chats) {
                for (const logged_at of chat.props.logged_at) {
                    if (logged_at.id_user != chat.props.auth.id_user) {
                        continue;
                    }
                    
                    for (const message of chat.messages) {
                        if (logged_at.at > message.props.created_at) {
                            continue;
                        }
                        
                        quantity++;
                    }
                }
            }
    
            if (quantity) {
                this.sections.closed.html.classList.add('alert');
    
                child.classList.remove('hidden');

                child.innerHTML = quantity;
            }
        }
    }

    /**
     * * Updates the Chats.
     * @memberof Chat
     */
    async update () {
        this.waiting();
        
        let chats = await Model.all();
        
        this.finish();

        oldOnes: for (const chat of this.chats) {
            for (const newChat of chats) {
                if (chat.props.id_chat == newChat.props.id_chat) {
                    continue oldOnes;
                }
            }

            this.delete(chat);
        }

        newOnes: for (const newChat of chats) {
            for (const chat of this.chats) {
                if (chat.props.id_chat == newChat.props.id_chat) {
                    chat.update({
                        ...newChat.props,
                    });

                    if (this.state.current == 'details') {
                        if (chat.props.not_auth.slug == URL.findHashParameter().split('chat-')[1].replace(/_/g, '-')) {
                            chat.login();
                        }
                    }

                    continue newOnes;
                }
            }

            this.add(newChat);
        }

        this.notify();

        this.filter.changeData(this.chats);

        if (this.state.current == 'list') {   
            this.filter.run();
        }
    }

    /**
     * * Set the Chat in waiting state.
     * @memberof Chat
     */
    waiting () {
        this.setState('state', 0);
        
        this.html.children[2].classList.remove('hidden');

        this.html.children[2].classList.add('flex');
    }

    /**
     * * Returns the Chat html component.
     * @static
     * @param {string} [name='']
     * @param {*} [data={}]
     * @returns {HTMLCreatorJS}
     * @memberof Chat
     */
    static component (name = '', data = {}) {
        return this[name](data);
    }
}