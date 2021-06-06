import Class from "../../submodules/JuanCruzAGB/js/Class.js";
import Step from "./Step.js";

export class Poll extends Class{
    constructor(){
        super({},{
            page: "step-1",
        });

        this.setHTML("#poll.modal");
        this.setSteps();
        this.setEventsListener();
    }

    setEventsListener(){
        const instance = this;
        for (const btn of document.querySelectorAll("#poll.modal .poll-button")) {
            btn.addEventListener("click", function(e){
                e.preventDefault();
                if(this.classList.contains("prev")){
                    instance.prev();
                }
                if(this.classList.contains("next")){
                    instance.next();
                }
            })
        }
    }

    prev(){
        this.setState("page", `step-${parseInt(this.state.page.split("-").pop()) - 1}`);
        for (const step of this.steps){
            step.close();
            if(step.props.id === this.state.page){
                step.open();
            }
        }
    }

    next(){

        this.setState("page", `step-${parseInt(this.state.page.split("-").pop()) + 1}`);
        for (const step of this.steps){
            step.close();
            if(step.props.id === this.state.page){
                step.open();
            }
        }
    }

    setSteps(){
        if(!this.steps){
            this.steps = Step.all();
        }
        
    }
}

export default Poll;

