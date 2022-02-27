import { FetchServiceProvider as Fetch } from "../../../submodules/ProvidersJS/js/FetchServiceProvider.js";

import Message from "./Message.js";
import Asset from "../Asset.js";
import Token from "../Token.js";

/**
 * * Controls the JavaScript Chat Model.
 * @export
 * @class Chat
 * @extends {window.class}
 */
export default class Chat extends window.class {
    /**
     * * Creates an instance of Chat.
     * @param {object} [data={}]
     * @memberof Chat
     */
    constructor (data = {}) {
        super({
            ...data,
        });

        this.item = Chat.component('item', {
            ...this.props,
        });

        this.messages = Message.all(this);
    }

    /**
     * * Add a new Message.
     * @param {object} [data={}]
     * @memberof Chat
     */
    add (data = {}) {
        let message = new Message({
            ...data,
            auth: this.props.auth,
            slug: this.props.not_auth.slug,
        });

        this.messages.push(message);

        this.alert();

        this.preview();
    }

    /**
     * * Alert if the Chat has new Messages.
     * @memberof Chat
     */
    alert () {
        let quantity = 0;

        for (const logged_at of this.props.logged_at) {
            if (logged_at.id_user != this.props.auth.id_user) {
                continue;
            }
            for (const message of this.messages) {
                if (logged_at.at > message.props.created_at) {
                    continue;
                }

                quantity++;
            }
        }

        if (quantity) {
            this.item.html.classList.add('alert');
        } else {
            this.item.html.classList.remove('alert');
        }
    }

    /**
     * * Append the Chat item.
     * @param {HTMLElement} ul
     * @memberof Chat
     */
    append (ul) {
        ul.appendChild(this.item.html);
    }

    /**
     * * Log the authenticated Use in the Chat.
     * @async
     * @memberof Chat
     */
    async login () {
        let token = Token.get();

        let query = await Fetch.send({
            method: 'PUT',
            url: `/api/chats/${ this.props.not_auth.slug }/login`,
        }, {
            'Accept': 'application/json',
            'Authorization': `Bearer ${ token.data }`,
        }, new FormData());

        if (query.response.code == 200) {
            this.setProps('logged_at', query.response.data.logged_at);

            this.alert();
        }
    }

    /**
     * * Change the Chat preview Message.
     * @memberof Chat
     */
    preview () {
        if ([...this.messages].pop()) {
            this.item.children[0].children[0].children[1].html.innerHTML = [...this.messages].pop().props.id_type == 1
                ? [...this.messages].pop().props.says.length > 20
                    ? [...this.messages].pop().props.says.slice(0, 17) + '...'
                    : [...this.messages].pop().props.says
                : [...this.messages].pop().props.id_type == 2
                    ? [...this.messages].pop().props.selected
                        ? 'Habilidades elegídas'
                        : 'Por elegir habilidades'
                    : [...this.messages].pop().props.assignment.presentation == null
                        ? 'Nueva tarea'
                        : (e => {
                            for (const message of this.messages) {
                                if (message.props.assignment && message.props.assignment.presentation) {
                                    continue;
                                }

                                if (message.props.id_type == 3) {
                                    return true;
                                }
                            }

                            return false;
                        })()
                            ? 'Tarea terminada'
                            : 'Clase terminada'
    
            this.item.children[0].children[0].children[1].html.title = [...this.messages].pop().props.id_type == 1
                ? [...this.messages].pop().props.says
                : [...this.messages].pop().props.id_type == 2
                    ? [...this.messages].pop().props.selected
                        ? 'Habilidades elegídas'
                        : 'Por elegir habilidades'
                    : [...this.messages].pop().props.assignment.presentation == null
                        ? 'Nueva tarea'
                        : (e => {
                            for (const message of this.messages) {
                                if (message.props.assignment && message.props.assignment.presentation) {
                                    continue;
                                }

                                if (message.props.id_type == 3) {   
                                    return true;
                                }
                            }

                            return false;
                        })()
                            ? 'Tarea terminada'
                            : 'Clase terminada'
        }
    }
    
    /**
     * * Reorder the Chat position.
     * @param {number} [key=0]
     * @memberof Chat
     */
    reorder (key = 0) {
        this.item.html.classList.remove(`order-${ this.props.key }`);
    
        this.item.html.classList.add(`order-${ key }`)
    }

    /**
     * * Updates the Chat.
     * @param {object} [data={}]
     * @memberof Chat
     */
    update (data = {}) {
        for (const key in data) {
            if (Object.hasOwnProperty.call(data, key)) {
                const value = data[key];

                if (key == 'key') {
                    this.reorder(value);
                }

                this.setProps(key, value);
            }
        }

        this.alert();

        newOnes: for (const newMessage of this.props.messages) {
            for (const message of this.messages) {
                if (newMessage.id_message == message.props.id_message) {
                    message.update({
                        ...newMessage,
                    });
    
                    continue newOnes;
                }
            }

            this.add(newMessage);
        }

        this.preview();
    }

