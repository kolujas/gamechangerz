import { URLServiceProvider as URL } from "../submodules/ProvidersJS/js/URLServiceProvider.js";
import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import Modal from './modal.js';
import CountDown from "./CountDown.js";

export class Chat extends Class {
    constructor (props, chats = []) {
        super(props);
        this.setProps('chats', chats);
        this.createHTML();
        this.createCountDown();
    }

    async getRole () {
        let query = await Fetch.get(`/api/role`, {
            'Accept': 'application/json',
            'Content-type': 'application/json; charset=UTF-8',
            'Authorization': "Bearer " + this.props.token,
        });
        if (query.response.code === 200) {
            this.setProps('id_role', query.response.data.id_role);
        }
    }

    async createHTML () {
        this.Modal = new Modal({
            id: 'list',
        });
        this.setHTML(this.Modal.ModalJS.html.children[0]);
        this.list = this.html.children[0];
        this.details = this.html.children[1];
        await this.getRole();
        this.detectChats();
        this.generateHTMLChats();
    }

    detectChats () {
        this.list.children[1].children[1].children[1].innerHTML = '';
        this.list.children[1].children[2].children[1].innerHTML = '';
        if (this.props.id_role === 0) {
            this.showLessons();
            this.showFriends();
            this.hideEmpty();
            let friends = 0;
            let lessons = 0;
            if (this.props.chats.length) {
                for (const chat of this.props.chats) {
                    if (chat.id_type === 1) {
                        friends++;
                    }
                    if (chat.id_type === 2) {
                        lessons++;
                    }
                }
            }
            if (!lessons) {
                this.hideLessons();
            }
            if (!friends) {
                this.hideFriends();
            }
        }
        if (this.props.id_role === 1) {
            this.showLessons();
            this.hideLessonsTitle();
            this.hideFriends();
        }
        if (this.props.id_role !== 0 && this.props.id_role !== 1) {
            this.hideLessons();
            this.hideFriends();
            this.showEmpty();
        }
        if (!this.props.chats.length) {
            this.hideLessons();
            this.hideFriends();
            this.showEmpty();
        }
    }

