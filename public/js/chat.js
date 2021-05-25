import { URLServiceProvider as URL } from "../submodules/ProvidersJS/js/URLServiceProvider.js";
import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { Filter as FilterJS } from "../submodules/FilterJS/js/Filter.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import Modal from './modal.js';
import CountDown from "./CountDown.js";
import Assigment from "./assigment.js";
import { Validation as ValidationJS } from "../submodules/ValidationJS/js/Validation.js";

const asset = document.querySelector('meta[name=asset]').content;

export class Chat extends Class {
    constructor (props, chats = []) {
        super(props);
        let instance = this;
        this.setProps('chats', chats);
        this.setModal();
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
        // this.createCountDown();
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

    async setModal () {
        this.Modal = new Modal({
            id: 'list',
        });
        this.setHTML(this.Modal.ModalJS.html.children[0]);
        this.list = this.html.children[0];
        this.details = this.html.children[1];
        await this.getRole();
        this.detectRole();
        this.generateList({
            instance: this,
            current: this.props.chats,
        });
        this.setFilter();
    }

    setFilter () {
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
                    function: this.generateList,
                    params: {
                        instance: this,
            }}}, this.props.chats);
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
                    function: this.generateList,
                    params: {
                        instance: this,
            }}}, this.props.chats);
        }
    }

    detectRole () {
        if (this.props.id_role === 0) {
            this.showLessons();
            this.showFriends();
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
        if (this.props.chats.length) {
            this.hideEmpty();
        }
        if (!this.props.chats.length) {
            this.hideLessons();
            this.hideFriends();
            this.showEmpty();
        }
    }

    generateList (params) {
        console.log(params);
        params.instance.list.children[1].children[1].children[1].innerHTML = '';
        params.instance.list.children[1].children[2].children[1].innerHTML = '';
        if (params.current.length) {
            for (const chat of params.current) {
                let li = document.createElement('li');
                li.classList.add('mt-4');
                if (params.instance.props.id_role === 0) {
                    if (chat.id_user_logged === chat.id_user_to) {
                        if (chat.users.from.id_role === 1) {
                            params.instance.list.children[1].children[1].children[1].appendChild(li);
                        }
                        if (chat.users.from.id_role === 0) {
                            params.instance.list.children[1].children[2].children[1].appendChild(li);
                        }
                    }
                    if (chat.id_user_logged === chat.id_user_from) {
                        params.instance.list.children[1].children[2].children[1].appendChild(li);
                    }
                }
                if (params.instance.props.id_role === 1) {
                    params.instance.list.children[1].children[1].children[1].appendChild(li);
                }
                    let link = document.createElement('a');
                    link.classList.add('flex', 'color-white', 'items-center', 'overpass');
                    link.href = `#chat-${ chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].slug }`;
                    li.appendChild(link);
                    link.addEventListener('click', function (e) {
                        params.instance.open(chat.id_chat);
                    });
                        let image = document.createElement('figure');
                        image.classList.add('image', 'mr-4');
                        link.appendChild(image);
                        let img = document.createElement('img');
                        image.appendChild(img);
                            if (!chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                                img.src = `${ asset }img/resources/Group 15SVG.svg`;
                            }
                            if (chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                                img.src = `${ asset }storage/${ chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile'] }`;
                            }
    
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
                // if (/chat-/.exec(URL.findHashParameter()) && URL.findHashParameter().split('chat-')[1] === chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].slug) {
                //     this.open(chat.id_chat);
                // }
            }
        }
        if (params.instance.list.children[1].children[1].children[1].innerHTML === '') {
            let item = document.createElement('li');
            item.classList.add('mt-4');
            item.innerHTML = "No se encontraron resultados";
            params.instance.list.children[1].children[1].children[1].appendChild(item);
        }
        if (params.instance.list.children[1].children[2].children[1].innerHTML === '') {
            let item = document.createElement('li');
            item.classList.add('mt-4', 'color-grey');
            item.innerHTML = "No se encontraron resultados";
            params.instance.list.children[1].children[2].children[1].appendChild(item);
        }
    }

    open (id_chat) {
        this.opened = id_chat;
        this.Modal.setProps('id', 'list');
        this.Modal.changeModalContent();
        this.changeChat();
    }

    changeChat () {
        for (const chat of this.props.chats) {
            if (chat.id_chat === this.opened) {
                this.details.children[1].children[0].innerHTML = '';
                let header = this.details.children[0].children[1];
                header.innerHTML = '';
                header.href = `/users/${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].slug }/profile`;
                    let figure = document.createElement('figure');
                    header.appendChild(figure);
                        let image = document.createElement('img');
                        image.alt = `${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].username } profile image`;
                        if (!chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                            image.src = `${ asset }img/resources/Group 15SVG.svg`;
                        }
                        if (chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile']) {
                            image.src = `${ asset }storage/${ chat.users[((chat.id_user_logged === chat.id_user_from) ? 'to' : 'from')].files['profile'] }`;
                        }
                        figure.appendChild(image);
                    let span = document.createElement('span');
                    span.classList.add('ml-2');
                    header.appendChild(span);
                    span.innerHTML = `${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].username } (${ chat.users[(chat.id_user_logged === chat.id_user_from ? 'to' : 'from')].name })`;
                header.children[1].classList.add('overpass');
                for (const message of chat.messages) {
                    this.addMessage(chat.id_user_logged, message, (chat.id_user_logged === chat.id_user_from ? chat.users['to'].slug : chat.users['from'].slug));
                }
                break;
            }
        }
    }

    addMessage (id_user_logged, message, slug) {
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
                    link.href = `#chat-${ slug }-assigment-${ message.assigment.slug }`;
                    link.classList.add('flex', 'justify-end', 'flex-wrap', 'p-4', 'mb-4', 'overpass');
                    link.addEventListener('click', function (e) {
                        modals.assigment.ModalJS.open({
                            assigment: message.assigment 
                        });
                    });
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
                this.addMessage(data.chat.id_user_logged, message, (data.chat.id_user_logged === data.chat.id_user_from ? data.chat.users['to'].slug : data.chat.users['from'].slug));
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
        this.detectRole();
        this.generateList({
            instance: this,
            current: this.props.chats,
        });
    }

    setFinishState () {
        this.setState('status', 200);
        if (/chat-/.exec(URL.findHashParameter())) {
            this.refreshChat();
        }
        this.detectRole();
        this.generateList({
            instance: this,
            current: this.props.chats,
        });
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
                    this.opened = chat.id_chat;
                    this.changeChat();
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

    hideLessonsTitle () {
        this.list.children[1].children[1].children[0].classList.add('hidden');
    }

    hideFriends () {
        this.list.children[1].children[2].classList.add('hidden');
    }

    hideEmpty () {
        this.list.children[1].children[3].classList.add('hidden');
    }

    addAssigment () {
        let games = [];
        for (const chat of this.props.chats) {
            if (chat.id_chat === this.opened) {
                games = (chat.id_user_logged === chat.id_user_from ? chat.users['from'].games : chat.users['to'].games);
                break;
            }
        }
        this.assigment = new Assigment({
            games: games,
        });
        if (!validation['assigment-form'].ValidationJS) {
            if (validation['assigment-form']) {
                validation['assigment-form'] = new ValidationJS({
                    id: 'assigment-form',
                    rules: validation['assigment-form'].rules,
                    messages: validation['assigment-form'].messages,
                }, {
                    submit: false,
                }, {
                    submit: {
                        function: this.sendAssigment,
                        params: {
                            instance: this
                }}});
            } else {
                console.error(`validation.assigment-form does not exist`);
            }
        }
    }

    async sendAssigment (params) {
        let response = await Assigment.send(params.instance.opened, params.instance.props.token);
        if (response.code === 200) {
            modals.assigment.ModalJS.close();
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
}

export default Chat;