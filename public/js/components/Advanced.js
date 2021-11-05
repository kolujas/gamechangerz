export default class Advanced extends window.class {
    static setModalJS() {
        if (!modals.hasOwnProperty('advanced')) {
            modals.advanced = new window.modal({
                id: 'advanced',
            }, {
                open: /advanced/.exec(window.url.findHashParameter()),
                detectHash: true,
                outsideClick: true,
            });
            this.setValidationJS();
        }
    } 

    static setValidationJS () {
        if (validation.hasOwnProperty("advanced")) {
            if (!validation.advanced.hasOwnProperty("ValidationJS")) {
                validation.advanced.ValidationJS = new window.validation({
                    id: "advanced-form",
                    rules: validation.advanced.rules,
                    messages: validation.advanced.messages,
                });
            }
        } else {
            console.error(`validation.advanced does not exist`);
        }
    }
}