import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

if (validation.hasOwnProperty("auth") && validation.auth.hasOwnProperty("reset-password")) {
    validation.auth['reset-password'].ValidationJS = new ValidationJS({
        id: "reset-password",
        rules: validation.auth['reset-password'].rules,
        messages: validation.auth['reset-password'].messages.es,
    });
} else {
    console.error(`validation.reset-password does not exist`);
}