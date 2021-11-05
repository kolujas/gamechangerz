export class Achievement extends window.class {
    constructor (props = {}, state = {}) {
        super({ ...props, id: `achievement-${ props.id_achievement }` }, state);
        this.setCells();
    }

    setCells () {
        if (!this.cells) {
            this.cells = [];
        }
        this.setTitleCell();
        this.setActionsCell();
        this.setDescriptionCell();
    }

    setActionsCell () {
        if (!this.btns) {
            this.btns = [];
        }
        if (this.props.hasOwnProperty("title")) {
            this.btns.push(new window.html("a", {
                props: {
                    id: `${ this.props.id }-update`,
                    classes: ["btn", "btn-icon", "btn-one"],
                    url: "#",
                }, callback: {
                    function: this.switch,
                    params: {
                        instance: this,
                        state: "disabled",
                    }
                }, innerHTML: new window.html("icon", {
                    props: {
                        classes: ["fas", "fa-pen"],
                    }
                }).html
            }));
            this.btns.push(new window.html("a", {
                props: {
                    id: `${ this.props.id }-delete`,
                    classes: ["btn", "btn-icon", "btn-one"],
                    url: "#",
                }, callback: {
                    function: this.switch,
                    params: {
                        instance: this,
                        state: "confirm",
                    }
                }, innerHTML: new window.html("icon", {
                    props: {
                        classes: ["fas", "fa-trash"],
                    }
                }).html
            }));
        }
        this.btns.push(new window.html("a", {
            props: {
                id: `${ this.props.id }-cancel`,
                classes: (this.props.hasOwnProperty("title") ? ["btn", "btn-icon", "btn-three", "hidden"] : ["btn", "btn-icon", "btn-three"]),
                url: "#",
            }, callback: {
                function: this.switch,
                params: {
                    instance: this,
                    state: (this.props.hasOwnProperty("title") ? "both" : "remove"),
                }
            }, innerHTML: new window.html("icon", {
                props: {
                    classes: ["fas", "fa-times"],
                }
            }).html
        }));
        let actions = new window.html("div", {
            props: {
                id: `${ this.props.id }-actions`,
                classes: ["actions", "relative"]
            }
        });
        for (const btn of this.btns) {
            actions.appendChild(btn.html);
        }
        if (this.props.hasOwnProperty("title")) {
            this.message = new window.html("input", {
                props: {
                    id: `${ this.props.id }-message`,
                    classes: ["hidden", "px-4", "py-2", "message"],
                    type: "text",
                    name: `message[${ this.props.id_achievement }]`,
                    placeholder: "Escribí BORRAR para confirmar"
                }
            });
            actions.appendChild(this.message.html);
        }
        this.cells.push({
            props: {
                classes: ["row-span-2", "grid", "gap-4", "justify-end"],
            }, innerHTML: actions.html
        });
        // <td class="row-span-2 grid gap-4 justify-end">
        //    <div>
        //     <a class="btn btn-icon btn-one" href="#achievements-update">
        //         <i class="fas fa-pen"></i>
        //     </a>
        //     <a class="btn btn-icon btn-one" href="#achievements-delete">
        //         <i class="fas fa-trash"></i>
        //     </a>
        //     <a class="btn btn-icon btn-three hidden" href="#achievements">
        //         <i class="fas fa-times"></i>
        //     </a>
        //    <div>
        // </td>
    }

    setDescriptionCell () {
        if (!this.inputs) {
            this.inputs = [];
        }
        this.inputs.push(new window.html("input", {
            props: {
                id: `${ this.props.id }-description`,
                classes: ["w-full", "min-h-full", "px-4", "py-2"],
                type: "text",
                name: `description[${ this.props.id_achievement }]`,
                placeholder: "Descripción",
                defaultValue: (this.props.hasOwnProperty("description") ? this.props.description : ""),
            }, state: {
                disabled: this.state.disabled,
            }
        }));
        this.cells.push({
            props: {
                type: "normal", // ? <th> type: "header"
                classes: ["col-span-2", "justify-end"]
            }, innerHTML: [...this.inputs].pop().html,
        });
        // <td class="col-span-2">
        //     <input class="w-full min-h-full" type="text" name="description" placeholder="Descripción" disabled>
        // </td>
    }

    setTitleCell () {
        if (!this.inputs) {
            this.inputs = [];
        }
        this.inputs.push(new window.html("input", {
            props: {
                id: `${ this.props.id }-title`,
                classes: ["w-full", "min-h-full", "px-4", "py-2"],
                type: "text",
                name: `title[${ this.props.id_achievement }]`,
                placeholder: "Título",
                defaultValue: (this.props.hasOwnProperty("title") ? this.props.title : ""),
            }, state: {
                disabled: this.state.disabled,
            }
        }));
        this.cells.push({
            props: {
                type: "normal", // ? <th> type: "header"
                classes: ["col-span-2", "justify-end"]
            }, innerHTML: [...this.inputs].pop().html,
        });
        // <td class="col-span-2 justify-end">
        //     <input class="w-full min-h-full" type="text" name="title" placeholder="Titulo" value="titulin" disabled>
        // </td>
    }

    switch (params) {
        switch (params.state) {
            case "both":
                params.instance.unconfirm();
                params.instance.disable();
                break;
            case "confirm":
                if (params.instance.state.confirm) {
                    params.instance.unconfirm();
                } else {
                    params.instance.confirm();
                }
                break;
            case "disabled":
                if (params.instance.state.disabled) {
                    params.instance.enable();
                } else {
                    params.instance.disable();
                }
                break;
            case "remove":
                let tr = document.querySelector(`tr#${ params.instance.props.id }`);
                console.log(params);
                tr.parentNode.removeChild(tr);
                break;
        }
        if (params.state !== "remove") {
            for (const btn of params.instance.btns) {
                btn.html.classList.toggle("hidden");
            }
        }
    }

    disable () {
        this.setState("disabled", true);
        for (const input of this.inputs) {
            input.html.disabled = true;
            input.setState("disabled", true);
            input.html.value = input.props.defaultValue;
        }
    }

    enable () {
        document.querySelector("#achievements.modal footer").classList.remove("hidden");
        this.setState("disabled", false);
        for (const input of this.inputs) {
            input.html.disabled = false;
            input.setState("disabled", false);
        }
    }

    unconfirm () {
        this.setState("confirm", false);
        this.message.html.disabled = true;
        this.message.html.classList.add("hidden");
        this.message.setState("disabled", true);
        this.message.html.value = "";
        for (const input of this.inputs) {
            input.html.classList.remove("opacity");
        }
    }

    confirm () {
        document.querySelector("#achievements.modal footer").classList.remove("hidden");
        this.setState("confirm", true);
        this.message.html.disabled = false;
        this.message.html.classList.remove("hidden");
        this.message.setState("disabled", false);
        for (const input of this.inputs) {
            input.html.classList.add("opacity");
        }
    }

    static component (component, data) {
        return this[component](data);
    }

    static list (data) {
        let structure = [];
        for (const key in data.achievements) {
            if (Object.hasOwnProperty.call(data.achievements, key)) {
                let achievement = data.achievements[key];
                achievement = new this({
                    ...achievement,
                    classes: ["grid", "grid-cols-3", "gap-4"],
                }, {
                    disabled: true,
                    confirm: false,
                    id: true,
                });
                structure.push(achievement);
            }
        }

        return new window.html("table", {
            props: {
                classes: ["tabla", "w-full", "mb-12"],
            }, structure: {
                tbody: {
                    props: {
                        classes: ["grid", "gap-4"],
                    }, structure: structure,
                },
            },
        });
    }

    static setModalJS (achievements) {
        if (!modals.hasOwnProperty('achievements')) {
            modals.achievements = new window.modal({
                id: 'achievements',
            }, {
                open: /achievements/.exec(window.url.findHashParameter()),
                detectHash: true,
                outsideClick: true,
            });
            const table = this.component('list', {
                achievements: achievements
            });
            document.querySelector('#achievements.modal main').insertBefore(table.html, document.querySelector('#achievements.modal main footer'));
            document.querySelector("#achievements.modal header .btn").addEventListener("click", function (e) {
                Achievement.add(table, achievements);
            });
        }
    }

    static add (table, achievements) {
        document.querySelector("#achievements.modal footer").classList.remove("hidden");
        let id_achievement = 1;
        for (const achievement of achievements) {
            if (parseInt(id_achievement) <= parseInt(achievement.id_achievement)) {
                id_achievement = parseInt(achievement.id_achievement) + 1;
            }
        }
        table.setRows({
            tbody: [
                new Achievement({
                    id_achievement: id_achievement,
                    classes: ["grid", "grid-cols-3", "gap-4"],
                }, {
                    disabled: false,
                    id: true,
                })
            ]
        });
        document.querySelector("#achievements.modal main").scrollTo(0, document.querySelector("#achievements.modal main").scrollHeight);
    }
}

export default Achievement;