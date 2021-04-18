import { LocalStorageServiceProvider as LocalStorage } from "../submodules/ProvidersJS/js/LocalStorageServiceProvider.js";
import Class from "../submodules/JuanCruzAGB/js/Class.js";

const token_name = 'gamechangerz_access_token';

export class Token extends Class {
    constructor () {
        super();
        this.data = LocalStorage.get(token_name).data;
    }

    remove () {
        this.data = null;
        LocalStorage.remove(token_name);
    }

    static has () {
        return LocalStorage.has(token_name);
    }

    static get () {
        if (this.has()) {
            return new this();
        } else {
            return null;
        }
    }

    static save (data) {
        LocalStorage.set(token_name, data, true);
        return new this();
    }
}

export default Token;