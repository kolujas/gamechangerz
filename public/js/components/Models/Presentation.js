import { FetchServiceProvider as Fetch } from "../../../submodules/ProvidersJS/js/FetchServiceProvider.js";

import Token from "../Token.js";

/**
 * * Controls the JavaScript Presentation Model.
 * @export
 * @class Presentation
 * @extends {window.class}
 */
export default class Presentation extends window.class {
    /**
     * * Creates an instance of Presentation.
     * @param {object} [data={}]
     * @memberof Presentation
     */
    constructor (data = {}) {
        super({
            ...data,
        });
    }

    /**
     * * Return an Presentation.
     * @static
     * @async
     * @param {number} id_presentation
     * @returns {Presentation}
     * @memberof Presentation
     */
    static async get (id_presentation) {
        let token = Token.get();

        let query = await Fetch.get(`/api/presentations/${ id_presentation }`, {
            'Accept': 'application/json',
            'Authorization': `Bearer ${ token.data }`,
        });

        return new this({
            ...query.response.data.presentation,
        });
    }
}