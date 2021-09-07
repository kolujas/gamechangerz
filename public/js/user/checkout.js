// ? External repositories
import { Dropdown as DropdownJS } from "../../submodules/DropdownJS/js/Dropdown.js";
import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import InputDateMaker from "../../submodules/InputDateMakerJS/js/InputDateMaker.js";
import { Notification as NotificationJS } from "../../submodules/NotificationJS/js/Notification.js";
import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";
import { Html } from "../../submodules/HTMLCreatorJS/js/HTMLCreator.js";
import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

import Token from "../components/Token.js";

let test = false;

let calendar;
let credits = 0;
let coupon = false;
let current = {};
let inputs = [];
let data = [];
let dates = [];
let dolar = 1;
let paypalActions = false;

/**
 * * Change the active Tab button section.
 * @param {object} params
 */
function changeButton (params = {}) {
    switch (params.opened) {
        case "mercadopago":
            document.querySelector(".cho-container .btn").style.display = "flex";
            if (document.querySelector(".cho-container .paypal-buttons")) {
                document.querySelector(".cho-container .paypal-buttons").style.display = "none";
            }
            if (!document.querySelector(".cho-container .paypal-buttons")) {
                document.querySelector("#tab-paypal").parentNode.removeChild(document.querySelector("#tab-paypal"));
            }
            validation.checkout.ValidationJS.setState("submit", true);
            break;
        case "paypal":
            document.querySelector(".cho-container .btn").style.display = "none";
            document.querySelector(".cho-container .paypal-buttons").style.display = "block";
            validation.checkout.ValidationJS.setState("submit", false);
            break;
    }
}

/**
 * * Check if there is a Lesson.
 * @param {string} date
 * @returns {boolean}
 */
function hasLesson (date) {
    let found = false;
    for (const lesson of lessons) {
        for (const day of lesson.days) {
            if (day.date == date) {
                found = true;
                break;
            }
        }
    }
    return found;
}

/**
 * * Find a Lesson.
 * @param {string} date
 * @returns {array}
 */
function findLessons (date) {
    let array = [];
    for (const lesson of lessons) {
        for (const day of lesson.days) {
            if (day.date == date) {
                array.push(lesson);
            }
        }
    }
    return array;
}

/**
 * * Add an Hour.
 * @param {object} params
 */
async function addHour (params = {}) {
    // ? If is testing the checkout
    if (test) {
        console.log([`-> Date current ${ current.date.parsed }`, current]);
        console.log([`-> Day (${ (params.day.slug) }) Hour current ${ params.hour.id_hour }:`, [params.day, params.hour]]);
    }

    let found = false;

    // * Loop the data
    for (const key in data) {
        if (Object.hasOwnProperty.call(data, key)) {
            const element = data[key];

            // ? If is testing the checkout
            if (test) {
                console.log(["Compared with:", element]);
            }

            // ? If an element has an Hour
            if (element.hour != null) {
                // ? If the element Hour is current
                if (element.hour.value == params.hour.id_hour && element.date.parsed == current.date.parsed) {
                    // ? If is testing the checkout
                    if (test) {
                        console.log(["-> Move to the end:", element]);
                    }

                    params.element.html.checked = true;

                    data.splice(key, 1);
                    data.push(element);

                    for (const key in dates) {
                        if (Object.hasOwnProperty.call(dates, key)) {
                            const object = dates[key];
                            if (object.index == element.index && object.date.parsed == element.date.parsed) {
                                dates.splice(key, 1);
                                dates.push(object);
                                break;
                            }
                        }
                    }

                    found = element;
                    break;
                }
            }
        }
    }

    // ? If is testing the checkout
    if (test) {
        console.log(["found:", found]);
    }

    // ? If the Hour was not found
    if (!found) {
        // * Get the Hour
        let input = inputs.shift();

        // * Update it
        input.value = params.hour.id_hour;
        input.checked = true;

        // * Save it
        inputs.push(input);

        found = false;

        // * Loop the data
        for (const element of [...data]) {
            // ? If is testing the checkout
            if (test) {
                console.log(["Compared with:", element]);
            }

            // ? If the element is the current
            if (element.index == current.index && element.hour == null) {
                // ? If is testing the checkout
                if (test) {
                    console.log(["-> Add Hour", {
                        input: input,
                        value: params.hour.id_hour,
                        parsed: `${ params.hour.from } - ${ params.hour.to }`,
                    }]);
                }

                // * Save the element Hour
                element.hour = {
                    input: input,
                    value: params.hour.id_hour,
                    parsed: `${ params.hour.from } - ${ params.hour.to }`,
                };

                found = element;
                break;
            }
        }

        // ? If is testing the checkout
        if (test) {
            console.log(["found:", found]);
        }

        // ? If the element was not previously set
        if (!found) {
            // * Add a new Date
            calendar.add(current.date.parsed, {
                hour: {
                    input: input,
                    value: params.hour.id_hour,
                    parsed: `${ params.hour.from } - ${ params.hour.to }`,
                }
            });
        }
    }

    // ? If the element parent was not found
    if (found) {
        // ? If is testing the checkout
        if (test) {
            console.log("-> Check by addHour");
        }

        // * Check PayPal
        checkPayPalState();
    }
}

