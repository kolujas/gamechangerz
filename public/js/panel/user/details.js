import Achievement from "../../components/Achievement.js";
import Asset from "../../components/Asset.js";
import Review from "../../components/Review.js";

if (document.querySelector("#achievements.modal")) {
    Achievement.setModalJS(user.achievements);
    for (const btn of document.querySelectorAll("ul.achievements.cards .btn")) {
        btn.addEventListener("click", function (e) {
            modals.achievements.open();
        });
    }
}

if (document.querySelector("#reviews.modal")) {
    auth.id_user = user.id_user;
    
    new Review({ lessons: lessons });

    for (const item of document.querySelectorAll(".reviews.cards .card")) {
        item.addEventListener("click", function (e) {
            console.log(modals.reviews);
        });
    }
}

new window.inputfile({
    accept: ["image/png", "image/jpeg"],
    button: (user.hasOwnProperty("id_user") ? "Cambiar foto" : "Subir foto"),
    classes: {
        input: ["user-pic", "editable", "form-input", "user-form"],
        button: ["user-button", "editable", "btn", "btn-outline", "btn-one", "my-4", "mx-6", (user.hasOwnProperty("id_user") ? "hidden" : "inline")],
        message: ["user-msg", "color-white", "block", "russo", "w-full"]
    },
    message: "Foto de perfíl",
    id: "profile-photo",
    name: "profile"
},{
    disabled: true,
    generate: document.querySelector(".profile-photo"),
    image: new Asset((user.hasOwnProperty("id_user") && user.files.hasOwnProperty("profile")) ? "storage/" + user.files.profile : "img/resources/ProfileSVG.svg").route,
});

document.querySelector(".profile-photo").appendChild(new window.html("span", {
    props: {
        classes: ["error", "support", "user-form", "support-box", "hidden", "support-profile", "mt-1", "overpass", "color-white"]
    }
}).html);

new window.inputfile({
    accept: ["image/png", "image/jpeg"],
    button: (user.hasOwnProperty("id_user") ? "Cambiar banner" : "Subir banner"),
    classes: {
        input: ["user-banner", "editable", "form-input", "user-form"],
        button: ["user-button", "editable", "btn", "btn-outline", "btn-one", "my-4", (user.hasOwnProperty("id_user") ? "mx-10" : "mx-5"), (user.hasOwnProperty("id_user") ? "hidden" : "inline")],
        message: ["user-msg", "color-white", "block", "russo", "w-full"]
    },
    message: "Foto de banner",
    id: "banner-photo",
    name: "banner"
},{
    disabled: true,
    generate: document.querySelector(".banner-photo"),
    image: new Asset((user.hasOwnProperty("id_user") && user.files.hasOwnProperty("banner")) ? "storage/" + user.files.banner : "storage/web/slider/02-banner.png").route
});

document.querySelector(".banner-photo").appendChild(new window.html("span", {
    props: {
        classes: ["error", "support", "user-form", "support-box", "hidden", "support-teampro_logo", "mt-1", "overpass", "color-white"]
    }
}).html);

function submit (params) {
    console.log(params.type);
    switch (params.type) {
        case "create":
            validation.user.create.ValidationJS.html.action = `/panel/users/create`;
            document.querySelector("form#user-form input[name=_method]").value = "POST";
            break;
        case "delete":
            validation.user.create.ValidationJS.html.action = `/panel/users/${ user.slug }/delete`;
            document.querySelector("form#user-form input[name=_method]").value = "DELETE";
            break;
        case "update":
            validation.user.create.ValidationJS.html.action = `/panel/users/${ user.slug }/update`;
            document.querySelector("form#user-form input[name=_method]").value = "PUT";
            break;
    }
    validation.user.create.ValidationJS.html.submit();
}

if (validation.hasOwnProperty("user")) {
    validation.user.create.ValidationJS = new window.validation({
        id: "user-form",
        rules: validation.user.create.rules,
        messages: validation.user.create.messages,
    }, {
        submit: false,
        active: true,
    }, {
        valid: {
            function: submit,
            params: {
                type: "create",
            },
        }, invalid: {
            function: (params) => { console.log(params) },
            params: {
                type: "create",
            },
        }
    });
    validation.user.update.ValidationJS = new window.validation({
        id: "user-form",
        rules: validation.user.update.rules,
        messages: validation.user.update.messages,
    }, {
        submit: false,
        active: false,
    }, {
        valid: {
            function: submit,
            params: {
                type: "update",
            },
        }, invalid: {
            function: (params) => { console.log(params) },
            params: {
                type: "update",
            },
        }
    });
    validation.user.delete.ValidationJS = new window.validation({
        id: "user-form",
        rules: validation.user.delete.rules,
        messages: validation.user.delete.messages,
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

document.querySelector(".editBtn").addEventListener("click", function(){
    validation.user.create.ValidationJS.setState("active", false);
    validation.user.update.ValidationJS.setState("active", true);
});   

document.querySelector(".cancelBtn").addEventListener("click", function(){
    validation.user.update.ValidationJS.setState("active", false);
    validation.user.delete.ValidationJS.setState("active", false);
});

document.querySelector(".deleteBtn").addEventListener("click", function(){
    validation.user.create.ValidationJS.setState("active", false);
    validation.user.delete.ValidationJS.setState("active", true);
});

document.addEventListener("DOMContentLoaded", function () {
    if (/update/.exec(window.url.findHashParameter())) {
        validation.user.create.ValidationJS.setState("active", false);
        validation.user.update.ValidationJS.setState("active", true);
    }
    
    if (/delete/.exec(window.url.findHashParameter())) {
        validation.user.create.ValidationJS.setState("active", false);
        validation.user.delete.ValidationJS.setState("active", true);
    }
});