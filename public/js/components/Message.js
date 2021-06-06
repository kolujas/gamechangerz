import Class from "../../submodules/JuanCruzAGB/js/Class.js";

export class Message extends Class {
    static item (data) {
        let item = document.createElement('li');
        item.id = `message-${ data.id_message }`;
        if (data.hasOwnProperty('says')) {
            item.classList.add((data.id_user_logged === data.id_user ? 'from' : 'to'));
                let div = document.createElement('div');
                div.classList.add("p-4", "overpass");
                item.appendChild(div);
                    let paragraph = document.createElement('p');
                    paragraph.innerHTML = data.says;
                    div.appendChild(paragraph);
        } else {
            item.classList.add("assigment");
                let div = document.createElement('div');
                item.appendChild(div);
                    let link = document.createElement('a');
                    link.href = `#chat-${ data.slug }-assigment-${ data.assigment.slug }`;
                    link.classList.add("flex", "justify-end", "flex-wrap", "p-4", "mb-4", "overpass");
                    link.addEventListener('click', function (e) {
                        modals.assigment.open({
                            assigment: data.assigment 
                        });
                    });
                    div.appendChild(link);
                        let title = document.createElement('span');
                        title.classList.add("w-full", "text-center", "overpass");
                        title.innerHTML = data.assigment.title;
                        link.appendChild(title);
        }
        return item;
    }

    static list (data) {
        let list = document.createElement('ul');
        list.classList.add("mx-2", "px-2", "py-4");
        if (data.messages.length) {
            for (const message of data.messages) {
                list.appendChild(this.component('item', message));
            }
        }
        if (!data.messages.length) {
            let item = document.createElement('li');
            list.appendChild(item);
                let span = document.createElement('span');
                span.classList.add("color-grey", "block", "text-center", "mt-4", "overpass");
                span.innerHTML = "No hay mensajes, sé el primero en escribir";
                item.appendChild(span);
        }
        return list;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}

export default Message;