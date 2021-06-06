import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { CountDown as CountDownJS } from "../../submodules/CountDownJS/js/CountDown.js";
import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { Filter as FilterJS } from "../../submodules/FilterJS/js/Filter.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

import Asset from "./Asset.js";
import Assigment from "./Assigment.js";
import Message from "./Message.js";

export class Chat extends Class {
    constructor (props, chats = []) {
        super(props);
        this.setProps('chats', chats);
        Chat.setModalJS();
        this.setHTML(document.querySelector('#chat.modal .modal-content'));
        this.setList();
        this.setDetails();
        this.setEventListeners();
        this.createCountDownList();
    }

    setChats (params) {
        if (params.hasOwnProperty('current')) {
            params.instance.setProps('chats', params.current);
        }
        let lessons = [], friends = [];
        for (const chat of params.instance.props.chats) {
            chat.instance = params.instance;
        }
        if (params.instance.props.id_role === 0) {
            for (const chat of params.instance.props.chats) {
                if (chat.id_user_logged === chat.id_user_to) {
                    if (chat.users.from.id_role === 1) {
                        lessons.push(chat);
                    }
                    if (chat.users.from.id_role === 0) {
                        friends.push(chat);
                    }
                }
                if (chat.id_user_logged === chat.id_user_from) {
                    friends.push(chat);
                }
            }
        }
        if (params.instance.props.id_role === 1) {
            lessons = params.instance.props.chats;
        }
        if (params.instance.sections.list.lessons.children.length > 1) {
            for (const key in params.instance.sections.list.lessons.children) {
                if (Object.hasOwnProperty.call(params.instance.sections.list.lessons.children, key)) {
                    const child = params.instance.sections.list.lessons.children[key];
                    if (parseInt(key) > 0) {
                        child.parentNode.removeChild(child);
                    }
                }
            }
        }
        if (params.instance.sections.list.friends.children.length > 1) {
            for (const key in params.instance.sections.list.friends.children) {
                if (Object.hasOwnProperty.call(params.instance.sections.list.friends.children, key)) {
                    const child = params.instance.sections.list.friends.children[key];
                    if (parseInt(key) > 0) {
                        child.parentNode.removeChild(child);
                    }
                }
            }
        }
        params.instance.sections.list.lessons.appendChild(Chat.component('list', { chats: lessons }));
        params.instance.sections.list.friends.appendChild(Chat.component('list', { chats: friends }));
    }

    setDetails () {
        if (!this.sections) {
            this.sections = {};
        }
        if (!this.sections.details) {
            this.sections.details = {
                html: this.html.children[1],
                header: this.html.children[1].children[0].children[1],
                main: this.html.children[1].children[1],
            };
        }
    }

    setEventListeners () {
        const instance = this;

        document.querySelector(`#chat.modal #details form`).addEventListener('submit', function (e) {
            e.preventDefault();
            for (const chat of instance.props.chats) {
                if (chat.id_chat === instance.opened) {
                    instance.send(chat);
                }
            }
        });

        document.querySelector(`#chat.modal #list form`).addEventListener('submit', function (e) {
            e.preventDefault();
        });

        if (document.querySelector(`#chat.modal #details form a`)) {
            document.querySelector(`#chat.modal #details form a`).addEventListener('click', function (e) {
                instance.addAssigment();
            });
        }

        document.querySelector(`#chat.modal #details header > a`).addEventListener('click', function (e) {
            instance.close();
        });
    }

    setFilter () {
        if (!this.FilterJS) {
            if (parseInt(this.props.id_role) === 0) {
                this.FilterJS = new FilterJS({
                    id: 'filter-chats',
                    order: [
                        ['updated_at', 'DESC'],
                    ],
                    rules: {
                        search: [['users:from.username', 'users:from.name', 'users:to.username', 'users:to.name']],
                }}, {}, {
                    run: {
                        function: this.setChats,
                        params: { instance: this }
                }}, this.props.chats);
            }
            if (parseInt(this.props.id_role) === 1) {
                this.FilterJS = new FilterJS({
                    id: 'filter-chats',
                    order: [
                        ['updated_at', 'DESC'],
                    ],
                    rules: {
                        search: [['users:to.username', 'users:to.name']],
                }}, {}, {
                    run: {
                        function: this.setChats,
                        params: { instance: this }
                }}, this.props.chats);
            }
        }
    }

    setFinishState () {
        this.setState('status', 200);
        this.FilterJS.changeData(this.props.chats);
        if (document.querySelector('#chat.modal #list form input').value) {
            this.FilterJS.run();
        }
        if (!document.querySelector('#chat.modal #list form input').value) {
            this.setChats({
                instance: this,
            });
        }
    }

    async setList () {
        if (!this.sections) {
            this.sections = {};
        }
        if (!this.sections.list) {
            this.sections.list = {
                html: this.html.children[0],
                lessons: this.html.children[0].children[1].children[1],
                friends: this.html.children[0].children[1].children[2],
                empty: this.html.children[0].children[1].children[3],
            };
        }
        if (!this.props.id_role) {
            await this.checkRole();
        }
        this.setChats({
            instance: this,
        });
        this.setFilter();
    }

