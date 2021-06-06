import Class from "../../submodules/JuanCruzAGB/js/Class.js";

import Asset from "./Asset.js";
import Game from "./Game.js";

export class User extends Class {
    static user (data) {
        let item = document.createElement('li');
        item.classList.add("p-4", "flex", "justify-between", "items-center", "gap-4", "lg:col-span-8", "lg:col-start-2", "degradado");
            let header = document.createElement('a');
            header.href = `/users/${ data.slug }/profile`;
            header.classList.add("flex", "btn", "btn-text", "btn-white");
            item.appendChild(header);
                let photo = document.createElement('div');
                photo.classList.add("photo", "flex", "items-center", "mr-4");
                header.appendChild(photo);
                    let photo_figure = document.createElement('figure');
                    photo_figure.classList.add("profile-image");
                    photo.appendChild(photo_figure);
                        let image = document.createElement('img');
                        image.src = new Asset(`${(data.files['profile'] ?  `storage/${ data.files['profile'] }` : `img/resources/ProfileSVG.svg`)}`).route;
                        image.alt = `${ data.username } profile image`;
                        photo_figure.appendChild(image);
                
                let identity = document.createElement('div');
                header.appendChild(identity);
                    let username = document.createElement('h3');
                    username.classList.add("russo");
                    username.innerHTML = data.username;
                    identity.appendChild(username);

                    let name = document.createElement('span');
                    name.classList.add("color-grey", "overpass", "whitespace-nowrap", "block");
                    name.innerHTML = data.name;
                    identity.appendChild(name);
            
            let teammate = document.createElement('div');
            teammate.classList.add("h-full", "teammate", "flex", "items-center");
            if (data.teammate) {
                teammate.classList.add("active");
            }
            item.appendChild(teammate);
                let teammate_figure = document.createElement('figure');
                teammate.appendChild(teammate_figure);
                    let fist = document.createElement('img');
                    fist.src = new Asset(`img/resources/ChoqueSVG.svg`).route;
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
                hours.innerHTML = data.lessonsDone;
                lessons.appendChild(hours);
                
            let games = document.createElement('div');
            games.classList.add("hidden", "md:block");
            games.appendChild(Game.component('list', data.games))
            item.appendChild(games);
            
            let actions = document.createElement('div');
            actions.classList.add("btn-purple");
            item.appendChild(actions);
                let link = document.createElement('a');
                link.classList.add("btn", "btn-one", "btn-outline", "russo", "rouded");
                link.href = `/users/${ data.slug }/profile`;
                actions.appendChild(link);
                    let span = document.createElement('span');
                    span.classList.add("px-4", "py-3");
                    span.innerHTML = "Contactar";
                    link.appendChild(span);
        return item;
    }

