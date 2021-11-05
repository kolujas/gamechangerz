function submit (params) {
    switch (params.type) {
        case "create":
            if (/update/.exec(window.url.findHashParameter())) {
                validation.lesson.create["1on1"].ValidationJS.html.action = `/panel/bookings/${ lesson.id_lesson }/update`;
                document.querySelector("form#lesson-form input[name=_method]").value = "PUT";
                break;
            }
            validation.lesson.create["1on1"].ValidationJS.html.action = `/panel/bookings/create`;
            document.querySelector("form#lesson-form input[name=_method]").value = "POST";
            break;
        case "delete":
            validation.lesson.create["1on1"].ValidationJS.html.action = `/panel/bookings/${ lesson.id_lesson }/delete`;
            document.querySelector("form#lesson-form input[name=_method]").value = "DELETE";
            break;
    }
    validation.lesson.create["1on1"].ValidationJS.html.submit();
}

if (validation.hasOwnProperty("lesson")) {
    validation.lesson.create["1on1"].ValidationJS = new window.validation({
        id: "lesson-form",
        rules: validation.lesson.create["1on1"].rules,
        messages: validation.lesson.create["1on1"].messages,
    }, {
        submit: false,
        active: false,
    }, {
        valid: {
            function: submit,
            params: {
                type: "create",
            },
        }
    });
    validation.lesson.create["seguimiento-online"].ValidationJS = new window.validation({
        id: "lesson-form",
        rules: validation.lesson.create["seguimiento-online"].rules,
        messages: validation.lesson.create["seguimiento-online"].messages,
    }, {
        submit: false,
        active: true,
    }, {
        valid: {
            function: submit,
            params: {
                type: "create",
            },
        }
    });
    validation.lesson.create.packs.ValidationJS = new window.validation({
        id: "lesson-form",
        rules: validation.lesson.create.packs.rules,
        messages: validation.lesson.create.packs.messages,
    }, {
        submit: false,
        active: false,
    }, {
        valid: {
            function: submit,
            params: {
                type: "create",
            },
        }
    });
    validation.lesson.delete.ValidationJS = new window.validation({
        id: "lesson-form",
        rules: validation.lesson.delete.rules,
        messages: validation.lesson.delete.messages,
    }, {
        submit: false,
        active: false,
    }, {
        valid: {
            function: submit,
            params: {
                type: "delete",
            },
        }
    });
}

if (document.querySelector(".editBtn")) {
    document.querySelector(".editBtn").addEventListener("click", function(){
        validation.lesson.create["1on1"].ValidationJS.setState("active", true);
        validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
        validation.lesson.create.packs.ValidationJS.setState("active", false);
        validation.lesson.delete.ValidationJS.setState("active", false);
    });   
}

if (document.querySelector(".cancelBtn")) {
    document.querySelector(".cancelBtn").addEventListener("click", function(){
        validation.lesson.create["1on1"].ValidationJS.setState("active", true);
        validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
        validation.lesson.create.packs.ValidationJS.setState("active", false);
        validation.lesson.delete.ValidationJS.setState("active", false);
    });
}

if (document.querySelector(".deleteBtn")) {
    document.querySelector(".deleteBtn").addEventListener("click", function(){
        validation.lesson.create["1on1"].ValidationJS.setState("active", false);
        validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
        validation.lesson.create.packs.ValidationJS.setState("active", false);
        validation.lesson.delete.ValidationJS.setState("active", true);
    });
}

