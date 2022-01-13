import Achievement from "../components/Achievement.js";
import Asset from "../components/Asset.js";
import Friend from "../components/Friend.js";
import Game from "../components/Game.js";
import Language from "../components/Language.js";
import Lesson from "../components/Lesson.js";
import Review from "../components/Review.js";
import User from "../components/User.js";
import Advanced from "../components/Advanced.js";
import Hours from "../components/Hours.js";

function setDefaultWidth (params) {
    let prices_input = document.querySelectorAll(".coach .tab-menu input[type=number]");
    let prices_text = document.querySelectorAll(".coach .tab-menu input[type=number] + span");
    prices_text[0].innerHTML = prices_input[0].value;
    prices_text[1].innerHTML = prices_input[1].value;
    prices_text[2].innerHTML = prices_input[2].value;
    prices_input[0].setAttribute("style", `--width: ${ prices_text[0].offsetWidth }px`);
    prices_input[1].setAttribute("style", `--width: ${ prices_text[1].offsetWidth }px`);
    prices_input[2].setAttribute("style", `--width: ${ prices_text[2].offsetWidth }px`);
    for (const key in prices_input) {
        if (Object.hasOwnProperty.call(prices_input, key)) {
            const input = prices_input[key];
            input.addEventListener("keyup", function (e) {
                e.preventDefault();
                prices_text[key].innerHTML = this.value;
                this.setAttribute("style", `--width: ${ prices_text[key].offsetWidth }px`);
            });
        }
    }
}

function createErrorNotification (params) {
    for (const target in params.errors) {
        if (Object.hasOwnProperty.call(params.errors, target)) {
            const errors = params.errors[target];
            for (const error of errors) {
                let index = document.querySelectorAll(".notification").length;
                console.log(error);
                let notification = new window.notification({
                    id: `notification-${ target }`,
                    code: 404,
                    message: error,
                    classes: ["russo"],
                }, {
                    open: true,
                    insertBefore: document.querySelector("#notification-1"),
                });
                notification.setProps("index", index);
                notification.html.setAttribute("style", `--index: ${ index }`);
            }
        }
    }
}

function changeProfileState (state) {
    switch (state) {
        case "update":
            for (const input of document.querySelectorAll(".update-input")) {
                if (["teampro_name", "teampro_logo"].includes(input.name)) {
                    input.parentNode.classList.remove("hidden");
                    input.parentNode.parentNode.classList.remove("hidden");
                }
                if ("teampro_name" === input.name) {
                    input.parentNode.previousElementSibling.classList.remove("hidden");
                }
                if (input.disabled) {
                    input.disabled = false;
                    if (input.classList.contains("hidden") && input.name === "name") {
                        input.classList.remove("hidden");
                    }
                } else {
                    input.disabled = true;
                    if (!input.classList.contains("hidden") && input.name === "name") {
                        input.classList.add("hidden");
                    }
                }
            }
            for (const btn of document.querySelectorAll(".update-button")) {
                if (btn.classList.contains("confirm")) {
                    btn.classList.remove("hidden");
                }
                if (btn.classList.contains("cancel")) {
                    btn.classList.remove("hidden");
                }
                if (!btn.classList.contains("confirm") && !btn.classList.contains("cancel")) {
                    btn.classList.add("hidden");
                }
            }
            break;
    }
}

if (lessons.length && document.querySelector("#reviews.modal")) {
    new Review({ lessons: lessons });
}

