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

new window.inputfile({
    accept: ['image/png'],
    button: (user.hasOwnProperty("id_user") ? "Cambiar foto" : 'Subir foto'),
    classes: {
        input: ['coach-pic', 'editable', 'form-input', 'coach-form'],
        button: ['coach-button', 'editable', 'btn', 'btn-outline', 'btn-one', 'my-4', (user.hasOwnProperty("id_user") ? 'hidden' : 'inline')],
        message: ['coach-msg', 'color-white', 'block', 'russo', 'w-full']
    },
    message: 'Foto de perfíl',
    id: 'coach-photo',
    name: 'profile'
},{
    disabled: true,
    generate: document.querySelector('.profile-photo'),
    image: new Asset((user.hasOwnProperty("id_user") ? "storage/" + user.files.profile : "img/resources/ProfileSVG.svg")).route,
});

document.querySelector('.profile-photo').appendChild(new window.html("span", {
    props: {
        classes: ["error", "support", "coach-form", "support-box", "hidden", "support-profile", "mt-1", "overpass", "color-white"]
    }
}).html);

new window.inputfile({
    accept: ['image/png'],
    button: (user.hasOwnProperty("id_user") ? "Cambiar logo" : 'Subir logo'),
    classes: {
        input: ['coach-banner', 'editable', 'form-input', 'coach-form'],
        button: ['coach-button', 'editable', 'btn', 'btn-outline', 'btn-one', 'my-4', (user.hasOwnProperty("id_user") ? 'mx-10' : 'mx-5'), (user.hasOwnProperty("id_user") ? 'hidden' : 'inline')],
        message: ['coach-msg', 'color-white', 'block', 'russo', 'w-full']
    },
    message: 'Logo del teampro',
    id: 'coach-teampro',
    name: 'teampro_logo'
},{
    disabled: true,
    generate: document.querySelector('.teampro-photo'),
    image: (user.hasOwnProperty("id_user") && user.files.teampro) ? new Asset('storage/' + user.files.teampro).route : "",
});

document.querySelector('.teampro-photo').appendChild(new window.html("span", {
    props: {
        classes: ["error", "support", "coach-form", "support-box", "hidden", "support-teampro_logo", "mt-1", "overpass", "color-white"]
    }
}).html);

function submit (params) {
    switch (params.type) {
        case "create":
            validation.coach.create.ValidationJS.html.action = `/panel/coaches/create`;
            document.querySelector("form#coach-form input[name=_method]").value = "POST";
            break;
        case "delete":
            validation.coach.create.ValidationJS.html.action = `/panel/coaches/${ user.slug }/delete`;
            document.querySelector("form#coach-form input[name=_method]").value = "DELETE";
            break;
        case "update":
            validation.coach.create.ValidationJS.html.action = `/panel/coaches/${ user.slug }/update`;
            document.querySelector("form#coach-form input[name=_method]").value = "PUT";
            break;
    }
    validation.coach.create.ValidationJS.html.submit();
}

if (validation.hasOwnProperty("coach")) {
    validation.coach.create.ValidationJS = new window.validation({
        id: "coach-form",
        rules: validation.coach.create.rules,
        messages: validation.coach.create.messages,
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
    validation.coach.update.ValidationJS = new window.validation({
        id: "coach-form",
        rules: validation.coach.update.rules,
        messages: validation.coach.update.messages,
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
    validation.coach.delete.ValidationJS = new window.validation({
        id: "coach-form",
        rules: validation.coach.delete.rules,
        messages: validation.coach.delete.messages,
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
    validation.coach.create.ValidationJS.setState("active", false);
    validation.coach.update.ValidationJS.setState("active", true);
});   

document.querySelector('.cancelBtn').addEventListener('click', function(){
    validation.coach.update.ValidationJS.setState("active", false);
    validation.coach.delete.ValidationJS.setState("active", false);
});

document.querySelector('.deleteBtn').addEventListener('click', function(){
    validation.coach.create.ValidationJS.setState("active", false);
    validation.coach.delete.ValidationJS.setState("active", true);
});

document.addEventListener("DOMContentLoaded", function () {
    if (/update/.exec(window.url.findHashParameter())) {
        validation.coach.create.ValidationJS.setState("active", false);
        validation.coach.update.ValidationJS.setState("active", true);
    }
    
    if (/delete/.exec(window.url.findHashParameter())) {
        validation.coach.create.ValidationJS.setState("active", false);
        validation.coach.delete.ValidationJS.setState("active", true);
    }
});