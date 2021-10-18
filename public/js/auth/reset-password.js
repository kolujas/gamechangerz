import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

if (validation.hasOwnProperty("reset-password")) {
    validation['reset-password'].ValidationJS = new ValidationJS({
        id: "reset-password",
        rules: validation['reset-password'].rules,
        messages: validation['reset-password'].messages,
    });
} else {
    console.error(`validation.reset-password does not exist`);
}