    static teacher (data) {
        let item = document.createElement('li');
        item.classList.add('teacher');
            let main = document.createElement('main');
            main.classList.add("grid", "grid-cols-2", "md:grid-cols-3", "lg:grid-cols-12", "gap-4");
            item.appendChild(main);
                let profile = document.createElement('header');
                profile.classList.add("profile", "lg:col-span-6", "mt-4", "ml-4", "lg:my-4");
                main.appendChild(profile);
                    let container = document.createElement('div');
                    container.classList.add("grid", "gap-4", "lg:flex", "lg:flex-wrap");
                    profile.appendChild(container);
                        let identificator = document.createElement('a');
                        identificator.href = `/users/${ data.slug }/profile`;
                        identificator.classList.add("username", "btn", "btn-text", "btn-white");
                        container.appendChild(identificator);
                            let username = document.createElement('h4');
                            username.classList.add("russo");
                            username.innerHTML = data.username;
                            identificator.appendChild(username);

                            if (data.name) {
                                let name = document.createElement('h5');
                                name.classList.add("color-grey", "overpass");
                                name.innerHTML = data.name;
                                identificator.appendChild(name);
                            }
                        
                        let teampro = document.createElement('section');
                        teampro.classList.add("teampro", "flex", "items-start");
                        container.appendChild(teampro);
                            let info = document.createElement('div');
                            info.classList.add("info");
                            teampro.appendChild(info);
                                let team_name = document.createElement('span');
                                team_name.classList.add("team-name", "px-1", "text-center", "mb-3", "overpass", "rounded");
                                info.appendChild(team_name);
                                    let span = document.createElement('span');
                                    span.classList.add("inner-text");
                                    span.innerHTML = data.teampro.name;
                                    team_name.appendChild(span);

                                let languages = document.createElement('ul');
                                languages.classList.add("languages", "gap-3", "flex", "items-center");
                                info.appendChild(languages);
                                    for (const language of data.languages) {
                                        let li = document.createElement('li');
                                        li.title = language.name;
                                        languages.appendChild(li);
                                            let figure = document.createElement('figure');
                                            li.appendChild(figure);
                                                let img = document.createElement('img');
                                                img.src = new Asset(`img/languages/${ language.icon }.svg`).route;
                                                img.alt = `${ language.name } icon`;
                                                figure.appendChild(img);
                                    }
                            
                            let team_icon = document.createElement('div');
                            team_icon.classList.add("team-icon", "ml-4");
                            teampro.appendChild(team_icon);
                                let div = document.createElement('div');
                                team_icon.appendChild(div);
                                    let figure = document.createElement('figure');
                                    div.appendChild(figure);
                                        let logo = document.createElement('img');
                                        logo.src = new Asset(`storage/${ data.teampro.logo }`).route;
                                        logo.alt = `${ data.teampro.name } logo`;
                                        figure.appendChild(logo);
                        
                        let abilities = document.createElement('section');
                        abilities.classList.add("abilities", "w-full", "hidden", "md:block");
                        container.appendChild(abilities);
                            let list = document.createElement('ul');
                            list.classList.add("grid", "gap-4", "lg:grid-cols-2", "mb-4");
                            abilities.appendChild(list);
                                for (const game of data.games) {
                                    for (const ability of game.abilities) {
                                        let li = document.createElement('li');
                                        li.classList.add("flex", "justify-between", "items-center", "p-2", "xl:px-3", "rounded-sm");
                                        list.appendChild(li);
                                            span = document.createElement('span');
                                            span.classList.add("color-white", "pr-2", "russo");
                                            span.innerHTML = ability.name;
                                            li.appendChild(span);

                                            figure = document.createElement('figure');
                                            li.appendChild(figure);
                                                let img = document.createElement('img');
                                                img.src = new Asset(`img/abilities/${ ability.icon }.svg`).route;
                                                img.alt = `${ ability.name } icon`;
                                                figure.appendChild(img);
                                    }
                                }
                
                let image = document.createElement('sectin');
                image.classList.add("image", "lg:col-span-4", "row-span-2", "md:row-span-1");
                main.appendChild(image);
                    div = document.createElement('div');
                    image.appendChild(div);
                        figure = document.createElement('figure');
                        div.appendChild(figure);
                            let img = document.createElement('img');
                            img.src = new Asset(`storage/${ data.files['profile'] }`).route;
                            img.alt = `${ data.username } profile image`;
                            figure.appendChild(img);

                let payment = document.createElement('section');
                payment.classList.add("payment", "grid", "lg:col-span-2", "ml-4", "mb-4", "md:m-0", "md:mr-8", "md:mt-4", "md:items-end");
                main.appendChild(payment);
                    div = document.createElement('div');
                    div.classList.add("mb-4");
                    payment.appendChild(div);
                        list = document.createElement('ul');
                        list.classList.add("mb-4");
                        div.appendChild(list);
                            let li = document.createElement('li');
                            li.classList.add("color-five", "russo", "mb-2");
                            list.appendChild(li);
                                span = document.createElement('span');
                                span.innerHTML = "Modalidad Online";
                                li.appendChild(span);

                                let br = document.createElement('br');
                                li.appendChild(br);

                                span = document.createElement('span');
                                span.innerHTML = `AR$ ${ data.prices[0].price }/h`;
                                li.appendChild(span);

                            li = document.createElement('li');
                            li.classList.add("color-white", "russo", "mb-2");
                            list.appendChild(li);
                                span = document.createElement('span');
                                span.innerHTML = "Modalidad Offline";
                                li.appendChild(span);

                                br = document.createElement('br');
                                li.appendChild(br);

                                span = document.createElement('span');
                                span.innerHTML = `AR$ ${ data.prices[1].price }/h`;
                                li.appendChild(span);

                        let div2 = document.createElement('div');
                        div.appendChild(div2);
                            let link = document.createElement('a');
                            link.classList.add("btn", "btn-outline", "btn-one", "mobile-btn");
                            link.href = `/users/${ data.slug }/profile`;
                            div2.appendChild(link);
                                span = document.createElement('span');
                                span.classList.add("russo", "rounded");
                                span.innerHTML = "Ver horarios";
                                link.appendChild(span);
        return item;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}

export default User;