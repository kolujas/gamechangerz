if (validation.hasOwnProperty('mail') && validation.mail.hasOwnProperty("support")) {
    if (!validation.mail.support.hasOwnProperty("ValidationJS")) {
        validation.mail.support.ValidationJS = new window.validation({
            id: "support",
            rules: validation.mail.support.rules,
            messages: validation.mail.support.messages,
        });
    }
} else {
    console.error(`validation.support does not exist`);
}