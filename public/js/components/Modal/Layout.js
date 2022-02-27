/**
 * * COntrols the website Modal logic.
 * @export
 * @class Layout
 * @extends {window.class}
 */
export default class Layout extends window.class {
    /**
     * * Creates an instance of Layout.
     * @memberof Layout
     */
    constructor () {
        super();
    }

    /**
     * * set the ModalJS logic.
     * @param {string} type
     * @param {object} config
     * @param {object} functions
     * @memberof Layout
     */
    setLogic (type, config, functions) {
        if (!modals.hasOwnProperty(type)) {
            modals[type] = new window.modal({
                id: type,
            }, config, functions);
        } else {
            console.error(`Modal.${ type } does exists.`);
        }

        // if (!modals.hasOwnProperty('achievements')) {
        //     modals.achievements = new window.modal({
        //         id: 'achievements',
        //     }, {
        //         open: /achievements/.exec(window.url.findHashParameter()),
        //         detectHash: true,
        //         outsideClick: true,
        //     });
        //     const table = this.component('list', {
        //         achievements: achievements
        //     });
        //     document.querySelector('#achievements.modal main').insertBefore(table.html, document.querySelector('#achievements.modal main footer'));
        //     document.querySelector("#achievements.modal header .btn").addEventListener("click", function (e) {
        //         Achievement.add(table, achievements);
        //     });
        // }

        // if (!modals.hasOwnProperty("activity")) {
        //     modals.activity = new window.modal({
        //         id: 'activity',
        //     }, {
        //         outsideClick: true,
        //     }, {
        //         open: { function: Activity.open }
        //     });
        // }
        
        // if (!modals.hasOwnProperty("auth")) {
        //     modals.auth = new window.modal({
        //         id: "auth",
        //     }, {
        //         outsideClick: true
        //     });
        // }
        
        // if (!modals.hasOwnProperty("friends")) {
        //     modals.friends = new window.modal({
        //         id: 'friends',
        //     }, {
        //         open: window.url.findHashParameter() === 'friends',
        //         detectHash: true,
        //         outsideClick: true,
        //     });
        // }
        
        // if (!modals.hasOwnProperty("games")) {
        //     modals.games = new window.modal({
        //         id: "games",
        //     }, {
        //         open: window.url.findHashParameter() === "games",
        //         detectHash: true,
        //         outsideClick: true,
        //     });
        // }
        
        // if (!modals.hasOwnProperty("hours")) {
        //     modals.hours = new window.modal({
        //         id: "hours",
        //     },{
        //         detectHash: true,
        //         outsideClick: true
        //     });
        // }
        
        // if (!modals.hasOwnProperty("languages")) {
        //     modals.languages = new window.modal({
        //         id: 'languages',
        //     }, {
        //         open: window.url.findHashParameter() === 'languages',
        //         detectHash: true,
        //         outsideClick: true,
        //     });
        // }
        
        // if (!modals.hasOwnProperty("lessons")) {
        //     modals.lessons = new window.modal({
        //         id: 'lessons',
        //     }, {
        //         open: window.url.findHashParameter() === 'lessons',
        //         detectHash: true,
        //         outsideClick: true,
        //     });
        // }
        
        // if (!modals.hasOwnProperty("poll")) {
        //     modals.poll = new window.modal({
        //         id: "poll",
        //     },{
        //         detectHash: true,
        //         open: true,
        //         outsideClick: true
        //     });
        // }
        
        // if (!modals.hasOwnProperty("deleteMessage")) {
        //     modals.deleteMessage = new window.modal({
        //         id: 'delete-message',
        //     }, {
        //         outsideClick: true,
        //         open: true,
        //     });
        // }
        
        // if (!modals.hasOwnProperty("review")) {
        //     modals.review = new window.modal({
        //         id: 'reviews',
        //     }, {
        //         outsideClick: true,
        //         open: !window.localstorage.has("gamechangerz_later"),
        //         detectHash: true,
        //     });
        // }
    }
}