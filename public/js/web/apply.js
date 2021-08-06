import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

if (validation.hasOwnProperty("apply")) {
    if (!validation.apply.hasOwnProperty("ValidationJS")) {
        validation.apply.ValidationJS = new ValidationJS({
            id: "apply",
            rules: validation.apply.rules,
            messages: validation.apply.messages,
        });
    }
} else {
    console.error(`validation.apply does not exist`);
}