/**
 * * Check if the data is ok.
 * @param {Hour|false} [hour]
 */
function checkData (hour = false) {
    // ? If is testing the checkout
    if (test) {
        console.log(["Data:", [...data]]);
    }

    // ? If there is data
    if (data.length) {
        let newData = [];

        // * Loop the data
        data: for (const key in data) {
            if (Object.hasOwnProperty.call(data, key)) {
                const element = data[key];
                let found = false;

                // * Loop the Dates
                for (const date of dates) {
                    // ? The Hour match with a Date
                    if (date.date.parsed == element.date.parsed && date.index == element.index) {
                        // * Continue
                        found = true;
                    }
                }

                // ? If the element was found
                if (found) {
                    // * Save it
                    newData.push(element);
                }
                // ? If the element was not found
                if (!found) {
                    // ? If is testing the checkout
                    if (test) {
                        console.log(["-> Remove", element]);
                    }

                    // ? If the element has an Hour
                    if (element.hour != null && ((!hour && calendar.props.quantity == 1) || calendar.props.quantity > 1)) {
                        element.hour.input.value = null;
                        element.hour.input.checked = false;
                    }
                }
            }
        }

        // * Replace the older data
        data = newData;

        newData = [];

        // ? If is testing the checkout
        if (test) {
            console.log(["Data after remove:", [...data]]);
        }

        // * Loop the Dates
        dates: for (const date of dates) {
            // ? If is testing the checkout
            if (test) {
                console.log(["How is data?", [...data]]);
            }

            // * Loop the data
            for (const key in data) {
                if (Object.hasOwnProperty.call(data, key)) {
                    const element = data[key];

                    // ? If is testing the checkout
                    if (test) {
                        console.log(["Compared:", date, element]);
                    }

                    // ? The Hour match with a Date
                    if (date.date.parsed == element.date.parsed && date.index == element.index) {
                        // ? If is testing the checkout
                        if (test) {
                            console.log(["-> Move to the end", element]);
                        }

                        // * Save it
                        newData.push(element);

                        // * Continue
                        continue dates;
                    }
                }
            }

            // * Create the new element
            let element = {
                ...date,
                hour: ( hour ? hour : null),
                index: current.index,
            };

            // ? If is testing the checkout
            if (test) {
                console.log(["-> Add", element]);
            }
            
            // * Add a new element
            newData.push(element);
        }

        // ? If is testing the checkout
        if (test) {
            console.log(["Data after move:", [...data]]);
        }

        // * Replace the older data
        data = newData;
    }

    // ? If there is not data
    if (!data.length) {
        // * Loop the Dates
        for (const date of dates) {
            // * Create the new element
            let element = {
                ...date,
                hour: ( hour ? hour : null),
                index: current.index,
            };

            // ? If is testing the checkout
            if (test) {
                console.log(["-> Add", element]);
            }

            // * Add a new element
            data.push(element);
        }

        // ? If is testing the checkout
        if (test) {
            console.log(["Data after create:", [...data]]);
        }
    }

    // ? If is testing the checkout
    if (test) {
        console.log("-> Check by checkData");
    }

    // * Check PayPal state
    checkPayPalState();
}

/**
 * * Check if the PayPal has to be enable or not.
 */
