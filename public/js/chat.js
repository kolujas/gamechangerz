import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import Modal from './modal.js';

export class Chat extends Class {
    constructor (props) {
        super(props);
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
        this.setHTML(link);
        this.html.addEventListener('click', function (e) {
            instance.open();
        });
    }

    generateHTMLChat () {
        let image = document.createElement('figure');
        image.classList.add('image', 'mr-4');
        this.html.appendChild(image);
            let img = document.createElement('img');
            img.src = "/img/resources/Group 15SVG.svg";
            image.appendChild(img);

        let username = document.createElement('div');
        username.classList.add('username');
        this.html.appendChild(username);
            let paragraph = document.createElement('paragraph');
            paragraph.innerHTML = `${ this.props.user.username} (${ this.props.user.name })`;
            username.appendChild(paragraph);

        let span = document.createElement('span');
        span.classList.add('icon', 'color-five');
        this.html.appendChild(span);
            let icon = document.createElement('icon');
            icon.classList.add('fas', 'fa-chevron-right');
            span.appendChild(icon);
    }

    open () {
        this.Modal.setProps('id', 'list');
        this.Modal.changeModalContent();
    }

    static async all (token) {
        let query = await Fetch.get('/api/chats', {
            'Accept': 'application/json',
            'Authorization': "Bearer " + token,
        });
        let chats = [];
        if (query.response.code === 200) {
            for (const chat of query.response.data.chats) {
                chats.push(new this(chat));
            }
        }
        return chats;
    }
}

export default Chat;