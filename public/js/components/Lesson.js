export class Lesson extends window.class {
    static setModalJS () {
        if (!modals.hasOwnProperty("lessons")) {
            modals.lessons = new window.modal({
                id: 'lessons',
            }, {
                open: window.url.findHashParameter() === 'lessons',
                detectHash: true,
                outsideClick: true,
            });
        }
    }
}

export default Lesson;