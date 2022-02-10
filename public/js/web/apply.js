if (validation.hasOwnProperty('user') && validation.user.hasOwnProperty("apply")) {
    if (!validation.user.apply.hasOwnProperty("ValidationJS")) {
        validation.user.apply.ValidationJS = new window.validation({
            id: "apply",
            rules: validation.user.apply.rules,
            messages: validation.user.apply.messages.es,
        });
    }
} else {
    console.error(`validation.apply does not exist`);
}