import Assignment from "./Assignment.js";

export class Message extends window.class {
    static item (data) {
        let item = document.createElement("li");
        item.id = `message-${ data.id_message }`;
        if (data.hasOwnProperty("id_lesson")) {
            item.classList.add(`lesson-${ data.id_lesson }`);
        }
        if (data.hasOwnProperty("says")) {
            item.classList.add((data.id_user_logged === data.id_user ? "from" : "to"));
                let div = document.createElement("div");
                div.classList.add("p-4", "overpass");
                item.appendChild(div);
                    let paragraph = document.createElement("p");
                    paragraph.innerHTML = data.says;
                    div.appendChild(paragraph);
        }
        if (data.hasOwnProperty("abilities")) {
            item.classList.add("abilities", "flex", "flex-wrap", "gap-2", "justify-end");
                let title = document.createElement("span");
                title.classList.add("block", "text-right", "mb-2", "text-sm", "w-full", "color-white");
                if (data.selected) {
                    title.innerHTML = "Habilidades elegídas:";
                }
                if (!data.selected) {
                    title.innerHTML = "¿Te gustaria mejorar en alguna habilidad en particular? Si aún no lo sabes, no es necesario que selecciones ningúna para poder continuar";
                }
                item.appendChild(title);

                for (const ability of data.abilities) {
                    let input = document.createElement("input");
                    input.classList.add("hidden");
                    input.type = "checkbox";
                    if (!data.hasOwnProperty("disabled")) {
                        input.disabled = true;
                    }
                    input.value = ability.id_ability;
                    input.id = `message-${ data.id_message }-ability-${ ability.id_ability }`;
                    item.appendChild(input);

                    let label = document.createElement("label");
                    label.classList.add("mb-6");
                    label.htmlFor = `message-${ data.id_message }-ability-${ ability.id_ability }`;
                    item.appendChild(label);
                        let span = document.createElement("span");
                        span.classList.add("bg-one", "color-white", "px-4", "py-2", "rounded");
                        span.innerHTML = ability.name;
                        label.appendChild(span);
                }
        }
        if (data.hasOwnProperty("assignment")) {
            item.classList.add("assignment");
                let div = document.createElement("div");
                item.appendChild(div);
                    let link = document.createElement("a");
                    link.href = `#chat-${ data.slug }-assignment-${ data.assignment.id_assignment }`;
                    link.classList.add("flex", "justify-end", "flex-wrap", "p-4", "mb-4", "overpass");
                    if (data.assignment.hasOwnProperty("presentation") && data.assignment.presentation) {
                        link.classList.add("complete");
                    }
                    div.appendChild(link);
                        let spinner = document.createElement("span");
                        link.appendChild(spinner);
                            let spinnerDiv = document.createElement("div");
                            spinnerDiv.classList.add("loading", "hidden");
                            spinner.appendChild(spinnerDiv);
                                let spinnerIcon = document.createElement("i");
                                spinnerIcon.classList.add("spinner-icon");
                                spinnerDiv.appendChild(spinnerIcon);
                        let description = document.createElement("span");
                        description.classList.add("w-full", "text-center", "overpass");
                        description.innerHTML = "Tarea";
                        link.appendChild(description);

                    link.addEventListener("click", function (e) {
                        e.preventDefault();
                        Message.getAssignment(data, link);
                    });
        }
        return item;
    }

    static list (data) {
        let list = document.createElement("ul");
        list.classList.add("mx-2", "px-2", "py-4");
        if (data.messages.length) {
            if ([...data.messages].pop().hasOwnProperty("id_lesson") && [...data.messages].pop().id_lesson != [...data.lessons].pop().id_lesson && data.id_user_logged == data.id_user_to) {
                let key = 1;
                for (const message of data.messages) {
                    if (key <= message.id_message) {
                        key = parseInt(message.id_message) + 1;
                    }
                }
                data.messages.push({
                    id_message: key,
                    id_user: data.users.to.id_user,
                    disabled: false,
                    selected: true,
                    abilities: (() => {
                        let abilities = [];
                        for (const game of data.users.from.games) {
                            for (const ability of game.abilities) {
                                abilities.push(ability);
                            }
                        }
                        return abilities; 
                    })()
                });
            }
            for (const message of data.messages) {
                list.appendChild(this.component("item", message));
            }
        }
        if (!data.messages.length) {
            if (data.hasOwnProperty("lessons")) {
                if (data.id_user_logged == data.id_user_to) {
                    list.appendChild(this.component("item", {
                        id_message: 1,
                        id_user: data.users.to.id_user,
                        disabled: false,
                        abilities: (() => {
                            let abilities = [];
                            for (const game of data.users.from.games) {
                                for (const ability of game.abilities) {
                                    abilities.push(ability);
                                }
                            }
                            return abilities; 
                        })()
                    }));
                }
                if (data.id_user_logged != data.id_user_to) {
                    let item = document.createElement("li");
                    list.appendChild(item);
                        let span = document.createElement("span");
                        span.classList.add("color-grey", "block", "text-center", "mt-4", "overpass");
                        span.innerHTML = "No hay mensajes, sé el primero en escribir";
                        item.appendChild(span);
                }
            }
            if (!data.hasOwnProperty("lessons")) {
                let item = document.createElement("li");
                list.appendChild(item);
                    let span = document.createElement("span");
                    span.classList.add("color-grey", "block", "text-center", "mt-4", "overpass");
                    span.innerHTML = "No hay mensajes, sé el primero en escribir";
                    item.appendChild(span);
            }
        }
        return list;
    }

    static component (name = "", data) {
        return this[name](data);
    }

    static async getAssignment (data, div) {
        if (data.chat.setLoadingState()) {
            div.children[0].children[0].classList.remove("hidden");
            div.children[1].classList.add("hidden");
    
            let assignment = await Assignment.one(data.assignment.id_assignment);
    
            data.chat.setFinishState();
            div.children[0].children[0].classList.add("hidden");
            div.children[1].classList.remove("hidden");
    
            modals.assignment.open({
                id_chat: data.id_chat,
                assignment: assignment,
                id_role: data.id_role
            });
        }
    }
}

export default Message;