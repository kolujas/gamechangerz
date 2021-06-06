// ? JuanCruzAGB repository
import Class from "../../JuanCruzAGB/js/Class.js";

/**
 * * CountDown makes an excellent count down.
 * @export
 * @class CountDown
 * @author Juan Cruz Armentia <juancarmentia@gmail.com>
 * @extends Class
 */
export class CountDown extends Class {
    /**
     * * Creates an instance of CountDown.
     * @param {object} [props] CountDown properties:
     * @param {Date} [props.scheduled_date_time=new Date] CountDown scheduled date time.
     * @param {object} [callbacks] CountDown callbacks:
     * @param {object} [callbacks.current] CountDown current callback:
     * @param {function} [callbacks.current.function] CountDown current callback function.
     * @param {*} [callbacks.current.params] CountDown current callback function params.
     * @param {HTMLElement} html CountDown HTML Element.
     * @memberof CountDown
     */
    constructor (props = {
        scheduled_date_time: new Date(),
        timer: {
            // TODO year: true,
            // TODO month: true,
            day: true,
            hours: true,
            minutes: true,
            seconds: true,
        }, message: 'Expired scheduled date time'
    }, callbacks = {
        current: {
            function: function (params) { /* console.log(`${ params.countDown.time.hours }:${ params.countDown.time.hours }:${ params.countDown.time.seconds }`) */ },
            params: {},
        }, end: {
            function: function (params) { console.log('Finished') },
            params: {},
    }}) {
        super({ ...CountDown.props, ...props }, { continue: true });
        this.setCallbacks({ ...CountDown.callbacks, ...callbacks });
        this.setServerTime();
        this.makeInterval();
    }

    /**
     * * Set the CountDown current tiem.
     * @memberof CountDown
     */
    async setServerTime () {
        // let fetchprovider = await FetchServiceProvider.getData(`/api/server/time`);
        // let serverTime = new Date(fetchprovider.getResponse('data').now).getTime();
        // let clientTime = new Date().getTime();
        // this.difference = serverTime - clientTime;
        this.setProps('server_time', new Date());
    }

    /**
     * * Continue the interval.
     * @memberof CountDown
     */
    continue () {
        this.setState('continue', true);
    }

    /**
     * * Makes the CountDown interval.
     * @memberof CountDown
     */
    makeInterval () {
        let instance = this;
        instance.time = {};
        let distance;
        this.interval = setInterval((e) => {
            if (instance.state.continue) {
                distance = instance.props.scheduled_date_time.getTime() - new Date().getTime();
                instance.time.days = 0;
                instance.time.hours = 0;
                instance.time.minutes = 0;
                instance.time.seconds = 0;
                if (instance.props.timer.days) {
                    instance.time.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                }
                if (instance.props.timer.hours) {
                    instance.time.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    if (!instance.props.timer.days) {
                        instance.time.hours = Math.floor(distance / (1000 * 60 * 60));
                    }
                    if (instance.time.hours.toString().length < 2) {
                        instance.time.hours = `0${instance.time.hours}`;
                    }
                }
                if (instance.props.timer.minutes) {
                    instance.time.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    if (instance.time.minutes.toString().length < 2) {
                        instance.time.minutes = `0${instance.time.minutes}`;
                    }
                }
                if (instance.props.timer.seconds) {
                    instance.time.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    if (instance.time.seconds.toString().length < 2) {
                        instance.time.seconds = `0${instance.time.seconds}`;
                    }
                }
                instance.execute('current', {
                    countDown: instance,
                    time: instance.time,
                    state: 202
                });
            }
            if (parseInt(instance.time.days) <= 0 && parseInt(instance.time.hours) <= 0 &&parseInt( instance.time.minutes) <= 0 && parseInt(instance.time.seconds) <= 0) {
                instance.stop();
            }
        });
    }

    /**
     * * Pause the interval.
     * @memberof CountDown
     */
    pause () {
        this.setState('continue', false);
    }

    /**
     * * Stops the interval.
     * @memberof CountDown
     */
    stop () {
        clearInterval(this.interval);
        this.execute('end', {
            countDown: this,
            state: 200,
        });
    }

    /**
     * @static
     * @var {object} props Default properties.
     */
    static props = {
        scheduled_date_time: new Date(),
        timer: {
            // TODO year: true,
            // TODO month: true,
            day: true,
            hours: true,
            minutes: true,
            seconds: true,
        }, message: 'Expired scheduled date time'
    };
    
    /**
     * @static
     * @var {object} callbacks Default callbacks.
     */
    static callbacks = {
    current: {
        function: function (params) { /* console.log(`${ params.countDown.time.hours }:${ params.countDown.time.hours }:${ params.countDown.time.seconds }`); */ },
        params: {},
    }, end: {
        function: function () { /* console.log('Finished'); */ },
        params: {},
    }}
}

// ? Default export
export default CountDown;