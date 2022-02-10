export class Language extends window.class {
    static setModalJS () {
        if (!modals.hasOwnProperty("languages")) {
            modals.languages = new window.modal({
                id: 'languages',
            }, {
                open: window.url.findHashParameter() === 'languages',
                detectHash: true,
                outsideClick: true,
            });
        }
    }

    static setValidationJS () {
        if (validation.hasOwnProperty("language") && validation.language.hasOwnProperty('user')) {
            validation.language.user.ValidationJS = new window.validation({
                id: 'languages-form',
                rules: validation.language.user.rules,
                messages: validation.language.user.messages.es,
            });
        } else {
            console.error(`validation.languages does not exist`);
        }
    }
}

export default Language;