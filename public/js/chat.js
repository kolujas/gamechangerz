import { FetchServiceProvider as Fetch } from "../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../submodules/ModalJS/js/Modal.js";

export class Chat extends Class {
    constructor (props) {
        super(props);
        this.createHTML();
    }

    createHTML () {
        new ModalJS({
            id: 'chat',
        }, {
            open: true,
        });
    }

    static async all (token) {
        let query = await Fetch.get('/api/chats', {
            'Accept': 'application/json',
            'Authorization': "Bearer " + token,
        });
        let chats = [];
        if (query.response.code === 200) {
            for (const chat of query.response.data.chats) {
                chats.push(new this(chat));
            }
        }
        return chats;
    }
}

export default Chat;