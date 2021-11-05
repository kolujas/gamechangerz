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
        if (validation.hasOwnProperty('languages')) {
            validation.languages.ValidationJS = new window.validation({
                id: 'languages-form',
                rules: validation.languages.rules,
                messages: validation.languages.messages,
            });
        } else {
            console.error(`validation.languages does not exist`);
        }
    }
}

export default Language;