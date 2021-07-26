import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Html } from "../../submodules/HTMLCreatorJS/js/HTMLCreator.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

import User from "./User.js";
import Asset from "./Asset.js";

export class Review extends Class {
    constructor (props, state) {
        super(props, state);
        this.setModalJS();
        this.setValidationJS();
        this.htmls = {
            list: modals.review.html.children[0].children[0],
            details: modals.review.html.children[0].children[1],
        };
        this.setLessons();
        this.setEventListeners();
    }

    setEventListeners () {
        const instance = this;
        document.querySelector("#reviews.modal .details header > a").addEventListener("click", function (e) {
            instance.close();
        });
    }

    setLessons () {
        for (const lesson of this.props.lessons) {
            this.htmls.list.children[0].children[1].appendChild(Review.component("lesson", {
                ...lesson,
                instance: this,
            }));
        }
    }

    setModalJS () {
        if (!modals.hasOwnProperty("review")) {
            modals.review = new ModalJS({
                id: 'reviews',
            }, {
                outsideClick: true,
                open: false,
                detectHash: true,
            });
        }
    }

    close () {
        this.htmls.list.classList.remove("hidden");
        this.htmls.details.classList.add("hidden");
        this.htmls.details.reset();
    }

    open (params) {
        for (const lesson of lessons) {
            if (lesson.id_lesson !== params.id_lesson) {
                continue;
            }
            params.instance.changeDetails(lesson);
        }

        params.instance.htmls.list.classList.add("hidden");
        params.instance.htmls.details.classList.remove("hidden");
    }

    changeDetails (lesson) {        
        this.htmls.details.children[2].children[0].children[1].innerHTML = "";
        let abilities = [];

        if (auth.id_role === 2) {
            const from = lesson.users[((auth.id_user === lesson.users.from.id_user) ? "to" : "from")];

            abilities = lesson.abilities[((auth.id_user === lesson.users.from.id_user) ? "to" : "from")];
            
            this.htmls.details.children[2].children[0].children[1].appendChild(User.component("profile", {
                props: {
                    ...from,
                    url: `/users/${ from.slug }/profile`,
                }
            }).html);
        }
        if (auth.id_role !== 2) {
            const to = lesson.users[((auth.id_user === lesson.users.from.id_user) ? "to" : "from")];

            abilities = lesson.abilities[((auth.id_user === lesson.users.from.id_user) ? "from" : "to")];

            this.htmls.details.children[2].children[0].children[1].appendChild(User.component("profile", {
                props: {
                    ...to,
                    url: `/users/${ to.slug }/profile`,
                }
            }).html);
        }

        this.htmls.details.action = `/lessons/${ lesson.id_lesson }/review/create`;

        this.setAbilities(abilities);

        if (auth.id_role === 2) {
            this.completeForm(lesson);
        }
    }

    setAbilities (abilities) {
        [...this.htmls.details.children[2].children[1].children].pop().innerHTML = "";

        for (let ability of abilities) {
            let stars = [];
            for (let i = 1; i <= 5; i++) {
                stars.push(["label", {
                    props: {
                        id: `ability-${ ability.id_ability }-star-${ i }`,
                    }, innerHTML: [
                        ["input", {
                            props: {
                                id: `ability-${ ability.id_ability }-star-${ i }-input`,
                                name: `stars[${ ability.slug }][]`,
                                type: 'checkbox',
                                defaultValue: i,
                                classes: ["hidden", "form-input"],
                            }, callbacks: {
                                click: {
                                    function: this.changeStars,
                                }
                            }
                        }],
                        ["img", {
                            props: {
                                id: `ability-${ ability.id_ability }-star-${ i }-image-1`,
                                url: new Asset("img/resources/EstrellaSVG.svg").route,
                            },
                        }],
                        ["img", {
                            props: {
                                id: `ability-${ ability.id_ability }-star-${ i }-image-2`,
                                url: new Asset("img/resources/Estrella2SVG.svg").route,
                            },
                        }],
                    ]
                }]);
            }

            ability = new Html("div", {
                props: {
                    id: `ability-${ ability.id_ability }`,
                    classes: ["grid", "grid-cols-2", "gap-4"],
                }, innerHTML: [
                    ["h3", {
                        props: {
                            id: `ability-${ ability.id_ability }-name`,
                            classes: ["color-four", "overpass"],
                        }, innerHTML: ability.name,
                    }],
                    ["div", {
                        props: {
                            id: `ability-${ ability.id_ability }-stars`,
                            classes: ["stars", "grid", "grid-cols-5"]
                        }, innerHTML: stars,
                    }]
                ],
            });

            [...this.htmls.details.children[2].children[1].children].pop().appendChild(ability.html);
        }
    }

