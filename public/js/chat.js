import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import Modal from './modal.js';

export class Chat extends Class {
    constructor (props, token) {
        super(props);
        this.setProps('token', token)
        this.createHTML();
        this.generateHTMLChat();
    }

    createHTML () {
        let instance = this;
        this.Modal = new Modal({
            id: 'list',
        });
        let li = document.createElement('li');
        li.classList.add('mt-4');
        this.Modal.ModalJS.html.children[0].children[0].children[1].children[1].appendChild(li);
        let link = document.createElement('a');
        link.classList.add('flex', 'color-white', 'items-center');
        link.href = `#chat-${ this.props.user.slug }`;
        li.appendChild(link);
        this.list = link;
        this.details = document.querySelector('#chat.modal #details main ul');
        this.list.addEventListener('click', function (e) {
            instance.open();
        });
    }

    generateHTMLChat () {
        let image = document.createElement('figure');
        image.classList.add('image', 'mr-4');
        this.list.appendChild(image);
            let img = document.createElement('img');
            img.src = "/img/resources/Group 15SVG.svg";
            image.appendChild(img);

        let username = document.createElement('div');
        username.classList.add('username');
        this.list.appendChild(username);
            let paragraph = document.createElement('paragraph');
            paragraph.innerHTML = `${ this.props.user.username} (${ this.props.user.name })`;
            username.appendChild(paragraph);

        let span = document.createElement('span');
        span.classList.add('icon', 'color-five');
        this.list.appendChild(span);
            let icon = document.createElement('icon');
            icon.classList.add('fas', 'fa-chevron-right');
            span.appendChild(icon);
    }

    open () {
        this.Modal.setProps('id', 'list');
        this.Modal.changeModalContent();
        this.changeChat();
    }

    changeChat () {
        let instance = this;
        this.details.innerHTML = '';
        for (const message of this.props.messages) {
            this.addMessage(message);
        }
        document.querySelector(`#chat.modal #details form`).addEventListener('submit', function (e) {
            e.preventDefault();
            instance.send();
        });
    }

    addMessage (message) {
        let li = document.createElement('li');
        this.details.appendChild(li);
        if (message.hasOwnProperty('says')) {
            li.classList.add((this.props.user.id_user === message.id_user ? 'to' : 'from'), 'p-4', 'mb-4');
                let paragraph = document.createElement('p');
                paragraph.innerHTML = message.says;
                li.appendChild(paragraph);
        } else {
            li.classList.add('assigment');
                let link = document.createElement('a');
                link.href = `#assigment-${ message.assigment.slug }`;
                link.classList.add('flex', 'justify-end', 'flex-wrap', 'p-4', 'mb-4');
                li.appendChild(link);
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
                chats.push(new this(chat, token));
            }
        }
        return chats;
    }
}

export default Chat;