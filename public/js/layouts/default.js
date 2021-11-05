import Auth from "../components/Auth.js";
import Chat from "../components/Chat.js";
import Token from "../components/Token.js";

async function getChats(token) {
    const chats = await Chat.all(token.data);
    new Chat({ token: token.data }, chats);
}

new window.navmenu({
    id: "nav-id",
    sidebar: {
        id: ["menu"],
        position: ["left"],
}});

const token = Token.get();
if (!auth) {
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

if (auth) {
    if (document.querySelectorAll(`a[href="/logout"]`).length) {
        for (const html of document.querySelectorAll(`a[href="/logout"]`)) {
            html.addEventListener("click", function (e) {
                token.remove();
                window.location.href = "/logout";
            });
        }
    }
    getChats(token);
} else if (token) {
    token.remove();
}
