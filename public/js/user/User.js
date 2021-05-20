import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import Game from "../Game.js";

const asset = document.querySelector('meta[name=asset]').content;

export class User extends Class {
    static userComponent (data) {
        let item = document.createElement('li');
        item.classList.add("p-4", "flex", "justify-between", "items-center", "gap-4", "lg:col-span-8", "lg:col-start-2", "degradado");
            let header = document.createElement('a');
            header.href = `/users/${ data.slug }/profile`;
            header.classList.add("flex");
            item.appendChild(header);
                let photo = document.createElement('div');
                photo.classList.add("photo", "flex", "items-center", "mr-4");
                header.appendChild(photo);
                    let photo_figure = document.createElement('figure');
                    photo_figure.classList.add("profile-image");
                    photo.appendChild(photo_figure);
                        let image = document.createElement('img');
                        image.src = `${ asset }${(data.files['profile'] ?  `storage/${ data.files['profile'] }` : `img/resources/Group 15SVG.svg`)}`;
                        image.alt = `${ data.username } profile image`;
                        photo_figure.appendChild(image);
                
                let identity = document.createElement('div');
                header.appendChild(identity);
                    let username = document.createElement('h3');
                    username.classList.add("color-white", "russo");
                    username.innerHTML = data.username;
                    identity.appendChild(username);

                    let name = document.createElement('span');
                    name.classList.add("color-white", "overpass", "whitespace-nowrap", "block");
                    name.innerHTML = data.name;
                    identity.appendChild(name);
            
            let teammate = document.createElement('div');
            teammate.classList.add("h-full", "teammate", "flex", "items-center");
            item.appendChild(teammate);
                let teammate_figure = document.createElement('figure');
                teammate.appendChild(teammate_figure);
                    let fist = document.createElement('img');
                    fist.src = `${ asset }img/resources/ChoqueSVG.svg`;
                    fist.alt = "Fist svg";
                    teammate_figure.appendChild(fist);

            let lessons = document.createElement('div');
            lessons.classList.add("hidden", "md:block");
            item.appendChild(lessons);
                let lessons_text = document.createElement('span');
                lessons_text.classList.add("color-white", "overpass");
                lessons_text.innerHTML = "Clases tomadas";
                lessons.appendChild(lessons_text);

                let hours = document.createElement('p');
                hours.classList.add("color-four");
                hours.innerHTML = data.hours;
                lessons.appendChild(hours);
                
            let games = document.createElement('div');
            games.classList.add("hidden", "md:block");
            games.appendChild(Game.generateComponent('list', data.games))
            item.appendChild(games);
            
            let actions = document.createElement('div');
            actions.classList.add("btn-purple");
            item.appendChild(actions);
                let link = document.createElement('a');
                link.classList.add("btn", "btn-one", "russo", "rouded");
                link.href = `/users/${ data.slug }/profile`;
                link.innerHTML = "Contactar";
                actions.appendChild(link);
        return item;
    }

    static generateComponent (name = '', data) {
        switch (name) {
            case 'user':
                return User.userComponent(data);
        }
    }
}

export default User;