if (validation.hasOwnProperty('mail') && validation.mail.hasOwnProperty("contact")) {
    if (!validation.mail.contact.hasOwnProperty("ValidationJS")) {
        validation.mail.contact.ValidationJS = new winodw.validation({
            id: "contact",
            rules: validation.mail.contact.rules,
            messages: validation.mail.contact.messages,
        });
    }
} else {
    console.error(`validation.contact does not exist`);
}