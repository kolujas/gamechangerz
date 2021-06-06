import Class from "../../submodules/JuanCruzAGB/js/Class.js";

export class Step extends Class{
    constructor(props = {
      id: "step-1",  
    }, state = {
        opened: false,
    }){
        super(props, state);
        this.setHTML(`#poll.modal #${ this.props.id }`)
    }

    static all(){
        let steps = [];
        for (const html of document.querySelectorAll('#poll.modal .step')) {
            steps.push(new this({
                id: html.id,
            },{
                opened: !html.classList.contains('hidden'),
            }));
        }

        return steps;
    }

    open(){
        this.html.classList.remove('hidden');
        this.setState("opened", true);
    }

    close(){
        this.html.classList.add('hidden');
        this.setState("opened", false);
    }
}
export default Step;