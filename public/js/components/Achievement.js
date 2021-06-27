import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import { Modal as ModalJS } from "../../submodules/ModalJS/js/Modal.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";
import { HTMLCreator as HTMLCreatorJS } from "../../submodules/HTMLCreatorJS/js/HTMLCreator.js";

export class Achievement extends Class {
    constructor(props = {}, state = {}){
        super(props, state);
        this.setHTML(Achievement.component('list', {props: this.props,
                                                    state: this.state
        }))
    }
    static component(component, data){
        return this[component](data);
    }

    static list(data){
        return new HTMLCreatorJS("table", {
            props: {
                classes: {
                 table: ["tabla", "w-full"]
                }
            },
            structure: [
                    // tbody: {
                    //     props: 
                    // }
            ]        
            
        }).html;
    }

    static setModalJS () {
        modals.achievements = new ModalJS({
            id: 'achievements',
        }, {
            open: URL.findHashParameter() === 'achievements',
            detectHash: true,
            outsideClick: true,
        });
    }    
}

export default Achievement;