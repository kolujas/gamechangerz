import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";

import Token from "./Token.js";

export default class Activity extends window.class {
    constructor (props) {
        super(props);

        this.setActivities();
    }

    async setActivities () {
        document.querySelector("#activity.modal .modal-content ul").innerHTML = "";
        this.setProps("assignments", await Activity.getActivities(this.props.id_lesson));
        if (this.props.assignments && this.props.assignments.length) {
            for (const assignment of this.props.assignments) {
                document.querySelector("#activity.modal .modal-content ul").appendChild(Activity.component("assignment", assignment));
            }
        }
        if (!this.props.assignments || !this.props.assignments.length) {
            let item = new window.html("li", {
                props: {
                    classes: ["text-center", "russo", "color-grey"],
                }, innerHTML: "No realizaron actividades"
            });
            document.querySelector("#activity.modal .modal-content ul").appendChild(item.html);
        }
    }

    static setModalJS () {
        if (!modals.hasOwnProperty("activity")) {
            modals.activity = new window.modal({
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

        let query = await Fetch.get(`/api/lessons/${ id_lesson }/assignments`, {
            'Accept': 'application/json',
            'Content-type': 'application/json; charset=UTF-8',
            'Authorization': "Bearer " + token.data,
        });

        if (query.response.code === 200) {
            return query.response.data.assignments;
        }
    }
    
    static open (params) {
        new Activity({
            id_lesson: params.id_lesson,
        });
    }

    static assignment (data) {
        let assignment = new window.html("li", {
            props: {
                classes: ["grid", "gap-8"],
            }, innerHTML: [
                ["section", {
                    props: {
                        classes: ["assignment"],
                    }, innerHTML: [
                        ["main", {
                            props: {
                                classes: ["flex", "justify-center", "flex-wrap"],
                            }, innerHTML: [
                                ["p", {
                                    props: {
                                        classes: ["color-white", "overpass", "mb-8", "w-full"],
                                    }, innerHTML: data.description,
                                }], (() => { if (data.url) { return ["a", {
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
                                }]; } return []; } )(), (() => { if (data.hasOwnProperty("presentation")) { return ["span", {
                                    props: {
                                        classes: ["color-white", "block", "w-full", "text-center"],
                                    }, innerHTML: [
                                        ["icon", {
                                            props: {
                                                classes: ["fas", "fa-chevron-down"],
                                            },
                                        }],
                                    ],
                                }]; } return []; })(),
                            ],
                        }],
                    ],
                }], (() => { if (data.hasOwnProperty("presentation")) { return ["section", {
                    props: {
                        classes: ["presentation", "p-2", "bg-one", "rounded"],
                    }, innerHTML: [
                        ["main", {
                            props: {
                                classes: ["flex", "justify-center", "flex-wrap"],
                            }, innerHTML: [
                                ["p", {
                                    props: {
                                        classes: ["color-four", "overpass", "mb-8", "w-full"],
                                    }, innerHTML: data.presentation.description,
                                }], (() => { if (data.presentation.url) { return ["a", {
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
                                }]; } return []; })(),
                            ],
                        }],
                    ],
                }]; } return []; } )(),
            ],
        });
        return assignment.html;
    }

    static component (name = '', data) {
        return this[name](data);
    }
}