    /**
     * * Get all the Chats from the authenticated User.
     * @static
     * @async
     * @returns {Chat[]}
     * @memberof Chat
     */
    static async all () {
        let token = Token.get();

        let query = await Fetch.get('/api/chats', {
            'Accept': 'application/json',
            'Authorization': `Bearer ${ token.data }`,
        });

        let chats = [];

        if (query.response.code == 200) {
            for (const key in query.response.data.chats) {
                if (Object.hasOwnProperty.call(query.response.data.chats, key)) {
                    const data = query.response.data.chats[key];

                    chats.push(new this({
                        ...data,
                        key: key,
                    }));
                }
            }
        }

        return chats;
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

    /**
     * * Creates the Chat <li> component.
     * @static
     * @param {object} [data={}]
     * @returns {HTMLCreatorJS}
     * @memberof Chat
     */
    static item (data = {}) {
        let quantity = 0;

        for (const logged_at of data.logged_at) {
            if (logged_at.id_user != data.auth.id_user) {
                continue;
            }
            for (const message of data.messages) {
                if (logged_at.at > message.created_at) {
                    continue;
                }

                quantity++;
            }
        }

        let item = new window.html('li', {
            props: {
                id: `chat-${ data.id_chat }`,
                classes: quantity ? ['mt-4', `order-${ data.key }`, 'alert'] : ['mt-4', `order-${ data.key }`],
            }, innerHTML: [
                ['a', {
                    props: {
                        classes: ['flex', 'color-white', 'items-center', 'overpass'],
                        url: `#chat-${ data.not_auth.slug.replace(/-/g, '_') }`,
                    }, innerHTML: [
                        ['div', {
                            props: {
                                classes: ['username'],
                            }, innerHTML: [
                                ['p', {
                                    innerHTML: `${ data.not_auth.username } (<span>${ data.not_auth.name }</span>)`,
                                }], ['span', {
                                    props: {
                                        classes: ['color-grey'],
                                        title: [...data.messages].pop()
                                            ? [...data.messages].pop().id_type == 1
                                                ? [...data.messages].pop().says
                                                : [...data.messages].pop().id_type == 2
                                                    ? [...data.messages].pop().selected
                                                        ? 'Habilidades elegídas'
                                                        : 'Por elegir habilidades'
                                                    : [...data.messages].pop().assignment.presentation == null
                                                        ? 'Nueva tarea'
                                                        : (e => {
                                                            for (const message of data.messages) {
                                                                if (message.assignment && message.assignment.presentation) {
                                                                    continue;
                                                                }

                                                                if (message.id_type == 3) {   
                                                                    return true;
                                                                }
                                                            }

                                                            return false;
                                                        })()
                                                            ? 'Tarea terminada'
                                                            : 'Clase terminada'
                                            : '',
                                    }, innerHTML: [...data.messages].pop()
                                        ? [...data.messages].pop().id_type == 1
                                            ? [...data.messages].pop().says.length > 20
                                                ? [...data.messages].pop().says.slice(0, 17) + '...'
                                                : [...data.messages].pop().says
                                            : [...data.messages].pop().id_type == 2
                                                ? [...data.messages].pop().selected
                                                    ? 'Habilidades elegídas'
                                                    : 'Por elegir habilidades'
                                                : [...data.messages].pop().assignment.presentation == null
                                                    ? 'Nueva tarea'
                                                    : (e => {
                                                        for (const message of data.messages) {
                                                            if (message.assignment && message.assignment.presentation) {
                                                                continue;
                                                            }

                                                            if (message.id_type == 3) {
                                                                return true;
                                                            }
                                                        }

                                                        return false;
                                                    })()
                                                        ? 'Tarea terminada'
                                                        : 'Clase terminada'
                                        : '',
                                }]
                            ],
                        }], ['span', {
                            props: {
                                classes: ['icon', 'color-five', 'overpass'],
                            }, innerHTML: [
                                ['icon', {
                                    props: {
                                        classes: ['fas', 'fa-chevron-right'],
                                    },
                                }],
                            ],
                        }],
                    ],
                }],
            ],
        });

        let figure = document.createElement('figure');
        figure.classList.add('image', 'mr-4');
        item.children[0].insertBefore(figure, item.children[0].children[0].html);
        
            let image = document.createElement('img');
            figure.appendChild(image);
            if (!data.not_auth.files['profile']) {
                image.src = new Asset(`img/resources/ProfileSVG.svg`).route;
            } else {
                image.src = new Asset(`storage/${ data.not_auth.files['profile'] }`).route;
            }

        return item;
    }
}