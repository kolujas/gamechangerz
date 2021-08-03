import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { Html } from "../../submodules/HTMLCreatorJS/js/HTMLCreator.js";

import Token from "./Token.js";

export default class Activity extends Class {
    constructor (props) {
        super(props);

        this.setActivities();
    }

    async setActivities () {
        document.querySelector("#activity.modal .modal-content ul").innerHTML = "";
        this.setProps("assigments", await Activity.getActivities(this.props.id_lesson));
        if (this.props.assigments && this.props.assigments.length) {
            for (const assigment of this.props.assigments) {
                document.querySelector("#activity.modal .modal-content ul").appendChild(Activity.component("assigment", assigment));
            }
        }
        if (!this.props.assigments || !this.props.assigments.length) {
            let item = new Html("li", {
                props: {
                    classes: ["text-center", "russo", "color-grey"],
                }, innerHTML: "No realizaron actividades"
            });
            document.querySelector("#activity.modal .modal-content ul").appendChild(item.html);
        }
    }

    static setModalJS () {
        if (!modals.hasOwnProperty("activity")) {
            modals.activity = new ModalJS({
                id: 'activity',
            }, {
                outsideClick: true,
            }, {
                open: { function: Activity.open }
            });
        }
    }

    static async  getActivities (id_lesson) {
        const token = Token.get();

        let query = await Fetch.get(`/api/lessons/${ id_lesson }/assigments`, {
            'Accept': 'application/json',
            'Content-type': 'application/json; charset=UTF-8',
            'Authorization': "Bearer " + token.data,
        });

        if (query.response.code === 200) {
            return query.response.data.assigments;
        }
    }
    
    static open (params) {
        new Activity({
            id_lesson: params.id_lesson,
        });
    }

    static assigment (data) {
        let assigment = new Html("li", {
            props: {
                classes: ["grid", "gap-8"],
            }, innerHTML: [
                ["section", {
                    props: {
                        classes: ["assigment"],
                    }, innerHTML: [
                        ["header", {
                            props: {
                                classes: ["mb-8"],
                            }, innerHTML: [
                                ["h4", {
                                    props: {
                                        classes: ["color-four", "russo", "text-center", "mb-0"],
                                    }, innerHTML: data.title,
                                }],
                            ],
                        }], ["main", {
                            props: {
                                classes: ["flex", "justify-center", "flex-wrap"],
                            }, innerHTML: [
                                ["p", {
                                    props: {
                                        classes: ["color-white", "overpass", "mb-8"],
                                    }, innerHTML: data.description,
                                }], ["a", {
                                    props: {
                                        classes: ["btn", "btn-one", "btn-outline"],
                                        url: data.url,
                                        target: "_blank",
                                    }, innerHTML: [
                                        ["span", {
                                            props: {
                                                classes: ["px-4", "py-2"],
                                            }, innerHTML: "Link",
                                        }],
                                    ],
                                }], (() => { if (data.hasOwnProperty("presentation")) { return ["span", {
                                    props: {
                                        classes: ["color-white", "block", "w-full", "text-center"],
                                    }, innerHTML: [
                                        ["icon", {
                                            props: {
                                                classes: ["fas", "fa-chevron-down"],
                                            },
                                        }],
                                    ],
                                }]; } return []; } )(),
                            ],
                        }],
                    ],
                }], (() => { if (data.hasOwnProperty("presentation")) { return ["section", {
                    props: {
                        classes: ["presentation", "p-2", "bg-one", "rounded"],
                    }, innerHTML: [
                        ["header", {
                            props: {
                                classes: ["mb-8"],
                            }, innerHTML: [
                                ["h4", {
                                    props: {
                                        classes: ["color-four", "russo", "text-center", "mb-0"],
                                    }, innerHTML: data.presentation.title,
                                }],
                            ],
                        }], ["main", {
                            props: {
                                classes: ["flex", "justify-center", "flex-wrap"],
                            }, innerHTML: [
                                ["a", {
                                    props: {
                                        classes: ["btn", "btn-one", "btn-outline"],
                                        url: data.presentation.url,
                                        target: "_blank",
                                    }, innerHTML: [
                                        ["span", {
                                            props: {
                                                classes: ["px-4", "py-2"],
                                            }, innerHTML: "Link",
                                        }],
                                    ],
                                }],
                            ],
                        }],
                    ],
                }]; } return []; } )(),
            ],
        });
        //// <li class="grid gap-8">
        ////     <section class="assigment">
        ////         <header class="mb-8">
        ////             <h4 class="color-four russo text-center mb-0">Título</h4>
        ////         </header>
        ////         <main class="flex justify-center flex-wrap">
        ////             <p class="color-white overpass mb-8">Lorem ipsum dolor sit amet consectetur, adipisicing //elit. Sunt nisi aliquid minus? Architecto, exercitationem! Incidunt ipsam nesciunt similique earum //temporibus, ex vel! Cumque eos accusamus nam quis impedit unde veniam?</p>
        ////             <a href="#" class="btn btn-one btn-outline">
        ////                 <span class="px-4 py-2">Link</span>
        ////             </a>
        ////             <span class="color-white block w-full text-center">
        ////                 <i class="fas fa-chevron-down"></i>
        ////             </span>
        ////         </main>
        ////     </section>
        ////     <section class="presentation p-2 bg-one rounded">
        ////         <header class="mb-8">
        ////             <h4 class="color-four russo text-center mb-0">Título</h4>
        ////         </header>
        ////         <main class="flex justify-center flex-wrap">
        ////             <a href="#" class="btn btn-one btn-outline">
        ////                 <span class="px-4 py-2">Link</span>
        ////             </a>
        ////         </main>
        ////     </section>
        //// </li>
        return assigment.html;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}