    generateHTMLChats () {
        let instance = this;
        if (this.props.chats.length) {
            for (const chat of this.props.chats) {
                let li = document.createElement('li');
                li.classList.add('mt-4');
                if (this.props.id_role === 0) {
                    if (chat.id_user_logged === chat.id_user_to) {
                        if (chat.users.from.id_role === 1) {
                            this.list.children[1].children[1].children[1].appendChild(li);
                        }
                        if (chat.users.from.id_role === 0) {
                            this.list.children[1].children[2].children[1].appendChild(li);
                        }
                    }
                    if (chat.id_user_logged === chat.id_user_from) {
                        this.list.children[1].children[2].children[1].appendChild(li);
                    }
                }
                if (this.props.id_role === 1) {
                    this.list.children[1].children[1].children[1].appendChild(li);
                }
                    let link = document.createElement('a');
                    link.classList.add('flex', 'color-white', 'items-center', 'overpass');
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
                        span.classList.add('icon', 'color-five', 'overpass');
                        link.appendChild(span);
                            let icon = document.createElement('icon');
                            icon.classList.add('fas', 'fa-chevron-right');
                            span.appendChild(icon);
                if (/chat-/.exec(URL.findHashParameter()) && URL.findHashParameter().split('chat-')[1] === chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].slug) {
                    this.open(chat.id_chat);
                }
            }
        }
    }

    open (id_chat) {
        this.Modal.setProps('id', 'list');
        this.Modal.changeModalContent();
        this.changeChat(id_chat);
    }

    changeChat (id_chat) {
        let instance = this;
        for (const chat of this.props.chats) {
            if (chat.id_chat === id_chat) {
                this.details.children[1].children[0].innerHTML = '';
                let header = this.details.children[0].children[1];
                header.href = `/users/${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].slug }/profile`;
                header.children[1].innerHTML = `${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].username } (${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].name })`;
                header.children[1].classList.add('overpass');
                for (const message of chat.messages) {
                    this.addMessage(chat.id_user_logged, message);
                }
                document.querySelector(`#chat.modal #details form`).addEventListener('submit', function (e) {
                    e.preventDefault();
                    instance.send(chat);
                });
                break;
            }
        }
    }

    addMessage (id_user_logged, message) {
        let li = document.createElement('li');
        li.id = `message-${ message.id_message }`;
        this.details.children[1].children[0].appendChild(li);
        if (message.hasOwnProperty('says')) {
            li.classList.add((id_user_logged === message.id_user ? 'from' : 'to'));
                let div = document.createElement('div');
                div.classList.add('p-4', 'overpass');
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
                    link.classList.add('flex', 'justify-end', 'flex-wrap', 'p-4', 'mb-4', 'overpass');
                    div.appendChild(link);
                        let title = document.createElement('span');
                        title.classList.add('w-full', 'text-center', 'overpass');
                        title.innerHTML = message.assigment.title;
                        link.appendChild(title);
        }
    }

    async send (chat) {
        if (document.querySelector(`#chat.modal #details form input[name=message]`).value) {
            let formData = new FormData(document.querySelector(`#chat.modal #details form`));
            let token = formData.get('_token');
            formData.delete('_token');
            let query = await Fetch.send({
                method: 'POST',
                url: `/api/chats/${ (chat.id_user_logged === chat.id_user_from ? chat.id_user_to : chat.id_user_from) }`,
            }, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
                'X-CSRF-TOKEN': token,
                'Authorization': "Bearer " + this.props.token,
            }, formData);
            if (query.response.code === 200) {
                this.save(query.response.data);
                document.querySelector(`#chat.modal #details form`).reset();
            }
        }
    }

    save (data) {
        for (const key in this.props.chats) {
            if (Object.hasOwnProperty.call(this.props.chats, key)) {
                const chat = this.props.chats[key];
                if (chat.id_chat === data.chat.id_chat) {
                    this.props.chats[key] = data.chat;
                    break;
                }
            }
        }
        for (const message of data.chat.messages) {
            if (!document.querySelector(`#message-${ message.id_message }`)) {
                this.addMessage(data.chat.id_user_logged, message);
            }
        }
    }

    createCountDown () {
        let date = new Date();
        date.setMinutes(date.getMinutes() + 1);
        this.CountDown = new CountDown({
            scheduled_date_time: date,
        }, {
            end: {
                function: this.reload,
                params: {
                    chat: this
        }}});
    }

    async reload (params) {
    console.log('reload')
        params.chat.setProps('chats', []);
        params.chat.setLoadingState();
        params.chat.setProps('chats', await Chat.all(params.chat.props.token));
        params.chat.setFinishState();
        params.chat.createCountDown();
    }

    setLoadingState () {
        this.setState('status', 404);
        if (/chat-/.exec(URL.findHashParameter())) {
            this.refreshChat();
        }
        this.detectChats();
        this.generateHTMLChats();
    }

    setFinishState () {
        this.setState('status', 200);
        if (/chat-/.exec(URL.findHashParameter())) {
            this.refreshChat();
        }
        this.detectChats();
        this.generateHTMLChats();
    }

    refreshChat () {
        this.details.children[1].children[0].innerHTML = '';
        let li = document.createElement('li');
        this.details.children[1].children[0].appendChild(li);
            let span = document.createElement('span');
            span.classList.add('color-grey', 'block', 'text-center', 'mt-4');
            span.innerHTML = 'No hay mensajes, sé el primero en escribir';
            li.appendChild(span);
        if (this.props.chats.length) {
            for (const chat of this.props.chats) {
                if (URL.findHashParameter().split('chat-')[1] === chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].slug) {
                    this.changeChat(chat.id_chat);
                }
            }
        }
    }

    showLessons () {
        this.list.children[1].children[1].classList.remove('hidden');
    }

    showFriends () {
        this.list.children[1].children[2].classList.remove('hidden');
    }

    showEmpty () {
        this.list.children[1].children[3].classList.remove('hidden');
    }

    hideLessons (title = false) {
        this.list.children[1].children[1].classList.add('hidden');
        if (title) {
            this.list.children[1].children[1].children[1].classList.add('hidden');
        }
    }

    hideLessonsTitle (title = false) {
        this.list.children[1].children[1].children[1].classList.add('hidden');
    }

    hideFriends () {
        this.list.children[1].children[2].classList.add('hidden');
    }

    hideEmpty () {
        this.list.children[1].children[3].classList.add('hidden');
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