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
        if (validation.hasOwnProperty("user") && validation.user.hasOwnProperty("advanced")) {
            if (!validation.user.advanced.hasOwnProperty("ValidationJS")) {
                validation.user.advanced.ValidationJS = new window.validation({
                    id: "advanced-form",
                    rules: validation.user.advanced.rules,
                    messages: validation.user.advanced.messages.es,
                });
            }
        } else {
            console.error(`validation.advanced does not exist`);
        }
    }
}