    setLoadingState () {
        this.setState('status', 404);
        this.setChats({
            instance: this,
        });
        this.FilterJS.changeData(this.props.chats);
    }

    setLoadingChatState () {
        this.setState('status', 404);
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

    async checkRole () {
        await this.getRole();
        if (this.props.id_role === 0) {
            this.showUserChat();
        }
        if (this.props.id_role === 1) {
            this.showTeacherChat();
        }
        if (this.props.id_role !== 0 && this.props.id_role !== 1) {
            this.showAdminChat();
        }
        if (this.props.chats.length) {
            this.sections.list.empty.classList.add("hidden");
        }
        if (!this.props.chats.length) {
            this.sections.list.lessons.classList.add("hidden");
            this.sections.list.friends.classList.add("hidden");
            this.sections.list.empty.classList.remove("hidden");
        }
    }

    changeChat () {
        for (const chat of this.props.chats) {
            if (chat.id_chat === this.opened) {
                this.openChat(chat);
                break;
            }
        }
    }

    addAssigment () {
        let games = [];
        for (const chat of this.props.chats) {
            if (chat.id_chat === this.opened) {
                games = (chat.id_user_logged === chat.id_user_from ? chat.users['from'].games : chat.users['to'].games);
                break;
            }
        }
        new Assigment({
            games: games,
        });
        Assigment.setValidationJS({
            function: this.sendAssigment,
            params: { instance: this },
        });
    }

    addMessage (message) {
        if (this.sections.details.main.children[1].children.length === 1 && !this.sections.details.main.children[1].children[0].classList.length) {
            this.sections.details.main.children[1].innerHTML = '';
        }
        this.sections.details.main.children[1].appendChild(Message.component('item', message));
    }

    changeUserProfile (chat) {
        this.sections.details.header.children[1].classList.add("overpass");
        this.sections.details.header.href = `/users/${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].slug }/profile`;
        this.sections.details.header.innerHTML = '';
            let figure = document.createElement('figure');
            this.sections.details.header.appendChild(figure);
                let image = document.createElement('img');
                image.alt = `${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].username } profile image`;
                if (!chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                    image.src = new Asset(`img/resources/ProfileSVG.svg`).route;
                }
                if (chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                    image.src = new Asset(`storage/${ chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile'] }`).route;
                }
                figure.appendChild(image);

            let span = document.createElement('span');
            span.classList.add("ml-2");
            this.sections.details.header.appendChild(span);
            span.innerHTML = `${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].username } (${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].name })`;
    }

    showUserChat () {
        this.sections.list.lessons.classList.remove("hidden");
        this.sections.list.friends.classList.remove("hidden");
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
            this.sections.list.lessons.classList.add("hidden");
        }
        if (!friends) {
            this.sections.list.friends.classList.add("hidden");
        }
    }

    showTeacherChat () {
        this.sections.list.lessons.classList.remove("hidden");
        this.sections.list.lessons.children[0].classList.add("hidden");
        this.sections.list.friends.classList.add("hidden");
    }

    showAdminChat () {
        this.sections.list.lessons.classList.add("hidden");
        this.sections.list.friends.classList.remove("hidden");
        this.sections.list.friends.children[0].classList.add("hidden");
    }

    createCountDownDetails () {
        if (!this.CountDownJS) {
            this.CountDownJS = {};
        }
        let date = new Date();
        date.getSeconds(date.getSeconds() + 1);
        this.CountDownJS.details = new CountDownJS({
            scheduled_date_time: date,
        }, {
            end: {
                function: this.reloadChat,
                params: { instance: this }
        }});
    }

    createCountDownList () {
        if (!this.CountDownJS) {
            this.CountDownJS = {};
        }
        let date = new Date();
        date.setMinutes(date.getMinutes() + 1);
        this.CountDownJS.list = new CountDownJS({
            scheduled_date_time: date,
        }, {
            end: {
                function: this.reload,
                params: { instance: this }
        }});
    }

    close () {
        this.opened = null;
        this.sections.list.html.classList.remove('hidden');
        this.sections.list.html.classList.add('block');
        this.sections.details.html.classList.remove('block');
        this.sections.details.html.classList.add('hidden');
        this.CountDownJS.list.continue();
    }

    open (id_chat) {
        this.CountDownJS.list.pause();
        this.opened = id_chat;
        this.sections.list.html.classList.remove('block');
        this.sections.list.html.classList.add('hidden');
        this.sections.details.html.classList.remove('hidden');
        this.sections.details.html.classList.add('block');
        this.changeChat();
        this.createCountDownDetails();
    }

    openChat (chat) {
        this.changeUserProfile(chat);
        for (const message of chat.messages) {
            message.slug = (chat.id_user_logged === chat.id_user_from ? chat.users['to'].slug : chat.users['from'].slug);
        }
        this.sections.details.main.innerHTML = '';
        let span = document.createElement('span');
        span.classList.add("question");
        span.title = "Los mensajes se cargaran automáticamente cada 1 minuto";
        this.sections.details.main.appendChild(span);
            let icon = document.createElement('i');
            icon.classList.add("fas", "fa-question");
            span.appendChild(icon);
        this.sections.details.main.appendChild(Message.component('list', { messages: chat.messages }));
    }