    completeForm (lesson) {
        let review = false;
        for (review of lesson.reviews) {
            if (review.id_user_to === auth.id_user) {
                break;
            }
            review = false;
        }

        this.htmls.details.action = `/reviews/${ review.id_review }/${ review.id_user_to }/update`;
        document.querySelector("#reviews.modal form input[name=_method]").value = "PUT";

        if (review) {
            for (const input of document.querySelectorAll("#reviews.modal form .form-input")) {
                if (/stars/.exec(input.name)) {
                    for (const ability of review.abilities) {
                        if (`stars[${ ability.slug }][]` === input.name) {
                            if (parseInt(input.value) <= ability.stars)
                            input.checked = true;
                            continue;
                        }
                    }
                    continue;
                }
                if (input.name === "title") {
                    input.value = review.title;
                    continue;
                }
                input.value = review.description;
            }
        }
    }

    changeStars (params) {
        let stars = parseInt(params.element.html.value);
        
        if (!params.element.html.checked) {
            let bigger = 1;

            for (const label of params.element.html.parentNode.parentNode.children) {
                let input = label.children[0];

                if (input.checked && bigger <= parseInt(input.value)) {
                    bigger = parseInt(input.value) + 1;
                }
            }

            if (stars === bigger) {
                stars = 0;
            }
        }

        for (const label of params.element.html.parentNode.parentNode.children) {
            let input = label.children[0];
            input.checked = false;

            if (stars >= parseInt(input.value)) {
                input.checked = true;
            }
        }
    }

    setValidationJS () {
        if (validation.hasOwnProperty('review')) {
            if (!validation.review.hasOwnProperty('ValidationJS')) {
                validation.review.ValidationJS = new ValidationJS({
                    id: 'review-form',
                    rules: validation.review.rules,
                    messages: validation.review.messages,
                });
            }
        } else {
            console.error(`validation.review does not exist`);
        }
    }

    static component (name, data) {
        return this[name](data);
    }

    static lesson (data) {
        const user = data.users[((auth && auth.id_user === data.users.from.id_user) ? "to" : "from")];

        let link = User.component("profile", {
            props: {
                ...user,
                url: `#reviews-${ user.slug }`,
            }, callback: {
                function: data.instance.open,
                params: {
                    instance: data.instance,
                    id_lesson: data.id_lesson,
                }
            }
        });
        link.appendChild(new Html("div", {
            props: {
                id: `lesson-${ user.slug }-date`,
                classes: ["ml-8"],
            }, innerHTML: [
                ["p", {
                    props: {
                        id: `lesson-${ user.slug }-date-text`,
                        classes: ["overpas", "color-white"],
                    }, innerHTML: `${ new Date(data.created_at).getFullYear() }-${ ((new Date(data.created_at).getMonth() + 1) < 10 ? `0${ new Date(data.created_at).getMonth() + 1 }` : new Date(data.created_at).getMonth() + 1) }-${ ((new Date(data.created_at).getDate() + 1) < 10 ? `0${ new Date(data.created_at).getDate() + 1 }` : new Date(data.created_at).getDate() + 1) }`,
                }],
            ],
        }).html);
        link.appendChild(new Html("button", {
            props: {
                id: `lesson-${ user.slug }-link`,
                classes: ["btn", "btn-one", "btn-outline", "ml-8"],
            }, innerHTML: [
                ["span", {
                    props: {
                        id: `lesson-${ user.slug }-link-text`,
                        classes: ["py-2", "px-4"]
                    }, innerHTML: ((auth && auth.id_role !== 2) ? "Dejar reseña" : "Revisar reseña")
                }],
            ],
        }).html);

        let li = new Html("li", {
            props: {
                id: `lesson-${ user.slug }`,
                classes: ["grid", "gap-8"],
            }, innerHTML: [
                link.html,
            ],
        });
        return li.html;
    }
}

export default Review;