function checkPayPalState () { 
    // ? If is testing the checkout
    if (test) { 
        console.log(["Final data:", [...data]]);  
    }

    // ? If the quantity of Dates & Hours is less than the correct one
    if (data.length < (type.id_type == 1 ? 1 : 4)) {
        if (paypalActions) {
            // * Disable PayPal
            paypalActions.disable();
            return;
        }
    } else {
        if (paypalActions) {
            // * Disable PayPal
            paypalActions.enable();
            return;
        }
    }

    console.error("PayPal did not load");
}

/**
 * * Print the Teacher available Hours.
 * @param {object} params
 */
async function printHours (params = {}) {
    // ? If is testing the checkout
    if (test) {
        console.log([`-> Date current ${ params.current.date.parsed }`, params]);
    }

    // * Save the current globally
    current = params.current;

    // * Save the dates globally
    dates = params.dates;

    // * Clear the <ul> Hours
    let list = document.querySelector("ul.hours");
    list.innerHTML = "";

    if (paypalActions) {
        // * Disable PayPal
        paypalActions.disable();
    }

    // * Check if everything is OK
    checkData(params.hasOwnProperty("hour") ? params.hour : false);

    // * Loop the Days
    for (const day of days) {
        // ? If the Date Day match with a Day
        if (current.date.value.getDay() == day.id_day) {
            // * Loop the Hours
            for (const hour of day.hours) {
                // * Activate the Hour
                hour.active = true;
                hour.checked = false;

                // ? If a Lessons was found
                if (hasLesson(current.date.parsed)) {
                    // * Loop the Lessons
                    lessons: for (const foundLesson of findLessons(current.date.parsed)) {
                        // ? If the current Lesson is not the same as another Teacher Lesson
                        if (lesson.id_lesson != foundLesson.id_lesson) {
                            // * Loop the Lesson Days
                            for (const dayFromLesson of foundLesson.days) {
                                // * Loop the Day Hours
                                for (const hourFromLesson of dayFromLesson.hours) {
                                    // ? If the Hour match with a Day Hour
                                    if (hourFromLesson.id_hour == hour.id_hour && dayFromLesson.date == current.date.parsed) {
                                        // * Deactivate the Hour
                                        hour.active = false;
                                        break lessons;
                                    }
                                }
                            }
                        }
                    }
                }

                // * Loop the data
                for (const element of data) {
                    // ? If the new Hour match with the older
                    if (element.hour && element.hour.value == hour.id_hour && element.date.parsed == current.date.parsed) {
                        // * Checked the Hour
                        hour.checked = true;
                    }
                }

                
                // ? If the params has an hour property
                if (params.hasOwnProperty("hour")) {
                    // ? If the new Hour match with the older
                    if (params.hour.value == hour.id_hour) {
                        // * Checked the Hour
                        hour.checked = true;
                    }
                }

                // * Create the <li>
                let item = new Html("li", {
                    innerHTML: [
                        ["input", {
                            props: {
                                type: type.id_type == 1 ? "radio": "checkbox",
                                name: `date-${ current.index }-hours[]`,
                                id: `date-${ current.index }-hour-${ hour.id_hour }`,
                                defaultValue: hour.id_hour,
                                dataset: {
                                    date: current.date.parsed,
                                    index: current.index,
                                },
                            }, state: {
                                id: true,
                                checked: hour.checked,
                                disabled: !hour.active,
                            }, callbacks: {
                                change: {
                                    function: addHour,
                                    params: { day: day, hour: hour },
                                },
                            },
                        }], ["label", {
                            props: {
                                classes: ["btn", "btn-four", "btn-outline", "color-white"],
                                for: `date-${ current.index }-hour-${ hour.id_hour }`,
                            }, innerHTML: [
                                ["span", {
                                    props: {
                                        classes: ["py-2", "px-4"],
                                    }, innerHTML: `${ hour.from } - ${ hour.to }`,
                                }],
                            ],
                        }],
                    ], 
                });

                // * Append the <li>
                list.appendChild(item.html);
            }
        }
    }
}

/**
 * * Creates the Hours <input>.
 * @param {number} quantity
 */
function createHours(quantity) {
    for (let index = 0; index < quantity; index++) {
        let input = new Html("input", {
            props: {
                type: "checkbox",
                name: "hours[]",
                defaultValue: null,
                classes: ["checkout", "form-input"],
            },
        });
        document.querySelector("div.hours").appendChild(input.html);
        inputs.push(input.html);
    }
}

/**
 * * Set the Checkout finish state.
 */