document.addEventListener("DOMContentLoaded", function (e) {
    if(document.querySelector('#advanced.modal')){
        Advanced.setModalJS();
    }
    if (document.querySelector("#horarios.tab-menu")) {
        new window.tabmenu({
            id: "horarios"
        },{
            open: "online",
        }, {
            function: setDefaultWidth,
        });
    }
    
    if (document.querySelector("form.user")) {
        for (const btn of document.querySelectorAll(".user .reviews header a:last-child")) {
            btn.addEventListener("click", function(e){
                e.preventDefault();
                this.parentNode.parentNode.nextElementSibling.classList.remove("hidden")
            });         
        }

        for (const megaBtn of document.querySelectorAll(".mega-cardota")) {
            megaBtn.addEventListener("mouseleave", function(e){
                e.preventDefault();
                this.children[1].classList.add("hidden");
            })
        }

        new window.inputfile({
            id: "profile",
            message: "",
            button: "",
            name: "profile",
            accept: ["image/jpeg", "image/png"],
            classes: {
                input: ["form-input", "update-input"],
                message: ["hidden"],
                button: ["update-input"],
            },
        }, {
            generate: document.querySelector("form.user .profile-image"),
            image: new Asset(((files.hasOwnProperty("profile")) ? `storage/${ files.profile }` : "img/resources/ProfileSVG.svg")).route,
            disabled: true,
        });
        
        new window.inputfile({
            id: "banner",
            message: "",
            button: "",
            name: "banner",
            accept: ["image/jpeg", "image/png"],
            classes: {
                input: ["form-input", "update-input"],
                message: ["russo"],
                button: ["update-input"],
            },
        }, {
            generate: document.querySelector(".user .banner figure"),
            image: new Asset(((files.hasOwnProperty("banner")) ? `storage/${ files.banner }` : "storage/web/slider/02-banner.png")).route,
            disabled: true,
        });
    }

    if (document.querySelector("form.coach")) {
        let username_input = document.querySelector(".coach .profile .info .username input");
        let username_text = document.querySelector(".coach .profile .info .username span");
        username_text.innerHTML = username_input.value;
        username_input.setAttribute("style", `--width: ${ username_text.offsetWidth }px`);
        username_input.addEventListener("keyup", function (e) {
            e.preventDefault();
            username_text.innerHTML = this.value;
            this.setAttribute("style", `--width: ${ username_text.offsetWidth }px`);
        });
        if (document.querySelector(".coach .profile .info .name input")) {
            let name_input = document.querySelector(".coach .profile .info .name input");
            let name_text = document.querySelector(".coach .profile .info .name span");
            name_text.innerHTML = name_input.value;
            name_input.setAttribute("style", `--width: ${ name_text.offsetWidth }px`);
            name_input.addEventListener("keyup", function (e) {
                e.preventDefault();
                name_text.innerHTML = this.value;
                this.setAttribute("style", `--width: ${ name_text.offsetWidth }px`);
            });
        }
        if (document.querySelector(".coach .profile .info .teampro div input")) {
            let teampro_name_input = document.querySelector(".coach .profile .info .teampro div input");
            let teampro_name_text = document.querySelector(".coach .profile .info .teampro div span");
            teampro_name_text.innerHTML = teampro_name_input.value;
            teampro_name_input.setAttribute("style", `--width: ${ teampro_name_text.offsetWidth }px`);
            teampro_name_input.addEventListener("keyup", function (e) {
                e.preventDefault();
                teampro_name_text.innerHTML = this.value;
                this.setAttribute("style", `--width: ${ teampro_name_text.offsetWidth }px`);
            });
        }
        if (document.querySelectorAll(".coach .tab-menu input[type=number]").length === 3) {
            let prices_input = document.querySelectorAll(".coach .tab-menu input[type=number]");
            let prices_text = document.querySelectorAll(".coach .tab-menu input[type=number] + span");
            prices_text[0].innerHTML = prices_input[0].value;
            prices_text[1].innerHTML = prices_input[1].value;
            prices_text[2].innerHTML = prices_input[2].value;
            prices_input[0].setAttribute("style", `--width: ${ prices_text[0].offsetWidth }px`);
            prices_input[1].setAttribute("style", `--width: ${ prices_text[1].offsetWidth }px`);
            prices_input[2].setAttribute("style", `--width: ${ prices_text[2].offsetWidth }px`);
            for (const key in prices_input) {
                if (Object.hasOwnProperty.call(prices_input, key)) {
                    const input = prices_input[key];
                    input.addEventListener("keyup", function (e) {
                        e.preventDefault();
                        prices_text[key].innerHTML = this.value;
                        this.setAttribute("style", `--width: ${ prices_text[key].offsetWidth }px`);
                    });
                }
            }
        }
        
        new window.inputfile({
            id: "profile",
            message: "",
            button: "",
            name: "profile",
            accept: ["image/png"],
            classes: {
                input: ["form-input", "update-input"],
                message: ["russo"],
                image: ["absolute", "profile"],
                button: ["update-input"],
            },
        }, {
            generate: document.querySelector(".coach .banner figure"),
            image: new Asset(`storage/${ files.profile }`).route,
            disabled: true,
        });
        
        new window.inputfile({
            id: "teampro",
            message: "",
            button: "",
            name: "teampro_logo",
            accept: ["image/png"],
            classes: {
                input: ["form-input", "update-input"],
                message: ["hidden"],
                button: ["update-input"],
            },
        }, {
            generate: document.querySelector(".coach .info .teampro figure"),
            image: files.hasOwnProperty("teampro") ? new Asset(`storage/${ files.teampro }`).route : "",
            disabled: true,
        });
    }
    

    if (document.querySelector("#lessons.modal")) {
        Lesson.setModalJS();
    }
    if (document.querySelector("#friends.modal")) {
        Friend.setModalJS();
    }
    if (auth) {
        if (document.querySelector("#achievements.modal")) {
            Achievement.setModalJS(achievements);
            for (const btn of document.querySelectorAll("ul.achievements.cards .btn")) {
                btn.addEventListener("click", function (e) {
                    modals.achievements.open();
                });
            }
        }
        if (document.querySelector("#games.modal")) {
            Game.setModalJS();
        }
        if (document.querySelector("#languages.modal")) {
            Language.setModalJS();
            Language.setValidationJS();
        }

        if (document.querySelector("#hours.modal")) {
            Hours.setModalJS();
            // Hours.setValidationJS();
        }

        if (document.querySelectorAll(".update-button").length) {
            if (!validation["update"].ValdiationJS) {
                User.setValidationJS({
                    function: createErrorNotification,
                    params: {}
                });
            }
            if (window.url.findHashParameter() === "update") {
                changeProfileState("update");
            }
            for (const btn of document.querySelectorAll("a.update-button")) {
                btn.addEventListener("click", function (e) {
                    changeProfileState("update");
                });
            }
            for (const btn of document.querySelectorAll("button.update-button")) {
                btn.addEventListener("click", function (e) {
                    if (btn.classList.contains("cancel")) {
                        window.location.href = window.location.href.split("#")[0];
                    }
                    changeProfileState((btn.classList.contains("confirm") ? "confirm" : "cancel"));
                });
            }
        }
    }
});