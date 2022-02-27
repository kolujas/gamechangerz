import { FetchServiceProvider as Fetch } from "../../../submodules/ProvidersJS/js/FetchServiceProvider.js";

import Token from "../Token.js";

/**
 * * Controls the JavaScript Assignment Model.
 * @export
 * @class Assignment
 * @extends {window.class}
 */
export default class Assignment extends window.class {
    /**
     * * Creates an instance of Assignment.
     * @param {object} [data={}]
     * @memberof Assignment
     */
    constructor (data = {}) {
        super({
            ...data,
        });
    }

    /**
     * * Return an Assignment.
     * @static
     * @async
     * @param {number} id_assignment
     * @returns {Assignment}
     * @memberof Assignment
     */
    static async get (id_assignment) {
        let token = Token.get();

        let query = await Fetch.get(`/api/assignments/${ id_assignment }`, {
            'Accept': 'application/json',
            'Authorization': `Bearer ${ token.data }`,
        });

        return new this({
            ...query.response.data.assignment,
        });
    }
}