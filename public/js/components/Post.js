import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Validation as ValidationJS } from "../../submodules/ValidationJS/js/Validation.js";

import Asset from "./Asset.js";
export class Post extends Class {
    static setValidationJS () {
        if (validation.hasOwnProperty('add')) {
            validation.add.ValidationJS = new ValidationJS({
                id: 'post',
                rules: validation.add.rules,
                messages: validation.add.messages,
            });
        }
        if (validation.hasOwnProperty('update')) {
            validation.update.ValidationJS = new ValidationJS({
                id: 'post',
                rules: validation.update.rules,
                messages: validation.update.messages,
            });
        }
    }

    static item (data) {
        let item = document.createElement('li');
        item.classList.add("card", "mr-8");
            let link = document.createElement('a');
            link.href = `/blog/${ data.id_user }/${ data.slug }`;
            item.appendChild(link);
                let figure = document.createElement('figure');
                link.appendChild(figure);
                    let image = document.createElement('img');
                    image.src = new Asset(`storage/${ data.image }`).route;
                    image.alt = `${ data.title }: image`>
                    figure.appendChild(image);
                
                let main = document.createElement('main');
                main.classList.add("card-body", "p-8");
                link.appendChild(main);
                    let header = document.createElement('h4');
                    header.classList.add("color-four", "text-uppercase", "russo");
                    header.innerHTML = data.title;
                    main.appendChild(header);
                    
                    let date = document.createElement('span');
                    date.classList.add("color-grey", "block", "mb-4", "overpass");
                    date.innerHTML = data.date;
                    main.appendChild(date);

                    let description = document.createElement('div');
                    description.classList.add("post-content", "color-grey", "overpass");
                    description.innerHTML = data.description;
                    main.appendChild(description);
        return item;
    }

    static list (data) {
        let list = document.createElement('ul');
        list.classList.add("blog", "cards", "flex", "space-between", "px-8", "lg:px-0", "pb-4");
        if (data.length) {
            for (const post of data) {
                list.appendChild(this.item(post));
            }
        }
        if (!data.length) {
            let item = document.createElement('li');
            item.innerHTML = "No hay entradas que mostrar";
            item.classList.add("card", "mr-4", "info", "mb-20");
            list.appendChild(item);
                let div = document.createElement('div');
                item.appendChild(div);
                    let main = document.createElement('main');
                    main.classList.add("card-body", "p-4");
                    div.appendChild(main);
                        let header = document.createElement('h4');
                        header.classList.add("color-white", "text-uppercase");
                        header.innerHTML = "No hay entradas que mostrar";
                        main.appendChild(header);
        }
        return list;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}

export default Post;