function setFinishState () {
    for (const btn of document.querySelectorAll(".cho-container .btn span")) {
        for (const child of [...btn.children]) {
            child.classList.add("hidden");
            if (child.nodeName == "SPAN") {
                child.classList.remove("hidden");
            }
        }
    }
}

/**
 * * Set the Checkout loading state.
 */
function setLoadingState () {
    for (const btn of document.querySelectorAll(".cho-container .btn span")) {
        for (const child of [...btn.children]) {
            child.classList.add("hidden");
            if (child.nodeName == "DIV") {
                child.classList.remove("hidden");
            }
        }
    }
}

/**
 * * Submit form callback function
 * @param {object} params
 */
async function submit (params = {}) {
    // * Set the loading state
    setLoadingState();

    // * Search the Lessons
    let query = await Fetch.get(`/api/users/${ slug }/lessons`);
    if (query.response.code == 200) {
        lessons = query.response.data.lessons;
    }

    let valid = true;

    // * Loop the data
    for (const element of data) {
        // * Loop the Lessons
        for (const lesson of lessons) {
            // * Loop the Lesson Days
            for (const day of lesson.days) {
                // ? If the day is the same as the element Day
                if (day.date == element.date.parsed) {
                    // * Loop the Day Hours
                    for (const hour of day.hours) {
                        // ? If the Hour is the same as the element Hour
                        if (hour.id_hour == element.hour.value) {
                            // * Throw the NotificationJS
                            new NotificationJS({
                                code: 403,
                                message: `La fecha seleccionada (${ element.date.parsed } entre ${ element.hour.parsed }) ya se encuentra en uso`,
                                classes: ["russo"],
                            }, {
                                open: true,
                            });
                            
                            // * Invalidate
                            valid = false;

                            // ? If is testing the checkout
                            if (test) {
                                console.log(["-> Remove element:", element]);
                            }

                            // * Remove the date
                            calendar.remove(element.date.parsed);
                            break;
                        }
                    }
                }
            }
        }
    }

    // ? If the submit is valid
    if (valid) {
        // ? If is testing the checkout
        if (test) {
            console.log("-> Submit");
        }

        // ? If is not testing the checkout
        if (!test) {
            // ? If the selected method is MercadoPago
            if (document.querySelector("#input-mercadopago").checked) {
                document.querySelector("form#checkout").submit();    
            }
            // ? If the selected method is PayPal
            if (document.querySelector("#input-paypal").checked) {
                // ! PayPal does not support trigger click button event
            }
        }
    }

    // * Set the loading state
    setFinishState();
}

function createPayPalButton () {
    paypal_sdk.Buttons({
        onInit: function (data, actions) {
            actions.disable();
            paypalActions = actions;
        }, style: {
            layout: "horizontal",
            tagline: false,
            size: "responsive",
        }, createOrder: function (data, actions) {
            let price = parseInt(type.price);
            if (price < dolar / 2) {
                price = dolar / 2;
            }

            if (price - credits < dolar / 2 && price - credits > 0) {
                credits -= dolar - (price - credits);
            }
            if (credits < 0) {
                credits = 0;
            }
            if (price -= credits < 0) {
                credits += price -= credits;
            }
            price -= credits;
            if (coupon) {
                bool = true;

                if (coupon.limit) {
                    bool = false;

                    if (intval(coupon.used) < intval(coupon.limit)) {
                        bool = true;
                    }
                }

                if (bool) {
                    if (coupon.type.id_type == 1) {
                        if (price - (price * intval(coupon.type.value) / 100) >= dolar / 2) {
                            price -= price * intval(coupon.type.value) / 100;
                        }
                    }
                    if (coupon.type.id_type == 2) {
                        if (price - intval(coupon.type.value) >= dolar / 2) {
                            price -= intval(coupon.type.value);
                        }
                    }
                }
            }
            
            if (price < dolar / 2 && price > 0) {
                price = dolar / 2;
            }

            if (price == 0) {
                validation.checkout.ValidationJS.validate();
            }
            if (price > 0) {
                if (validation.checkout.ValidationJS.validate()) {
                    price /= dolar;
        
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: price,
                            }, custom_id: lesson.id_lesson,
                        }]
                    });
                }
            }
        }, onApprove: function (data, actions) {
            return actions.order.capture().then((details) => {
                document.querySelector("form#checkout").submit();
            });
    }}).render(".cho-container");

    changeButton();
}

