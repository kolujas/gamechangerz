import Asset from "./Asset.js";
import Game from "./Game.js";

export class User extends window.class {
    static setValidationJS (params = {}) {
        if (validation.hasOwnProperty('update')) {
            validation.update.ValidationJS = new window.validation({
                id: 'update-form',
                rules: validation.update.rules,
                messages: validation.update.messages,
            }, {}, {
                invalid: {
                    function: params.function,
                    params: params.params,
            }});
        } else {
            console.error(`validation.update does not exist`);
        }
    }

    static user (data) {
        let item = new window.html("li", {
            props: {
                id: data.slug,
                classes: ["lg:col-span-8", "lg:col-start-2", "degradado"]
            }, innerHTML: [
                ["main", {
                    props: {
                        classes: ["p-4", "flex", "justify-between", "items-center", "gap-4"]
                    }, innerHTML: [
                        ["a", {
                            props: {
                                classes: ["flex", "btn", "btn-text", "btn-white"],
                                url: `/users/${ data.slug }/profile`,
                            }, innerHTML: [
                                ["div", {
                                    props: {
                                        classes: ["photo", "flex", "items-center", "mr-4"],
                                    }, innerHTML: [
                                        ["figure", {
                                            props: {
                                                classes: ["profile-image"],
                                            }, innerHTML: [
                                                ["img", {
                                                    props: {
                                                        url: new Asset(`${(data.files['profile'] ?  `storage/${ data.files['profile'] }` : `img/resources/ProfileSVG.svg`)}`).route,
                                                    }
                                                }],
                                            ]
                                        }],
                                    ],
                                }],
                                ["div", {
                                    innerHTML: [
                                        ["h3", {
                                            props: {
                                                classes: ["russo"]
                                            }, innerHTML: data.username,
                                        }],
                                        ["span", {
                                            props: {
                                                classes: ["color-grey", "overpass", "whitespace-nowrap", "block"]
                                            }, innerHTML: data.name
                                        }],
                                    ],
                                }],
                            ],
                        }],
                        ["div", {
                            props: {
                                classes: (data.teammate ? ["h-full", "teammate", "flex", "items-center", "active"] : ["h-full", "teammate", "flex", "items-center"])
                            }, innerHTML: [
                                ["figure", {
                                    innerHTML: [
                                        ["img", {
                                            props: {
                                                url: new Asset(`img/resources/ChoqueSVG.svg`).route,
                                            }
                                        }],
                                    ]
                                }],
                            ]
                        }],
                        ["div", {
                            props: {
                                classes: ["color-white", "overpass"]
                            }, innerHTML: [
                                ["span", {
                                    props: {
                                        classes: ["color-white", "overpass"]
                                    }, innerHTML: "Clases tomadas"
                                }],
                                ["p", {
                                    props: {
                                        classes: ["color-four"]
                                    }, innerHTML: data["lessons-done"]
                                }],
                            ]
                        }],
                        ["div", {
                            props: {
                                classes: ["hidden", "md:block"]
                            }, innerHTML: Game.component('list', data.games)
                        }],
                        ["div", {
                            props: {
                                classes: ["btn-purple"]
                            }, innerHTML: [
                                ["a", {
                                    props: {
                                        classes: ["btn", "btn-one", "btn-outline", "russo", "rouded"],
                                        url: `/users/${ data.slug }/profile`
                                    }, innerHTML: [
                                        ["span", {
                                            props: {
                                                classes: ["px-4", "py-3"]
                                            }, innerHTML: "Contactar"
                                        }],
                                    ]
                                }],
                            ]
                        }],
                    ],
                }]
            ],
        });
        return item.html;
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
                                let span;
                                if (data.teampro.name) {
                                    let team_name = document.createElement('span');
                                    team_name.classList.add("team-name", "px-1", "text-center", "mb-3", "overpass", "rounded");
                                    info.appendChild(team_name);
                                        span = document.createElement('span');
                                        span.classList.add("inner-text");
                                        span.innerHTML = data.teampro.name;
                                        team_name.appendChild(span);
                                }

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
                            
                            let div, figure;
                            if (data.teampro.logo) {
                                let team_icon = document.createElement('div');
                                team_icon.classList.add("team-icon", "ml-4");
                                teampro.appendChild(team_icon);
                                    div = document.createElement('div');
                                    team_icon.appendChild(div);
                                        figure = document.createElement('figure');
                                        div.appendChild(figure);
                                            let logo = document.createElement('img');
                                            logo.src = new Asset(`storage/${ data.teampro.logo }`).route;
                                            logo.alt = `${ data.teampro.name } logo`;
                                            figure.appendChild(logo);
                            }
                        
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
                
                let image = document.createElement('section');
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
                                span.innerHTML = "Modalidad 1on1";
                                li.appendChild(span);

                                let br = document.createElement('br');
                                li.appendChild(br);

                                span = document.createElement('span');
                                span.innerHTML = `AR$ ${ data.prices[0].price }`;
                                li.appendChild(span);

                            li = document.createElement('li');
                            li.classList.add("color-white", "russo", "mb-2");
                            list.appendChild(li);
                                span = document.createElement('span');
                                span.innerHTML = "Modalidad Seguimiento online";
                                li.appendChild(span);

                                br = document.createElement('br');
                                li.appendChild(br);

                                span = document.createElement('span');
                                span.innerHTML = `AR$ ${ data.prices[1].price }`;
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

    static profile (data) {
        let link = new window.html("a", {
            props: {
                id: `link-${ data.props.slug }`,
                url: (data.props.hasOwnProperty("url") ? data.props.url : `/users/${ data.slug }/profile`),
                classes: ["profile-link", "flex", "items-center"]
            }, callback: (data.hasOwnProperty('callback') ? data.callback : {
                function: function (params) { /* console.log(params) */ },
            }),
            innerHTML: [
                ["div", {
                    props: {
                        id: `image-${ data.props.slug }`,
                        classes: ["pr-2"],
                    }, innerHTML: [
                        ["figure", {
                            props: {
                                id: `figure-${ data.props.slug }`,
                                classes: ["profile-image"]
                            }, innerHTML: [
                                ["img", {
                                    props: {
                                        id: `image-${ data.props.slug }`,
                                        url: new Asset(`${(data.props.files['profile'] ?  `storage/${ data.props.files['profile'] }` : `img/resources/ProfileSVG.svg`)}`).route,
                                    }
                                }]
                            ]
                        }]
                    ],
                }],
                ["div", {
                    props: {
                        id: `info-${ data.props.slug }`,
                        classes: ["col-span-2", "grid", "grid-cols-1", "items-center"]
                    }, innerHTML: [
                        ["span", {
                            props: {
                                id: `username-${ data.props.slug }`,
                                classes: ["russo", "color-white"],
                            }, innerHTML: data.props.username
                        }],
                        ["span", {
                            props: {
                                id: `name-${ data.props.slug }`,
                                classes: ["overpass", "color-four"],
                            }, innerHTML: data.props.name
                        }]
                    ],
                }]
            ],
        });
        return link;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}

export default User;