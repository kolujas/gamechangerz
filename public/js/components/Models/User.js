import { FetchServiceProvider as Fetch } from "../../../submodules/ProvidersJS/js/FetchServiceProvider.js";

import Token from "../Token.js";

/**
 * * COntrols the JavaScript User Model.
 * @export
 * @class User
 * @extends {window.class}
 */
export default class User extends window.class {
    /**
     * * Creates an instance of User.
     * @param {object} [data={}]
     * @memberof User
     */
    constructor (data = {}) {
        super({
            ...data,
        });
    }

    /**
     * * Get the authenticated User.
     * @static
     * @async
     * @returns {User}
     * @memberof User
     */
    static async auth () {
        let token = Token.get();

        if (token) {
            let query = await Fetch.get('/api/user', {
                'Accept': 'application/json',
                'Authorization': `Bearer ${ token.data }`,
            });
    
            if (query.response.code == 200) {                
                return new this(query.response.data);
            }
        }

        token.remove();

        return null;
    }
}