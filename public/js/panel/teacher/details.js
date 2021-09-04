import { Html } from "../../../submodules/HTMLCreatorJS/js/HTMLCreator.js";
import { InputFileMaker } from "../../../submodules/InputFileMakerJS/js/InputFileMaker.js";
import { URLServiceProvider as URL } from "../../../submodules/ProvidersJS/js/URLServiceProvider.js";
import Validation from "../../../submodules/ValidationJS/js/Validation.js";

import Achievement from "../../components/Achievement.js";
import Asset from "../../components/Asset.js";
import Review from "../../components/Review.js";

if (document.querySelector('#achievements.modal')) {
    Achievement.setModalJS(user.achievements);
    for (const btn of document.querySelectorAll('ul.achievements.cards .btn')) {
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

new InputFileMaker({
    accept: ['image/png'],
    button: (user.hasOwnProperty("id_user") ? "Cambiar foto" : 'Subir foto'),
    classes: {
        input: ['teacher-pic', 'editable', 'form-input', 'teacher-form'],
        button: ['teacher-button', 'editable', 'btn', 'btn-outline', 'btn-one', 'my-4', (user.hasOwnProperty("id_user") ? 'hidden' : 'inline')],
        message: ['teacher-msg', 'color-white', 'block', 'russo', 'w-full']
    },
    message: 'Foto de perfíl',
    id: 'teacher-photo',
    name: 'profile'
},{
    disabled: true,
    generate: document.querySelector('.profile-photo'),
    image: new Asset((user.hasOwnProperty("id_user") ? "storage/" + user.files.profile : "img/resources/ProfileSVG.svg")).route,
});

document.querySelector('.profile-photo').appendChild(new Html("span", {
    props: {
        classes: ["error", "support", "teacher-form", "support-box", "hidden", "support-profile", "mt-1", "overpass", "color-white"]
    }
}).html);

new InputFileMaker({
    accept: ['image/png'],
    button: (user.hasOwnProperty("id_user") ? "Cambiar logo" : 'Subir logo'),
    classes: {
        input: ['teacher-banner', 'editable', 'form-input', 'teacher-form'],
        button: ['teacher-button', 'editable', 'btn', 'btn-outline', 'btn-one', 'my-4', (user.hasOwnProperty("id_user") ? 'mx-10' : 'mx-5'), (user.hasOwnProperty("id_user") ? 'hidden' : 'inline')],
        message: ['teacher-msg', 'color-white', 'block', 'russo', 'w-full']
    },
    message: 'Logo del teampro',
    id: 'teacher-teampro',
    name: 'teampro_logo'
},{
    disabled: true,
    generate: document.querySelector('.teampro-photo'),
    image: (user.hasOwnProperty("id_user") && user.files.teampro) ? new Asset('storage/' + user.files.teampro).route : "",
});

document.querySelector('.teampro-photo').appendChild(new Html("span", {
    props: {
        classes: ["error", "support", "teacher-form", "support-box", "hidden", "support-teampro_logo", "mt-1", "overpass", "color-white"]
    }
}).html);

function submit (params) {
    switch (params.type) {
        case "create":
            validation.teacher.create.ValidationJS.html.action = `/panel/teachers/create`;
            document.querySelector("form#teacher-form input[name=_method]").value = "POST";
            break;
        case "delete":
            validation.teacher.create.ValidationJS.html.action = `/panel/teachers/${ user.slug }/delete`;
            document.querySelector("form#teacher-form input[name=_method]").value = "DELETE";
            break;
        case "update":
            validation.teacher.create.ValidationJS.html.action = `/panel/teachers/${ user.slug }/update`;
            document.querySelector("form#teacher-form input[name=_method]").value = "PUT";
            break;
    }
    validation.teacher.create.ValidationJS.html.submit();
}

if (validation.hasOwnProperty("teacher")) {
    validation.teacher.create.ValidationJS = new Validation({
        id: "teacher-form",
        rules: validation.teacher.create.rules,
        messages: validation.teacher.create.messages,
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
    validation.teacher.update.ValidationJS = new Validation({
        id: "teacher-form",
        rules: validation.teacher.update.rules,
        messages: validation.teacher.update.messages,
    }, {
        submit: false,
        active: false,
    }, {
        valid: {
            function: submit,
            params: {
                type: "update",
            },
        }
    });
    validation.teacher.delete.ValidationJS = new Validation({
        id: "teacher-form",
        rules: validation.teacher.delete.rules,
        messages: validation.teacher.delete.messages,
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

document.querySelector('.editBtn').addEventListener('click', function(){
    validation.teacher.create.ValidationJS.setState("active", false);
    validation.teacher.update.ValidationJS.setState("active", true);
});   

document.querySelector('.cancelBtn').addEventListener('click', function(){
    validation.teacher.update.ValidationJS.setState("active", false);
    validation.teacher.delete.ValidationJS.setState("active", false);
});

document.querySelector('.deleteBtn').addEventListener('click', function(){
    validation.teacher.create.ValidationJS.setState("active", false);
    validation.teacher.delete.ValidationJS.setState("active", true);
});

document.addEventListener("DOMContentLoaded", function () {
    if (/update/.exec(URL.findHashParameter())) {
        validation.teacher.create.ValidationJS.setState("active", false);
        validation.teacher.update.ValidationJS.setState("active", true);
    }
    
    if (/delete/.exec(URL.findHashParameter())) {
        validation.teacher.create.ValidationJS.setState("active", false);
        validation.teacher.delete.ValidationJS.setState("active", true);
    }
});