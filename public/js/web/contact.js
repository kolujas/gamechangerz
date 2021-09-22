import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

if (validation.hasOwnProperty("contact")) {
    if (!validation.contact.hasOwnProperty("ValidationJS")) {
        validation.contact.ValidationJS = new ValidationJS({
            id: "contact",
            rules: validation.contact.rules,
            messages: validation.contact.messages,
        });
    }
} else {
    console.error(`validation.contact does not exist`);
}