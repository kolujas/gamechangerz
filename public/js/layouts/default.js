import Auth from "../components/Auth.js";
import Assignment from "../components/Modal/Assignment.js";
import Chat from "../components/Modal/Chat.js";
import Presentation from "../components/Modal/Presentation.js";
import User from "../components/Models/User.js";

/**
 * * Starts the Chat Modal Logic.
 */
async function StartChatLogic () {
    const user = await User.auth();

    if (user) {
        new Chat(user);
        
        new Assignment(user);
        
        new Presentation(user);
    }
}

new window.navmenu({
    id: "nav-id",
    sidebar: {
        id: ["menu"],
        position: ["left"],
}});

if (!auth.hasOwnProperty('id_user')) {
    let authenticated = new Auth();

    if (window.url.findHashParameter()) {
        switch (window.url.findHashParameter()) {
            case "change-password":
                authenticated.changeSectionState("change-password");
                modals.auth.open();
                break;
            case "login":
                authenticated.changeSectionState("login");
                modals.auth.open();
                break;
            case "signin":
                authenticated.changeSectionState("signin");
                modals.auth.open();
                break;
        }
    }
}

if (auth.hasOwnProperty('id_user')) {
    if (document.querySelectorAll(`a[href="/logout"]`).length) {
        for (const html of document.querySelectorAll(`a[href="/logout"]`)) {
            html.addEventListener("click", function (e) {
                token.remove();
                window.location.href = "/logout";
            });
        }
    }
    
    StartChatLogic();
}
