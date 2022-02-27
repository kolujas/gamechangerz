/**
 * * Controls the JavaScript Message Model.
 * @export
 * @class Message
 * @extends {window.class}
 */
export default class Message extends window.class {
    /**
     * * Creates an instance of Message.
     * @param {object} [data={}]
     * @memberof Message
     */
    constructor (data = {}) {
        super({
            ...data,
        });

        this.item = Message.component('item', {
            ...this.props,
        });
    }

    /**
     * * Append the Message item.
     * @param {HTMLElement} ul
     * @memberof Message
     */
    append (ul) {
        ul.appendChild(this.item.html);
    }

    /**
     * * Updates the Message.
     * @param {object} [data={}]
     * @memberof Message
     */
    update (data = {}) {
        if (this.props.id_type == 2) {
            if (this.props.selected != data.selected) {
                for (const child of this.item.children) {
                    switch (child.props.nodeName) {
                        case 'SPAN':
                            child.html.innerHTML = 'Habilidades elegídas:';
                            break;
                        case 'INPUT':
                            for (const ability of data.abilities) {
                                if (child.props.name != `ability[${ ability.slug }]` && child.html.parentNode) {
                                    child.html.parentNode.removeChild(child.html);
                                    child.html.disabled = true;
                                }
                            }
                            break;
                        case 'LABEL':
                            for (const ability of data.abilities) {
                                if (child.props.for != `message-${ data.id_message }-ability-${ ability.id_ability }` && child.html.parentNode) {
                                    child.html.parentNode.removeChild(child.html);
                                }
                            }
                            break;
                    }
                }
            }
        } else if (this.props.id_type == 3) {
            if (data.assignment.presentation) {
                this.item.children[0].children[0].html.classList.add('complete');
                this.item.children[0].children[0].html.classList.remove('not-complete');
            }
        }

        for (const key in data) {
            if (Object.hasOwnProperty.call(data, key)) {
                const value = data[key];

                this.setProps(key, value);
            }
        }
    }

    /**
     * * Creates the Message type "abilities" <li> component.
     * @static
     * @param {object} [data={}]
     * @returns {HTMLCreatorJS}
     * @memberof Message
     */
    static abilities (data = {}) {
        let item = new window.html('li', {
            props: {
                id: `message-${ data.id_message }`,
                classes: [`lesson-${ data.id_lesson }`, 'abilities', 'flex', 'flex-wrap', 'gap-2', 'justify-end'],
            }, innerHTML: [
                ['span', {
                    props: {
                        classes: ['block', 'text-right', 'mb-2', 'text-sm', 'w-full', 'color-white'],
                    }, innerHTML: data.selected
                        ? 'Habilidades elegídas:'
                        : '¿Te gustaria mejorar en alguna habilidad en particular? Si aún no lo sabes, no es necesario que selecciones ningúna para poder continuar',
                }], ...(() => {
                    let abilities = [];

                    for (const ability of data.abilities) {
                        abilities.push(['input', {
                            props: {
                                id: `message-${ data.id_message }-ability-${ ability.id_ability }`,
                                classes: ['hidden'],
                                defaultValue: ability.id_ability,
                                type: 'checkbox',
                                name: `ability[${ ability.slug }]`,
                            }, state: {
                                id: true,
                                disabled: data.disabled,
                            },
                        }]);
                        abilities.push(['label', {
                            props: {
                                classes: ['mb-6'],
                                for: `message-${ data.id_message }-ability-${ ability.id_ability }`,
                            }, innerHTML: [
                                ['span', {
                                    props: {
                                        classes: ['bg-one', 'color-white', 'px-4', 'py-2', 'rounded'],
                                    }, innerHTML: ability.name,
                                }],
                            ],
                        }]);
                    }

                    return abilities;
                })(),
            ],
        });

        return item;
    }

    /**
     * * Get all the Messsages from a Chat.
     * @static
     * @param {Chat} Chat
     * @returns {Message[]}
     * @memberof Message
     */
    static all (Chat) {
        let messages = [];

        for (const key in Chat.props.messages) {
            if (Object.hasOwnProperty.call(Chat.props.messages, key)) {
                messages.push(new this({
                    ...Chat.props.messages[key],
                    auth: Chat.props.auth,
                    slug: Chat.props.not_auth.slug,
                }));
            }
        }

        return messages;
    }

    /**
     * * Creates the Message type "assignment" <li> component.
     * @static
     * @param {object} [data={}]
     * @returns {HTMLCreatorJS}
     * @memberof Message
     */
    static assignment (data = {}) {
        let item = new window.html('li', {
            props: {
                id: `message-${ data.id_message }`,
                classes: [`lesson-${ data.id_lesson }`, 'assignment'],
            }, innerHTML: [
                ['div', {
                    innerHTML: [
                        ['a', {
                            props: {
                                classes: ['flex', 'justify-end', 'flex-wrap', 'p-4', 'mb-4', 'overpass', data.assignment.presentation ? 'complete' : 'not-complete'],
                                url: `#chat-${ data.slug.replace(/-/g, '_') }-assignment-${ data.assignment.id_assignment }`,
                            }, innerHTML: [
                                ['span', {
                                    innerHTML: [
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
                                        }],
                                    ],
                                }], ['span', {
                                    props: {
                                        classes: ['w-full', 'text-center', 'overpass'],
                                    }, innerHTML: 'Tarea',
                                }],
                            ],
                        }],
                    ],
                }],
            ],
        });

        return item;
    }

    /**
     * * Returns the Message html component.
     * @static
     * @param {string} [name='']
     * @param {*} [data={}]
     * @returns {HTMLCreatorJS}
     * @memberof Message
     */
    static component (name = '', data = {}) {
        return this[name](data);
    }

    /**
     * * Creates the Message <li> component.
     * @static
     * @param {object} [data={}]
     * @returns {HTMLCreatorJS}
     * @memberof Message
     */
    static item (data = {}) {
        switch (data.id_type) {
            case 1:
                return this.says(data);
            case 2:
                return this.abilities(data);
            case 3:
                return this.assignment(data);
        }
    }

    /**
     * * Creates the Message type "says" <li> component.
     * @static
     * @param {object} [data={}]
     * @returns {HTMLCreatorJS}
     * @memberof Message
     */
    static says (data = {}) {
        let item = new window.html('li', {
            props: {
                id: `message-${ data.id_message }`,
                classes: [data.id_user == data.auth.id_user ? 'from' : 'to'],
            }, innerHTML: [
                ['div', {
                    props: {
                        classes: ['p-4', 'overpass'],
                    }, innerHTML: [
                        ['p', {
                            innerHTML: data.says,
                        // }], ['span', {
                        //     innerHTML: window.moment(data.created_at).fromNow(),
                        }],
                    ],
                }],
            ],
        });

        return item;
    }
}