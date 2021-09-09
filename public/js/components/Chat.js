import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { CountDown as CountDownJS } from "../../submodules/CountDownJS/js/CountDown.js";
import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Filter from "../../submodules/FilterJS/js/Filter.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";
import { Notification as NotificationJS } from "../../submodules/NotificationJS/js/Notification.js";

import Asset from "./Asset.js";
import Assigment from "./Assigment.js";
import Presentation from "./Presentation.js";
import Message from "./Message.js";
import Token from "../components/Token.js";

export class Chat extends Class {
    constructor (props, chats = []) {
        super(props, { state: true });
        this.setProps("chats", chats);
        Chat.setModalJS();
        this.setHTML(document.querySelector("#chat.modal .modal-content"));
        this.setList();
        this.setDetails();
        this.setEventListeners();
        this.createCountDownList();
    }

    setChats (params) {
        if (params.hasOwnProperty("current")) {
            params.instance.setProps("chats", params.current);
        }
        let lessons = [], friends = [];
        for (const chat of params.instance.props.chats) {
            chat.instance = params.instance;
        }
        if (params.instance.props.id_role == 0) {
            for (const chat of params.instance.props.chats) {
                if (chat.id_user_logged == chat.id_user_to) {
                    if (chat.users.from.id_role == 1) {
                        lessons.push(chat);
                    }
                    if (chat.users.from.id_role == 0) {
                        friends.push(chat);
                    }
                }
                if (chat.id_user_logged == chat.id_user_from) {
                    friends.push(chat);
                }
            }
        }
        if (params.instance.props.id_role != 0) {
            lessons = params.instance.props.chats;
        }
        
        if (document.querySelector("#chat.modal #list ul#list-lessons")) {
            params.instance.changeOrder(lessons, "lessons");
        }
        if (!document.querySelector("#chat.modal #list ul#list-lessons")) {
            params.instance.sections.list.lessons.appendChild(Chat.component("list", { chats: lessons, type: "lessons" }));
        }
        if (document.querySelector("#chat.modal #list ul#list-friends")) {
            params.instance.changeOrder(friends, "friends");
        }
        if (!document.querySelector("#chat.modal #list ul#list-friends")) {
            params.instance.sections.list.friends.appendChild(Chat.component("list", { chats: friends, type: "friends" }));
        }
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
                footer: this.html.children[1].children[2],
            };
        }
    }

    setEventListeners () {
        const instance = this;

        Assigment.setValidationJS({
            function: this.send,
            params: {
                instance: this,
                section: "assigment",
            },
        });

        Presentation.setValidationJS({
            function: this.send,
            params: {
                instance: this,
                section: "presentation",
            },
        });

        document.querySelector(`#chat.modal #details header > a`).addEventListener("click", function (e) {
            if (instance.state.state) {
                instance.close();
                instance.CountDownJS.details.pause();
            }
        });
    }

    setFilter () {
        if (!this.FilterJS) {
            if (parseInt(this.props.id_role) == 0) {
                this.FilterJS = new Filter({
                    id: "filter-chats",
                    order: {
                        "updated_at": "DESC",
                    }, rules: {
                        "users:[from,to].username|name": null,
                    }
                }, {}, {
                    run: {
                        function: this.setChats,
                        params: { instance: this }
                    }
                }, this.props.chats);
            }
            if (parseInt(this.props.id_role) != 0) {
                this.FilterJS = new Filter({
                    id: "filter-chats",
                    order: {
                        "updated_at": "DESC",
                    }, rules: {
                        "users:to.username|name": null,
                    }
                }, {}, {
                    run: {
                        function: this.setChats,
                        params: { instance: this }
                    }
                }, this.props.chats);
            }
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

    async getRole () {
        let query = await Fetch.get(`/api/role`, {
            "Accept": "application/json",
            "Content-type": "application/json; charset=UTF-8",
            "Authorization": "Bearer " + this.props.token,
        });
        if (query.response.code == 200) {
            this.setProps("id_role", query.response.data.id_role);
        }
    }

    async checkRole () {
        await this.getRole();
        if (this.props.id_role == 0) {
            this.showUserChat();
        }
        if (this.props.id_role != 0) {
            this.showTeacherChat();
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

    async changeChat () {
        let chat;
        for (chat of this.props.chats) {
            if (chat.id_chat == this.opened) {
                break;
            }
        }

        this.changeUserProfile(chat);
        this.sections.details.main.innerHTML = "";
            let span = document.createElement("span");
            span.classList.add("question");
            span.title = "Los mensajes se cargaran automáticamente cada 1 minuto";
            this.sections.details.main.appendChild(span);
                let icon = document.createElement("i");
                icon.classList.add("fas", "fa-question");
                span.appendChild(icon);
            
        if (chat.hasOwnProperty("id_chat")) {
            for (const message of chat.messages) {
                message.slug = (chat.id_user_logged == chat.id_user_from ? chat.users.to.slug : chat.users.from.slug);
                message.id_chat = chat.id_chat;
                message.chat = this;
            }
            this.sections.details.main.appendChild(Message.component("list", chat));
            this.sections.details.main.children[1].scrollTo(0, this.sections.details.main.children[1].scrollHeight);
        }

        this.sections.details.footer.innerHTML = "";
        
        let response = await Chat.one(chat, this.props.token);
        if (!response.hasOwnProperty("id_chat")) {
            this.CountDownJS.details.pause();
            this.close();
        }

        if (response.hasOwnProperty("id_chat")) {
            this.changeFooter(chat);
        }
    }

    changeOrder (chats, type) {
        let list = document.querySelector(`#chat.modal #list ul#list-${ type }`);
        for (const key in chats) {
            if (Object.hasOwnProperty.call(chats, key)) {
                const chat = chats[key];
                if (document.querySelector(`li#chat-${ chat.id_chat }`)) {
                    let item = document.querySelector(`li#chat-${ chat.id_chat }`);
                    for (const className of [...item.classList]) {
                        item.classList.remove(className);
                    }
                    item.classList.add("mt-4", `order-${ key }`);
                    continue;
                }
                list.appendChild(Chat.component("item", { chat: chat, key: key }));
            }
        }
        childs: for (const child of [...this.sections.list[type].children[1].children]) {
            for (const chat of chats) {
                if (child.id == `chat-${ chat.id_chat }`) {
                    continue childs;
                }
            }
            child.parentNode.removeChild(child);
        }
        if (this.sections.list[type].children[1].innerHTML == "") {
            let item = document.createElement("li");
            item.classList.add("color-white");
            item.innerHTML = "No se encontraron resultados";
            list.appendChild(item);
        }
    }

    addAssigment () {
        if (this.state.state) {
            let chat;
            for (chat of this.props.chats) {
                if (chat.id_chat == this.opened) {
                    break;
                }
                chat = false;
            }
            let abilities = [];
            for (const game of chat.users.from.games) {
                for (const ability of game.abilities) {
                    abilities.push(ability);
                }
            }
    
            new Assigment({
                id_chat: chat.id_chat,
                abilities: abilities,
                id_role: this.props.id_role,
            });
        }
    }

    addMessage (message) {
        if (this.sections.details.main.children[1].children.length == 1 && !this.sections.details.main.children[1].children[0].classList.length) {
            this.sections.details.main.children[1].innerHTML = "";
        }
        message.chat = this;
        this.sections.details.main.children[1].appendChild(Message.component("item", message));
    }

    changeUserProfile (chat) {
        this.sections.details.header.children[1].classList.add("overpass");
        this.sections.details.header.href = `/users/${ chat.users[(chat.id_user_logged == chat.id_user_from ? "to" : "from")].slug }/profile`;
        this.sections.details.header.innerHTML = "";
            let figure = document.createElement("figure");
            this.sections.details.header.appendChild(figure);
                let image = document.createElement("img");
                image.alt = `${ chat.users[(chat.id_user_logged == chat.id_user_from ? "to" : "from")].username } profile image`;
                if (!chat.users[((chat.id_user_logged == chat.id_user_from) ? "to" : "from")].files["profile"]) {
                    image.src = new Asset(`img/resources/ProfileSVG.svg`).route;
                }
                if (chat.users[((chat.id_user_logged == chat.id_user_from) ? "to" : "from")].files["profile"]) {
                    image.src = new Asset(`storage/${ chat.users[((chat.id_user_logged == chat.id_user_from) ? "to" : "from")].files["profile"] }`).route;
                }
                figure.appendChild(image);

            let span = document.createElement("span");
            span.classList.add("ml-2");
            this.sections.details.header.appendChild(span);
            span.innerHTML = `${ chat.users[(chat.id_user_logged == chat.id_user_from ? "to" : "from")].username } (${ chat.users[(chat.id_user_logged == chat.id_user_from ? "to" : "from")].name })`;
    }

    changeFooter (chat) {
        const instance = this;
        if (chat.available) {
            if (chat.users.from.id_role == 1) {
                let paragraph = document.createElement("p");
                paragraph.classList.add("overpass", "color-grey", "py-2", "px-4");
                paragraph.innerHTML = `${ parseInt(chat.lesson["quantity-of-assigments"]) - chat.lesson.assigments.length } tareas pendientes`;
                this.sections.details.footer.appendChild(paragraph);
                
                if (chat.users.to.id_user == chat.id_user_logged) {
                    let link = document.createElement("a");
                    link.href = "#assigment";
                    link.classList.add("my-2", "py-2", "px-4", "flex", "items-center", "overpass", "modal-button", "assigment");
                    if (!this.state.state || parseInt(chat.lesson.assigments.length) == chat.lesson["quantity-of-assigments"] || ![...chat.lesson.assigments].pop().hasOwnProperty("presentation") || ![...chat.lesson.assigments].pop().presentation) {
                        link.classList.add("disabled");
                    }
                    this.sections.details.footer.appendChild(link);
                    link.addEventListener("click", function (e) {
                        if (chat.lesson.assigments.length < parseInt(chat.lesson["quantity-of-assigments"]) && (chat.lesson.assigments.length == 0 || ([...chat.lesson.assigments].pop().hasOwnProperty("presentation") && [...chat.lesson.assigments].pop().presentation))) {
                            instance.addAssigment();
                        }
                    });
                        let icon = document.createElement("i");
                        icon.classList.add("fas", "fa-paperclip", "color-gradient");
                        link.appendChild(icon);
                }
                if (chat.users.to.id_user != chat.id_user_logged && !chat.messages.length) {
                    let button = document.createElement("button");
                    button.classList.add("my-2", "py-2", "px-4", "flex", "items-center", "overpass", "modal-button");
                    this.sections.details.footer.appendChild(button);
                    button.addEventListener("click", function (e) {
                        e.preventDefault();
                        instance.submitAbilities(chat);
                    });
                        let div = document.createElement("div");
                        div.classList.add("loading", "hidden");
                        button.appendChild(div);
                            let icon = document.createElement("i");
                            icon.classList.add("spinner-icon");
                            div.appendChild(icon);
                        let img = document.createElement("img");
                        img.src = new Asset("img/resources/SendSVG.svg").route;
                        img.alt = "Send button icon";
                        button.appendChild(img);
                }
            }
            if (chat.users.from.id_role == 0) {
                let form = document.createElement("form");
                form.action = `/api/chats/${ (chat.id_user_logged == chat.id_user_from ? chat.id_user_to : chat.id_user_from) }`;

                this.sections.details.footer.appendChild(form);
                form.addEventListener("submit", function (e) {
                    e.preventDefault();
                    if (document.querySelector(`#chat.modal #details form input[name=message]`).value && instance.state.state) {
                        instance.send({
                            instance: instance,
                            chat: chat,
                            section: "chat",
                        });
                    }
                });
                    let token = document.createElement("input");
                    token.value = document.querySelector("meta[name=csrf-token]").content;
                    token.name = "_token";
                    token.type = "hidden";
                    form.appendChild(token);
    
                    let message = document.createElement("input");
                    message.classList.add("py-2", "px-4", "overpass");
                    message.placeholder = "Escribe tu mensaje";
                    message.name = "message";
                    message.type = "text";
                    form.appendChild(message);

                    let button = document.createElement("button");
                    button.classList.add("py-2", "px-4");
                    form.appendChild(button);
                        let div = document.createElement("div");
                        div.classList.add("loading", "hidden");
                        button.appendChild(div);
                            let icon = document.createElement("i");
                            icon.classList.add("spinner-icon");
                            div.appendChild(icon);
                        let img = document.createElement("img");
                        img.src = new Asset("img/resources/SendSVG.svg").route;
                        img.alt = "Send button icon";
                        button.appendChild(img);
            }
        }
        if (!chat.available) {
            if (chat.users.from.id_user == chat.id_user_logged) {
                let paragraph = document.createElement("p");
                paragraph.classList.add("overpass", "color-grey", "py-2", "px-4", "unavailable");
                paragraph.innerHTML = "El chat no se encuentra activo";
                this.sections.details.footer.appendChild(paragraph);
            }
            if (chat.users.from.id_user != chat.id_user_logged) {
                let paragraph = document.createElement("p");
                paragraph.classList.add("overpass", "color-grey", "py-2", "px-4", "unavailable");
                paragraph.innerHTML = `${ parseInt(chat.lesson["quantity-of-assigments"]) - chat.lesson.assigments.length } tareas pendientes`;
                this.sections.details.footer.appendChild(paragraph);
            }
        }
    }

    showUserChat () {
        this.sections.list.lessons.classList.remove("hidden");
        this.sections.list.friends.classList.remove("hidden");
        let friends = 0;
        let lessons = 0;
        if (this.props.chats.length) {
            for (const chat of this.props.chats) {
                if (chat.users.from.id_role == 0) {
                    friends++;
                }
                if (chat.users.from.id_role == 1) {
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

    async submitAbilities (chat) {
        let formData = new FormData();
        let abilities = [];
        for (const input of document.querySelectorAll("#chat.modal #details .abilities input")) {
            if (input.checked) {
                abilities.push(input.value);
            }
        }
        if (abilities.length) {
            const token = Token.get();
            
            formData.append("abilities", abilities);

            let query = await Fetch.send({
                method: "POST",
                url: `/api/chats/${ chat.id_user_from }/abilities`,
            }, {
                "Accept": "application/json",
                "Content-type": "application/json; charset=UTF-8",
                "Authorization": "Bearer " + token.data,
            }, formData);

            if (query.response.code != 200) {
                this.close();
                this.CountDownJS.details.pause();
            }
            if (query.response.code == 200) {
                for (const input of document.querySelectorAll("#chat.modal #details .abilities input")) {
                    input.disabled = true;
                }
                this.CountDownJS.details.stop();
                this.save(query.response.data);
            }
        }
    }

    createCountDownDetails () {
        if (!this.CountDownJS) {
            this.CountDownJS = {};
        }
        let date = new Date();
        date.setMinutes(date.getMinutes() + 1);
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
        this.sections.list.html.classList.remove("hidden");
        this.sections.list.html.classList.add("block");
        this.sections.details.html.classList.remove("block");
        this.sections.details.html.classList.add("hidden");
        this.CountDownJS.list.stop();
    }

    open (id_chat) {
        this.CountDownJS.list.pause();
        this.opened = id_chat;
        this.sections.list.html.classList.remove("block");
        this.sections.list.html.classList.add("hidden");
        this.sections.details.html.classList.remove("hidden");
        this.sections.details.html.classList.add("block");
        this.changeChat();
        this.createCountDownDetails();
    }

    async reload (params) {
        params.instance.setProps("chats", await Chat.all(params.instance.props.token));
        params.instance.FilterJS.changeData(params.instance.props.chats);
        if (document.querySelector("#chat.modal #list form input").value) {
            params.instance.FilterJS.run();
        }
        if (!document.querySelector("#chat.modal #list form input").value) {
            params.instance.setChats({
                instance: params.instance,
            });
        }
        params.instance.createCountDownList();
    }

    async reloadChat (params) {
        let found = true;
        let chat = false;
        for (const key in [...params.instance.props.chats]) {
            if (Object.hasOwnProperty.call(params.instance.props.chats, key)) {
                chat = params.instance.props.chats[key];
                if (chat.id_chat == params.instance.opened) {
                    chat = await Chat.one(chat, params.instance.props.token);
                    if (!chat.hasOwnProperty("id_chat")) {
                        found = false;
                        break;
                    }
                    params.instance.props.chats[key] = chat;
                    for (const message of chat.messages) {
                        if (document.querySelector(`li#message-${ message.id_message }`)) {
                            if (message.hasOwnProperty("assigment") && message.assigment.hasOwnProperty("presentation") && message.assigment.presentation) {
                                document.querySelector(`li#message-${ message.id_message } a`).classList.add("complete");
                            }
                        }
                        if (!document.querySelector(`li#message-${ message.id_message }`)) {
                            if (chat.messages.length == 1) {
                                params.instance.sections.details.main.children[1].innerHTML = "";
                            }
                            params.instance.sections.details.main.children[1].appendChild(Message.component("item", { ...message, chat: params.instance, id_chat: chat.id_chat , slug: chat.users.from.slug }));
                        }
                    }
                    break;
                }
            }
        }
        if (!found) {
            params.instance.close();
        }
        if (found) {
            params.instance.sections.details.footer.innerHTML = "";
            params.instance.changeFooter(chat);
            params.instance.sections.details.main.children[1].scrollTo(0, params.instance.sections.details.main.children[1].scrollHeight);
            params.instance.setFinishState();
            params.instance.createCountDownDetails();
        }
    }

    save (data) {
        this.CountDownJS.details.stop();
        for (const key in this.props.chats) {
            if (Object.hasOwnProperty.call(this.props.chats, key)) {
                const chat = this.props.chats[key];
                if (chat.id_chat == data.chat.id_chat) {
                    this.props.chats[key] = data.chat;
                    break;
                }
            }
        }
        for (const message of data.chat.messages) {
            if (!document.querySelector(`#message-${ message.id_message }`)) {
                this.addMessage({ ...message, id_role: data.chat.users[data.chat.id_user_from == data.chat.id_user_logged ? "from" : "to"].id_role, slug: data.chat.users.from.slug, id_chat: data.chat.id_chat });
            }
            if (document.querySelector(`#message-${ message.id_message }`)) {
                if (message.hasOwnProperty("assigment") && message.assigment.hasOwnProperty("presentation") && message.assigment.presentation) {
                    document.querySelector(`#message-${ message.id_message } a`).classList.add("complete");
                }
            }
        }

        this.sections.details.footer.innerHTML = "";
        this.changeFooter(data.chat);
    }

    async send (params) {
        if (params.instance.state.state) {
            let response;
            switch (params.section) {
                case "chat":
                    params.instance.CountDownJS.details.pause();
    
                    params.instance.setLoadingState();
                    document.querySelector("#chat.modal #details footer form button").children[0].classList.remove("hidden");
                    document.querySelector("#chat.modal #details footer form button").children[1].classList.add("hidden");
                    response = await Chat.submit();
                    params.instance.setFinishState();
                    document.querySelector("#chat.modal #details footer form button").children[0].classList.add("hidden");
                    document.querySelector("#chat.modal #details footer form button").children[1].classList.remove("hidden");
    
                    document.querySelector(`#chat.modal #details footer form input`).disabled = true;
    
                    if (response.code != 200) {
                        params.instance.close();
                        params.instance.CountDownJS.details.pause();
                    }
                    if (response.code == 200) {
                        params.instance.CountDownJS.details.stop();
                        params.instance.save(response.data);
                    }
                    break;
                case "assigment":
                    params.instance.setLoadingState();
                    document.querySelector("#assigment form button").children[0].classList.remove("hidden");
                    document.querySelector("#assigment form button").children[1].classList.add("hidden");
                    response = await Assigment.submit();
                    params.instance.setFinishState();
                    document.querySelector("#assigment form button").children[0].classList.add("hidden");
                    document.querySelector("#assigment form button").children[1].classList.remove("hidden");
    
                    if (response.code != 200) {
                        params.instance.close();
                        params.instance.CountDownJS.details.pause();
                    }
                    if (response.code == 200) {
                        params.instance.CountDownJS.details.stop();
                        params.instance.save(response.data);
                        new NotificationJS({
                            code: 200,
                            message: `Tarea creada exitosamente`,
                            classes: ["russo"],
                        }, {
                            open: true,
                        });
                    }
    
                    modals.assigment.close();
    
                    document.querySelector(`#assigment-form`).reset();
                    break;
                case "presentation":
                    params.instance.setLoadingState();
                    document.querySelector("#presentation form button").children[0].classList.remove("hidden");
                    document.querySelector("#presentation form button").children[1].classList.add("hidden");
                    response = await Presentation.submit();
                    params.instance.setFinishState();
                    document.querySelector("#presentation form button").children[0].classList.add("hidden");
                    document.querySelector("#presentation form button").children[1].classList.remove("hidden");
    
                    if (response.code != 200) {
                        params.instance.close();
                        params.instance.CountDownJS.details.pause();
                    }
                    if (response.code == 200) {
                        params.instance.CountDownJS.details.stop();
                        params.instance.save(response.data);
                        new NotificationJS({
                            code: 200,
                            message: `Tarea creada exitosamente`,
                            classes: ["russo"],
                        }, {
                            open: true,
                        });
                    }
    
                    modals.presentation.close();
    
                    document.querySelector(`#presentation-form`).reset();
                    break;
            }
        }
    }

    setLoadingState () {
        if (!this.state.state) {
            return false;
        }
        if (document.querySelector("#chat #details footer .assigment")) {
            document.querySelector("#chat #details footer .assigment").classList.add("disabled");
        }
        document.querySelector("#chat #details header a:first-child").classList.add("disabled");
        this.setState("state", false);
        return true;
    }

    setFinishState () {
        if (document.querySelector("#chat #details footer .assigment")) {
            let message;
            for (const chat of this.props.chats) {
                if (chat.id_chat == this.opened) {
                    message = [...chat.messages].pop();
                }
            }
            if (message.hasOwnProperty("presentation") && message.presentation) {
                document.querySelector("#chat #details footer .assigment").classList.remove("disabled");
            }
        }
        document.querySelector("#chat #details header a:first-child").classList.remove("disabled");
        this.setState("state", true);
    }

    static async submit () {
        const token = Token.get();

        if (document.querySelector(`#chat.modal #details form input[name=message]`).value) {
            let formData = new FormData(document.querySelector(`#chat.modal #details form`));

            let _token = formData.get("_token");
            formData.delete("_token");

            let query = await Fetch.send({
                method: "POST",
                url: document.querySelector(`#chat.modal #details form`).action,
            }, {
                "Accept": "application/json",
                "Content-type": "application/json; charset=UTF-8",
                "X-CSRF-TOKEN": _token,
                "Authorization": "Bearer " + token.data,
            }, formData);

            return query.response;
        }
    }

    static async all (token) {
        let query = await Fetch.get("/api/chats", {
            "Accept": "application/json",
            "Authorization": "Bearer " + token,
        });
        let chats = [];
        if (query.response.code == 200) {
            for (const chat of query.response.data.chats) {
                chats.push(chat);
            }
        }
        return chats;
    }

    static async one (chat, token) {
        let query = await Fetch.get(`/api/chats/${ (chat.id_user_logged == chat.id_user_from ? chat.id_user_to : chat.id_user_from) }`, {
            "Accept": "application/json",
            "Authorization": "Bearer " + token,
        });
        if (query.response.code != 200) {
            return 404;
        }
        return query.response.data.chat;
    }

    static setModalJS () {
        if (!modals.hasOwnProperty("chat")) {
            modals.chat = new ModalJS({
                id: "chat",
            }, {
                detectHash: true,
                open: /chat/.exec(URL.findHashParameter()),
            });
        }
        Assigment.setModalJS();
        Presentation.setModalJS();
    }

    static item (data) {
        let item = document.createElement("li");
        item.id = `chat-${ data.chat.id_chat }`;
        item.classList.add("mt-4", `order-${ data.key }`);
            let link = document.createElement("a");
            link.classList.add("flex", "color-white", "items-center", "overpass");
            link.href = `#chat-${ data.chat.users[((data.chat.id_user_logged == data.chat.id_user_from) ? "to" : "from")].slug }`;
            item.appendChild(link);
            link.addEventListener("click", function (e) {
                data.chat.instance.open(data.chat.id_chat);
            });
                let figure = document.createElement("figure");
                figure.classList.add("image", "mr-4");
                link.appendChild(figure);
                    let image = document.createElement("img");
                    figure.appendChild(image);
                        if (!data.chat.users[((data.chat.id_user_logged == data.chat.id_user_from) ? "to" : "from")].files["profile"]) {
                            image.src = new Asset(`img/resources/ProfileSVG.svg`).route;
                        }
                        if (data.chat.users[((data.chat.id_user_logged == data.chat.id_user_from) ? "to" : "from")].files["profile"]) {
                            image.src = new Asset(`storage/${ data.chat.users[((data.chat.id_user_logged == data.chat.id_user_from) ? "to" : "from")].files["profile"] }`).route;
                        }

                let username = document.createElement("div");
                username.classList.add("username");
                link.appendChild(username);
                    let paragraph = document.createElement("p");
                    paragraph.innerHTML = `${ data.chat.users[((data.chat.id_user_logged == data.chat.id_user_from) ? "to" : "from")].username} (`;
                    username.appendChild(paragraph);
                        let name = document.createElement("span");
                        name.innerHTML = `${ data.chat.users[((data.chat.id_user_logged == data.chat.id_user_from) ? "to" : "from")].name }`;
                        paragraph.appendChild(name);
                        paragraph.innerHTML = `${ paragraph.innerHTML })`;

                let span = document.createElement("span");
                span.classList.add("icon", "color-five", "overpass");
                link.appendChild(span);
                    let icon = document.createElement("icon");
                    icon.classList.add("fas", "fa-chevron-right");
                    span.appendChild(icon);
        return item;
    }

    static list (data) {
        let list = document.createElement("ul"), item;
        list.id = `list-${ data.type }`;
        if (data.chats.length) {
            for (const key in data.chats) {
                if (Object.hasOwnProperty.call(data.chats, key)) {
                    const chat = data.chats[key];
                    list.appendChild(this.component("item", { chat: chat, key: key }));
                }
            }
        }
        if (!data.chats.length) {
            item = document.createElement("li");
            item.classList.add("color-white");
            item.innerHTML = "No se encontraron resultados";
            list.appendChild(item);
        }
        return list;
    }

    static component (name = "", data) {
        return this[name](data);
    }
}

export default Chat;