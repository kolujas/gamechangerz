export class Asset extends window.class {
    constructor (url = '') {
        super();
        this.route = document.querySelector('meta[name=asset]').content + url;
    }
}

export default Asset;