import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

if (validation.hasOwnProperty("support")) {
    if (!validation.support.hasOwnProperty("ValidationJS")) {
        validation.support.ValidationJS = new ValidationJS({
            id: "support",
            rules: validation.support.rules,
            messages: validation.support.messages,
        });
    }
} else {
    console.error(`validation.support does not exist`);
}