async function validatecredits () {
    if (credits) {
        const token = Token.get();
    
        let formData = new FormData();
        formData.append("credits", credits);
    
        let query = await Fetch.send({
            method: "POST",
            url: "/api/credits/validate",
        }, {
            "Accept": "application/json",
            "Content-type": "application/json; charset=UTF-8",
            "X-CSRF-TOKEN": document.querySelector("meta[name=csrf-token]").content,
            "Authorization": "Bearer " + token.data,
        }, formData);
    
        if (query.response.code == 200) {
            document.querySelector(`.support-credits`).innerHTML = "";
            document.querySelector(`.support-credits`).classList.add("hidden");
        }
    
        if (query.response.code != 200) {
            credits = 0;
            document.querySelector(`.support-credits`).innerHTML = query.response.message;
            document.querySelector(`.support-credits`).classList.remove("hidden");
        }
    
        if (paypalActions) {
            // * Disable PayPal
            paypalActions.enable();
        }
    }
}

async function validateCoupon () {
    if (coupon) {
        let formData = new FormData();
        formData.append("coupon", coupon);
    
        let query = await Fetch.send({
            method: "POST",
            url: "/api/coupons/validate",
        }, {
            "Accept": "application/json",
            "Content-type": "application/json; charset=UTF-8",
            "X-CSRF-TOKEN": document.querySelector("meta[name=csrf-token]").content,
        }, formData);
    
        if (query.response.code == 200) {
            if (query.response.hasOwnProperty("data")) {
                coupon = query.response.data.coupon;
            }
            document.querySelector(`.support-coupon`).innerHTML = "";
            document.querySelector(`.support-coupon`).classList.add("hidden");
        }
    
        if (query.response.code != 200) {
            coupon = false;
            document.querySelector(`.support-coupon`).innerHTML = query.response.message;
            document.querySelector(`.support-coupon`).classList.remove("hidden");
        }
    
        if (paypalActions) {
            // * Disable PayPal
            paypalActions.enable();
        }
    }
}

document.addEventListener("DOMContentLoaded", async function (e) {
    if (typeof paypal_sdk != "undefined") {
        let query = await Fetch.get("/api/dolar");
        dolar = parseInt(query.response.data.dolar);
        createPayPalButton();
    }

    if (type.id_type != 2) {
        new DropdownJS({
            id: "date-1",
        }, {
            open: true,
        });

        let enableDays = [];
        for (const day of days) {
            if (day.hours.length) {
                enableDays.push(day.id_day);
            }
        }

        let now = new Date();
        now.setDate(new Date().getDate() + 1);
        
        calendar = new InputDateMaker({
            props: {
                today: now,
                availableWeekDays: enableDays,
                classes: {
                    input: ["checkout", "form-input"],
                }, lang: "es",
                name: "dates[]",
                quantity: (type.id_type == 1 ? 1 : 4),
            }, state: {
                enablePastDates: false,
                enableToday: false,
                generate: document.querySelector(".dropdown-main > section:first-of-type"),
                uncheck: false,
            }, callbacks: {
                changeMonth: {
                    function: () => { if (document.querySelector("label.date.today")) { document.querySelector("label.date.today").classList.remove("today"); } }, 
                }, update: {
                   function: printHours,
        }}});

        document.querySelector("label.date.today").classList.remove("today");

        createHours((type.id_type == 1 ? 1 : 4));
    }

    validation.checkout.ValidationJS = new ValidationJS({
        id: "checkout",
        rules: validation.checkout.rules,
        messages: validation.checkout.messages,
    }, {
        submit: false
    }, {
        valid: {
            function: submit,
    }});

    new TabMenuJS({
        id: "methods"
    }, {
        open: "mercadopago",
    }, {
        function: changeButton,
    });

    document.querySelector(`input[name="credits"]`).addEventListener("focusout", function (e) {
        credits = this.value;
        if (paypalActions) {
            // * Disable PayPal
            paypalActions.disable();
        }
        validatecredits();
    });

    document.querySelector(`input[name="coupon"]`).addEventListener("focusout", function (e) {
        coupon = this.value;
        if (paypalActions) {
            // * Disable PayPal
            paypalActions.disable();
        }
        validateCoupon();
    });
});