    async reload (params) {
        params.instance.setProps('chats', []);
        params.instance.setLoadingState();
        params.instance.setProps('chats', await Chat.all(params.instance.props.token));
        params.instance.setFinishState();
        params.instance.createCountDownList();
    }

    async reloadChat (params) {
        for (const chat of params.instance.props.chats) {
            if (chat.id_chat === params.instance.opened) {
                chat.messages = [];
                params.instance.openChat(chat);
                break;
            }
        }
        params.instance.setLoadingChatState();
        let found = true;
        for (const chat of params.instance.props.chats) {
            if (chat.id_chat === params.instance.opened) {
                let response = await Chat.one(chat, params.instance.props.token);
                if (!response.hasOwnProperty('id_chat')) {
                    found = false;
                    break;
                }
                chat.messages = response.messages;
                params.instance.openChat(chat);
                break;
            }
        }
        if (!found) {
            params.instance.close();
        }
        if (found) {
            params.instance.setFinishState();
            params.instance.createCountDownDetails();
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
                this.addMessage(message);
            }
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

    async sendAssigment (params) {
        let response = await Assigment.submitForm(params.instance.opened, params.instance.props.token);
        if (response.code === 200) {
            modals.assigment.close();
            params.instance.save(response.data);
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

    static async one (chat, token) {
        let query = await Fetch.get(`/api/chats/${ (chat.id_user_logged === chat.id_user_from ? chat.id_user_to : chat.id_user_from) }`, {
            'Accept': 'application/json',
            'Authorization': "Bearer " + token,
        });
        if (query.response.code !== 200) {
            return 404;
        }
        return query.response.data.chat;
    }

    static setModalJS () {
        modals.chat = new ModalJS({
            id: 'chat',
        }, {
            detectHash: true,
            open: /chat-/.exec(URL.findHashParameter()),
        });
    }

    static item (data) {
        let item = document.createElement('li');
        item.id = `chat-${ data.chat.id_chat }`;
        item.classList.add("mt-4", `order-${ data.key }`);
            let link = document.createElement('a');
            link.classList.add("flex", "color-white", "items-center", "overpass");
            link.href = `#chat-${ data.chat.users[((data.chat.id_user_logged === data.chat.id_user_from) ? 'to' : 'from')].slug }`;
            item.appendChild(link);
            link.addEventListener('click', function (e) {
                data.chat.instance.open(data.chat.id_chat);
            });
                let figure = document.createElement('figure');
                figure.classList.add("image", "mr-4");
                link.appendChild(figure);
                    let image = document.createElement('img');
                    figure.appendChild(image);
                        if (!data.chat.users[((data.chat.id_user_logged === data.chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                            image.src = new Asset(`img/resources/ProfileSVG.svg`).route;
                        }
                        if (data.chat.users[((data.chat.id_user_logged === data.chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                            image.src = new Asset(`storage/${ data.chat.users[((data.chat.id_user_logged === data.chat.id_user_from) ? 'to' : 'from')].files['profile'] }`).route;
                        }

                let username = document.createElement('div');
                username.classList.add("username");
                link.appendChild(username);
                    let paragraph = document.createElement('p');
                    paragraph.innerHTML = `${ data.chat.users[((data.chat.id_user_logged === data.chat.id_user_from) ? 'to' : 'from')].username} (`;
                    username.appendChild(paragraph);
                        let name = document.createElement('span');
                        name.innerHTML = `${ data.chat.users[((data.chat.id_user_logged === data.chat.id_user_from) ? 'to' : 'from')].name }`;
                        paragraph.appendChild(name);
                        paragraph.innerHTML = `${ paragraph.innerHTML })`;

                let span = document.createElement('span');
                span.classList.add("icon", "color-five", "overpass");
                link.appendChild(span);
                    let icon = document.createElement('icon');
                    icon.classList.add("fas", "fa-chevron-right");
                    span.appendChild(icon);
        return item;
    }

    static list (data) {
        let list = document.createElement('ul'), item;
        if (data.chats.length) {
            for (const key in data.chats) {
                if (Object.hasOwnProperty.call(data.chats, key)) {
                    const chat = data.chats[key];
                    // if (!document.querySelector(`#chat.modal #list li#chat-${ chat.id_chat }`)) {
                        list.appendChild(this.component('item', { chat: chat, key: key }));
                    //     continue;
                    // }
                    // item = document.querySelector(`#chat.modal #list li#chat-${ chat.id_chat }`);
                    // for (const className of item.classList) {
                    //     item.classList.remove(className);
                    // }
                    // item.classList.add("mt-4", `order-${ data.key }`);
                }
            }
        }
        if (!data.chats.length) {
            item = document.createElement('li');
            item.classList.add("mt-4", "color-white");
            item.innerHTML = "No se encontraron resultados";
            list.appendChild(item);
        }
        return list;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}

export default Chat;