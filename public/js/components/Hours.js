export class Hours extends window.class{

    static setModalJS () {
        if (!modals.hasOwnProperty("hours")) {
            modals.hours = new window.modal({
                id: "hours",
            },{
                detectHash: true,
                outsideClick: true
            });
        }
    }
}

export default Hours;

