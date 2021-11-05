const token_name = 'gamechangerz_access_token';

export class Token extends window.class {
    constructor () {
        super();
        this.data = window.localstorage.get(token_name).data;
    }

    remove () {
        this.data = null;
        window.localstorage.remove(token_name);
    }

    static has () {
        return window.localstorage.has(token_name);
    }

    static get () {
        if (this.has()) {
            return new this();
        } else {
            return null;
        }
    }

    static save (data) {
        window.localstorage.set(token_name, data, true);
        return new this();
    }
}

export default Token;