function createDates (option) {
    document.querySelector("#lesson .dates").innerHTML = "";
    for (let index = 0; index < (option === 3 ? 4 : ((option === 1 || option === 2) ? 1 : 0)); index++) {
        let day;
        if (lesson.hasOwnProperty("id_lesson")) {
            for (let key = 0; key < lesson.days.length; key++) {
                day = lesson.days[key];
                if (key === index) {
                    break;
                }
                day = false;
            }
        }

        let date = new window.html("label", {
            props: {
                classes: ["color-white", "col-start-1"]
            }, innerHTML: [
                ["span", {
                    props: {
                        classes: ["russo"],
                    }, innerHTML: (option === 1 ? "Fecha" : `Fecha ${ index + 1 }`),
                }], ["input", {
                    props: {
                        type: "date",
                        name: `dates[${ index + 1 }]`,
                        placeholder: "Fecha de la clase",
                        defaultValue: (lesson.hasOwnProperty("id_lesson") && day) ? day.date : "",
                        classes: ["px-5", "py-4", "placeholder-blueGray-300", "rounded", "shadow", "outline-none", "focus:outline-none", "w-full", "form-input", "editable", "lesson-form", "mt-8"],
                    },
                }],
            ],
        });
        document.querySelector("#lesson .dates").appendChild(date.html);

        if (option == 2) {
            document.querySelector(".assignments").classList.remove("hidden");
        }

        if (option != 2 && (option == 1 || option == 3)) {
            document.querySelector(".assignments").classList.add("hidden");
            let hour = new window.html("label", {
                props: {
                    classes: ["color-white"],
                }, innerHTML: [
                    ["span", {
                        props: {
                            classes: ["russo"],
                        }, innerHTML: (option === 1 ? "Horario" : `Horario ${ index + 1 }`)
                    }], ["select", {
                        props: {
                            name: `hours[${ index + 1 }]`,
                            classes: ["px-5", "py-4", "placeholder-blueGray-300", "rounded", "shadow", "outline-none", "focus:outline-none", "w-full", "form-input", "lesson-form", "editable", "mt-8"],
                        }, state: {
                            selectedIndex: (lesson.hasOwnProperty("id_lesson") && day) ? day.hours[0].id_hour - 1 : "",
                        }, options: (() => { let options = []; for (const hour of hours) {
                            options.push({
                                props: {
                                    classes: ["overpass"],
                                    defaultValue: hour.id_hour,
                                }, innerHTML: `${ hour.from } - ${ hour.to }`,
                            });
                        } return options; })(),
                    }],
                ],
            });
            document.querySelector("#lesson .dates").appendChild(hour.html);
        }
    }
}

document.querySelector("#lesson select[name=id_type]").addEventListener("click", function (e) {
    if (!this.disabled) {
        createDates(parseInt(this.options[this.selectedIndex].value));
        switch (parseInt(this.options[this.selectedIndex].value)) {
            case 1:
                validation.lesson.create["1on1"].ValidationJS.setState("active", true);
                validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
                validation.lesson.create.packs.ValidationJS.setState("active", false);
                validation.lesson.delete.ValidationJS.setState("active", false);
                break;
            case 2:
                validation.lesson.create["1on1"].ValidationJS.setState("active", false);
                validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", true);
                validation.lesson.create.packs.ValidationJS.setState("active", false);
                validation.lesson.delete.ValidationJS.setState("active", false);
                break;
            case 3:
                validation.lesson.create["1on1"].ValidationJS.setState("active", false);
                validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
                validation.lesson.create.packs.ValidationJS.setState("active", true);
                validation.lesson.delete.ValidationJS.setState("active", false);
                break;
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    if (/update/.exec(window.url.findHashParameter())) {
        switch (lesson.id_type) {
            case 1:
                validation.lesson.create["1on1"].ValidationJS.setState("active", true);
                validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
                validation.lesson.create.packs.ValidationJS.setState("active", false);
                validation.lesson.delete.ValidationJS.setState("active", false);
                break;
            case 2:
                validation.lesson.create["1on1"].ValidationJS.setState("active", false);
                validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", true);
                validation.lesson.create.packs.ValidationJS.setState("active", false);
                validation.lesson.delete.ValidationJS.setState("active", false);
                break;
            case 3:
                validation.lesson.create["1on1"].ValidationJS.setState("active", false);
                validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
                validation.lesson.create.packs.ValidationJS.setState("active", true);
                validation.lesson.delete.ValidationJS.setState("active", false);
                break;
        }
    }
    
    if (/delete/.exec(window.url.findHashParameter())) {
        validation.lesson.create["1on1"].ValidationJS.setState("active", false);
        validation.lesson.create["seguimiento-online"].ValidationJS.setState("active", false);
        validation.lesson.create.packs.ValidationJS.setState("active", false);
        validation.lesson.delete.ValidationJS.setState("active", true);
    }
});