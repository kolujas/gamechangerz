if (validation.hasOwnProperty("support")) {
    if (!validation.support.hasOwnProperty("ValidationJS")) {
        validation.support.ValidationJS = new window.validation({
            id: "support",
            rules: validation.support.rules,
            messages: validation.support.messages,
        });
    }
} else {
    console.error(`validation.support does not exist`);
}