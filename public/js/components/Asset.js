import Class from "../../submodules/JuanCruzAGB/js/Class.js";

export class Asset extends Class {
    constructor (url = '') {
        super();
        this.route = document.querySelector('meta[name=asset]').content + url;
    }
}

export default Asset;