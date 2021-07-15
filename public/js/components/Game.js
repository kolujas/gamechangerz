import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

import Asset from "./Asset.js";

export class Game extends Class {
    static setModalJS () {
        modals.games = new ModalJS({
            id: 'games',
        }, {
            open: URL.findHashParameter() === 'games',
            detectHash: true,
            outsideClick: true,
        });
    }

    static item (game) {
        let item = document.createElement('li');
        item.classList.add("card", "text-center");
        item.setAttribute("style", `--game-color-one: ${ game.colors[0] }; --game-color-two: ${ game.colors[1] };`);
            let link = document.createElement('a');
            link.classList.add("flex", "flex-wrap", "justify-center", "items-center");
            item.appendChild(link);
            if (game.active) {
                link.href = `/games/${ game.slug }`;
            }
            if (!game.active) {
                link.classList.add("disabled");
            }
                let header = document.createElement('header');
                header.classList.add("py-4");
                link.appendChild(header);
                    let name = document.createElement('h3');
                    name.classList.add("russo");
                    name.innerHTML = game.name;
                    header.appendChild(name);
                    
                    let alias = document.createElement('h3');
                    alias.classList.add("hidden", "russo");
                    alias.innerHTML = game.alias;
                    header.appendChild(alias);
                
                let main = document.createElement('main');
                main.classList.add("card-body");
                link.appendChild(main);
                    let figure = document.createElement('figure');
                    main.appendChild(figure);
                        let image = document.createElement('img');
                        image.src = new Asset(`${ game.files['background'] }`).route;
                        image.alt = `${ game.name } image`;
                        figure.appendChild(image);
        return item;
    }

    static list (data) {
        let list = document.createElement('ul');
        list.classList.add("cards", "games", "mt-12", "grid", "md:grid-cols-2", "lg:grid-cols-4");
            for (const game of data) {
                list.appendChild(Game.item(game));
            }
            if (!data.length) {
                let item = document.createElement('li');
                item.classList.add("card");
                list.appendChild(item);
                    let div = document.createElement('div');
                    div.classList.add("flex", "flex-wrap", "p-6", "color-grey");
                    item.appendChild(div);
                        let span = document.createElement('span');
                        span.classList.add("overpass");
                        span.innerHTML = "No hay juegos que mostrar";
                        div.appendChild(span);
            }
        return list;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}

export default Game;