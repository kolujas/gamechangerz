import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import Modal from './modal.js';

export class Chat extends Class {
    constructor (props, chats) {
        super(props);
        this.setProps('chats', chats);
        this.getRole();
        this.createHTML(chats);
        this.generateHTMLChats(chats);
    }

    async getRole (chats) {
        let query = await Fetch.get(`/api/role`, {
            'Accept': 'application/json',
            'Content-type': 'application/json; charset=UTF-8',
            'Authorization': "Bearer " + this.props.token,
        });
        if (query.response.code === 200) {
            this.setProps('id_role', query.response.data.id_role);
        }
    }

    createHTML (chats) {
        this.Modal = new Modal({
            id: 'list',
        });
        this.setHTML(this.Modal.ModalJS.html.children[0]);
        this.list = this.html.children[0];
        this.details = this.html.children[1];
        if (!this.props.id_role) {
            this.list.children[1].children[1].children[0].classList.add('block');
            this.list.children[1].children[2].children[0].classList.add('block');
            let friends = 0;
            let lessons = 0;
            for (const chat of chats) {
                if (chat.id_type === 1) {
                    friends++;
                }
                if (chat.id_type === 2) {
                    lessons++;
                }
            }
            if (!friends) {
                this.list.children[1].children[2].classList.add('hidden');
            }
            if (!lessons) {
                this.list.children[1].children[1].classList.add('hidden');
            }
        }
        if (this.props.id_role) {
            this.list.children[1].children[1].children[0].classList.add('hidden');
            this.list.children[1].children[2].add('hidden');
        }
    }

    generateHTMLChats (chats) {
        let instance = this;
        for (const chat of chats) {
            let li = document.createElement('li');
            li.classList.add('mt-4');
            if (!this.props.id_role) {
                if (chat.id_user_logged === chat.id_user_from) {
                    this.list.children[1].children[2].children[1].appendChild(li);
                }
                if (chat.id_user_logged === chat.id_user_to) {
                    if (!chat.users.from.id_role) {
                        this.list.children[1].children[2].children[1].appendChild(li);
                    }
                    if (chat.users.from.id_role) {
                        this.list.children[1].children[1].children[1].appendChild(li);
                    }
                }
            }
            if (this.props.id_role) {
                this.list.children[1].children[1].children[1].appendChild(li);
            }
                let link = document.createElement('a');
                link.classList.add('flex', 'color-white', 'items-center');
                link.href = `#chat-${ chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].slug }`;
                li.appendChild(link);
                link.addEventListener('click', function (e) {
                    instance.open(chat.id_chat);
                });
                    let image = document.createElement('figure');
                    image.classList.add('image', 'mr-4');
                    link.appendChild(image);
                        let img = document.createElement('img');
                        img.src = "/img/resources/Group 15SVG.svg";
                        image.appendChild(img);

                    let username = document.createElement('div');
                    username.classList.add('username');
                    link.appendChild(username);
                        let paragraph = document.createElement('p');
                        paragraph.innerHTML = `${ chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].username} (`;
                        username.appendChild(paragraph);
                            let name = document.createElement('span');
                            name.innerHTML = `${ chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].name }`;
                            paragraph.appendChild(name);
                            paragraph.innerHTML = `${paragraph.innerHTML})`;

                    let span = document.createElement('span');
                    span.classList.add('icon', 'color-five');
                    link.appendChild(span);
                        let icon = document.createElement('icon');
                        icon.classList.add('fas', 'fa-chevron-right');
                        span.appendChild(icon);
        }
    }

    open (id_chat = '') {
        this.Modal.setProps('id', 'list');
        this.Modal.changeModalContent();
        this.changeChat(id_chat);
    }

    changeChat (id_chat = '') {
        let instance = this;
        this.details.children[1].children[0].innerHTML = '';
        for (const chat of this.props.chats) {
            if (id_chat === chat.id_chat) {
                for (const message of chat.messages) {
                    this.addMessage(chat.id_user_logged, message);
                }
            }
        }
        document.querySelector(`#chat.modal #details form`).addEventListener('submit', function (e) {
            e.preventDefault();
            instance.send();
        });
    }

    addMessage (id_user_logged, message) {
        let li = document.createElement('li');
        this.details.children[1].children[0].appendChild(li);
        if (message.hasOwnProperty('says')) {
            li.classList.add((id_user_logged === message.id_user ? 'from' : 'to'));
                let div = document.createElement('div');
                div.classList.add('p-4');
                li.appendChild(div);
                    let paragraph = document.createElement('p');
                    paragraph.innerHTML = message.says;
                    div.appendChild(paragraph);
        } else {
            li.classList.add('assigment');
                let div = document.createElement('div');
                li.appendChild(div);
                    let link = document.createElement('a');
                    link.href = `#assigment-${ message.assigment.slug }`;
                    link.classList.add('flex', 'justify-end', 'flex-wrap', 'p-4', 'mb-4');
                    div.appendChild(link);
                        let title = document.createElement('span');
                        title.classList.add('w-full', 'text-center');
                        title.innerHTML = message.assigment.title;
                        link.appendChild(title);
        }
    }

    async send () {
        if (document.querySelector(`#chat.modal #details form input[name=message]`).value) {
            let formData = new FormData(document.querySelector(`#chat.modal #details form`));
            let token = formData.get('_token');
            formData.delete('_token');
            let query = await Fetch.send({
                method: 'POST',
                url: `/api/chats/${ this.props.id_chat }`,
            }, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
                'X-CSRF-TOKEN': token,
                'Authorization': "Bearer " + this.props.token,
            }, formData);
            if (query.response.code === 200) {
                for (const message of query.response.data.chat.messages) {
                    this.addMessage(message);
                }
            }
        }
    }

    static async all (token) {
        let query = await Fetch.get('/api/chats', {
            'Accept': 'application/json',
            'Authorization': "Bearer " + token,
        });
        let chats = [];
        if (query.response.code === 200) {
            for (const chat of query.response.data.chats) {
                chats.push(chat);
            }
        }
        return chats;
    }
}

export default Chat;