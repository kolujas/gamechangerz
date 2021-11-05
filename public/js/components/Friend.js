export class Friend extends window.class {
    static setModalJS () {
        if (!modals.hasOwnProperty("friends")) {
            modals.friends = new window.modal({
                id: 'friends',
            }, {
                open: window.url.findHashParameter() === 'friends',
                detectHash: true,
                outsideClick: true,
            });
        }
    }
}

export default Friend;