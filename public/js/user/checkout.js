// ? External repositories
import { Dropdown as DropdownJS } from "../../submodules/DropdownJS/js/Dropdown.js";
import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { InputDateMaker as InputDateMakerJS } from "../../submodules/InputDateMakerJS/js/InputDateMaker.js";
import { Notification as NotificationJS } from "../../submodules/NotificationJS/js/Notification.js";
import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";
import { Html } from "../../submodules/HTMLCreatorJS/js/HTMLCreator.js";
import ValidationJS from "../../submodules/ValidationJS/js/Validation.js";

import Token from "../components/Token.js";

let calendar;
let current = {};
let hours = [];
let inputs = [];
let lessons = [];
let paypalActions;
const token = Token.get();

paypal_sdk.Buttons({
    onInit: function(data, actions) {
        actions.disable();
        paypalActions = actions;
    }, style: {
        layout: "horizontal",
        tagline: false,
        size: "responsive",
    }, createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: type.price,
                }, custom_id: lesson.id_lesson,
            }]
        });
    }, onApprove: function (data, actions) {
        return actions.order.capture().then((details) => {
            document.querySelector("form#checkout").submit();
        });
}}).render(".cho-container");

function changeButton (params) {
    switch (params.opened) {
        case "mercadopago":
            document.querySelector(".cho-container .btn").style.display = "flex";
            document.querySelector(".cho-container .paypal-buttons").style.display = "none";
            break;
        case "paypal":
            document.querySelector(".cho-container .btn").style.display = "none";
            document.querySelector(".cho-container .paypal-buttons").style.display = "block";
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
            if (day.date === date) {
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
            if (day.date === date) {
                array.push(lesson);
            }
        }
    }
    return array;
}

function createPayPal () {
    paypal_sdk.Buttons({
        createOrder: (data, actions) => {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: type.price,
                    }, custom_id: lesson.id_lesson,
                }]
            });
        }, onApprove: (data, actions) => {
            return actions.order.capture().then((details) => {
                document.querySelector("form#checkout").submit();
            });
    }}).render("#paypal main");
}

/**
 * * Updates a the current Lesson.
 */
async function updateLesson () {
    console.log("- Update Lesson");

    // * Set the FormData
    let formData = new FormData();
    let hours = [];
    for (const hour of hours) {
        hours.push(hour.input.value);
    }
    formData.set("hours", hours);
    let dates = [];
    for (const date of calendar.props.selectedIndex) {
        dates.push(date.input.value);
    }
    formData.set("dates", dates);

    // * Send the Query
    let query = await Fetch.send({
        url: `/api/lessons/${ lesson.id_lesson }/update`,
        method: "put"
    }, {
        "Accept": "application/json",
        "Authorization": "Bearer " + token.data,
        "Content-type": "application/json; charset=UTF-8",
    }, formData);

    // ? If the response throws success
    if (query.response.code === 200) {
        // createPayPal();
        return true;
    }

    console.error(query.response);
}

/**
 * * Add an Hour.
 * @param {*} params
 */
async function addHour (params) {
    console.log("Hour clicked:");
    console.log(params);

    // * Instance the Current Hour
    let hour = {};

    // ? If the Hour is checked
    if (params.element.state.checked) {
        console.log("- Get first Hour");

        // * Get the last Hour <input>
        hour.input = [...inputs].shift();
    }
    // ? If the Hour is not checked
    if (!params.element.state.checked) {
        console.log("- Get an Hour");

        // * Check
        params.element.setState("checked", true);
        params.element.html.checked = true;

        for (const key in [...hours]) {
            if (Object.hasOwnProperty.call([...hours], key)) {
                hour = [...hours][key];
                if (parseInt(hour.value) === parseInt(params.hour.id_hour) && current.date === hour.date && parseInt(current.index) === parseInt(hour.index)) {
                    break;
                }
            }
        }
    }

    // * Get the params index
    let index = current.index;

    // * Loop the Hours
    for (const aux of hours) {
        // ? If an Hour match with the selected
        if (aux.date === current.date && parseInt(aux.index) + 1 > index) {
            // * Creates a new selected index
            index = parseInt(aux.index) + 1;
        }
    }

    // * Replace the Hour params
    hour.input.dataset.date = current.date;
    hour.input.dataset.index = index;
    hour.input.value = params.hour.id_hour;
    hour.input.checked = true;

    // * Disable PayPal
    paypalActions.disable();

    // * Check if an Hour was used
    let formData = new FormData();
    formData.set("date", current.date);
    formData.set("id_type", type.id_type);
    formData.set("id_hour", params.hour.id_hour);
    let query = await Fetch.send({
        url: `/api/users/${ slug }/lessons`,
        method: "post"
    }, {
        "Accept": "application/json",
        "Authorization": "Bearer " + token.data,
        "Content-type": "application/json; charset=UTF-8",
    }, formData);

    // ? If the query success
    if (query.response.code === 200) {
        // ? If the Hour was not used
        if (!query.response.found) {
            console.log("- Hour not used");

            // * Add the new Hour <input>
            hours.push({
                index: index,
                date: current.date,
                input: hour.input,
                value: params.hour.id_hour,
            });

            console.log("New Hour");
            console.log({
                index: index,
                date: current.date,
                input: hour.input,
                value: params.hour.id_hour,
            });

            // * Check the Dates
            checkDates([...hours].pop());

            // ? If the qunatity of Hours is valid
            if (hours.length === calendar.props.quantity) {
                // * Update the Lesson
                updateLesson();
            }
        }

        // ? If the Hour was used
        if (query.response.found) {
            console.log("- Hour used");

            new NotificationJS({
                code: 403,
                message: `La fecha seleccionada ya se encuentra en uso`,
                classes: ["russo"],
            }, {
                open: true,
            });

            // * Remove Hour if does not match with any Date
            removeHour({
                index: parseInt(current.index),
                date: current.date,
            });
        }
    }

    // * Check PayPal
    checkPayPalState();
}

/**
 * * Add a Date
 * @param {*} selected
 */
function addDate (selected) {
    console.log("- Add Date");

    // * Instance the Date
    let date = {};

    // ? If the Dates are not the same as que quantity
    if (calendar.props.selectedIndex.length < calendar.props.quantity) {
        date.input = [...calendar.htmls].shift();
    }
    // ? If the Dates are the same as que quantity
    if (calendar.props.selectedIndex.length === calendar.props.quantity) {
        // * Get the last Date
        date = calendar.props.selectedIndex.shift();
    
        // * Loop the Hours
        for (const hour of hours) {
            // ? If an Date have an Hour
            if (parseInt(hour.index) === parseInt(date.index) && date.date === hour.date) {
                console.log("- Previous Date have an Hour");
    
                // * Remove an Hour
                removeHour(hour);
                break;
            }
        }
    }

    // * Repalce the Date params
    date.input.value = selected.date;

    // * Get a new Index
    let index = 1;
    for (const selected of calendar.props.selectedIndex) {
        if (index <= parseInt(selected.index)) {
            index = parseInt(selected.index) + 1;
        }
    }

    // * Create a new selectged object
    calendar.props.selectedIndex.push({
        index: index,
        date: selected.date,
        input: date.input,
    });

    console.log("New Dates");
    console.log({
        index: index,
        date: selected.date,
        input: date.input,
    });

    // * Active the Day
    activeDay(selected.date);
}

/**
 * * Activate a Day
 * @param {string} date
 */
function activeDay (date) {
    console.log("- Activate a Day");

    // * Loop the Days
    for (const day of calendar.days) {
        // ? If the Day match with the selected Date
        if (day.dataset.date === date) {
            console.log("Day:");
            console.log(day);

            // * Loop the Hours
            for (const hour of hours) {
                // ? If the Day match with the Hour
                if (hour.date === day.dataset.date) {
                    console.log("- There is an Hour");
                    console.log(hour);

                    // * Add className
                    if (!day.classList.contains("withDate")) {
                        day.classList.add("withDate");
                    }
                }
            }

            // * Check the Day
            day.checked = true;
            break;
        }
    }
}

/**
 * * Deactivate a Day.
 * @param {string} date
 */
function deactiveDay (date) {
    console.log("- Deactive a Day");

    // * Loop the Days
    for (const day of calendar.days) {
        // ? If the Day Date match with the selected Date 
        if (day.dataset.date === date) {
            console.log("Day:");
            console.log(day);

            // * Unchecked
            if (day.classList.contains("withDate")) {
                day.classList.remove("withDate");
            }
            day.checked = false;
            break;
        }
    }
}

/**
 * * Remove a Date
 * @param {*} selected
 */
function removeDate (selected) {
    console.log("- Remove a Date");

    // * Loop the Dates
    for (const key in [...calendar.props.selectedIndex]) {
        if (Object.hasOwnProperty.call(calendar.props.selectedIndex, key)) {
            const date = calendar.props.selectedIndex[key];
            // ? If a Date match with the selected
            if (parseInt(selected.index) === parseInt(date.index) && date.date === selected.date) {
                console.log("- Date to remove");
                console.log(date);

                // * Remove it
                calendar.props.selectedIndex.splice(key, 1);
                date.input.value = null;
                break;
            }
        }
    }

    // * Loop the Hours
    for (const hour of hours) {
        // ? If an Hour match with a selected object removed
        if (parseInt(hour.index) === selected.index && hour.date === selected.date) {
            console.log("- Hour to remove");
            console.log(hour);

            // * Remove an Hour
            removeHour(hour);
            break;
        }
    }

    // * Add a Date
    addDate(selected);
}

/**
 * * Check the Dates.
 */
function checkDates (selected) {
    console.log("- Check Dates by Hours");

    console.log("Data:");
    console.log([
        [...calendar.props.selectedIndex],
        [...hours],
    ]);  

    // ? If the Hours are more than the Dates
    if (hours.length > calendar.props.selectedIndex.length) {
        // * Add a Date
        addDate(selected);
    // ? If there are more than 1 Hours
    } else if (hours.length > 1) {
        // ? If there are 4 Hours
        if (hours.length === 4) {
            // * Remove a Date
            removeDate([...calendar.props.selectedIndex].pop());
        }
    }
}

/**
 * * Remove an Hour.
 * @param {object} selected
 */
function removeHour (selected) {
    console.log("- Remove an Hour");

    // * Loop the Hours
    for (const key in [...hours]) {
        if (Object.hasOwnProperty.call(hours, key)) {
            const hour = hours[key];
            // ? The Hour match with the one who has to be removed
            if (hour.date === selected.date && parseInt(hour.index) === parseInt(selected.index)) {
                console.log("Hour to remove:");
                console.log(hour);

                // * Remove Hour
                hours.splice(key, 1);
                hour.input.value = null;
                hour.input.removeAttribute("data-date");
                hour.input.removeAttribute("data-index");
                hour.input.checked = false;
                break;
            }
        }
    }

    // * Loop the <inputs> from ul.hours
    for (const input of [...document.querySelectorAll("ul.hours input")]) {
        // ? If the <input> match with the selected
        if (parseInt(input.dataset.index) === parseInt(selected.index) && input.dataset.date === selected.date) {
            console.log("Input to uncheck:");
            console.log(input);

            // * Unchecked
            input.checked = false;
            break;
        }
    }

    // * Check if there is another Hour with the Day selected
    let found = false;
    for (const hour of hours) {
        if (hour.date === selected.date) {
            console.log("- There is another Hour with the same day");
            found = true;
            break;
        }
    }

    // ? If not
    if (!found) {
        // * Remove Day
        deactiveDay(selected.date);
    }
}

/**
 * * Sort Hours function.
 * @returns {number}
 */
function sort () {
    return function (a, b) {
        let aKey = 0, bKey = 0, found = false;

        // * Loop the Dates for the First Hour
        for (aKey in calendar.props.selectedIndex) {
            if (Object.hasOwnProperty.call(calendar.props.selectedIndex, aKey)) {
                const selected = calendar.props.selectedIndex[aKey];
                // ? If the first Hour match with a Date
                if (a.date === selected.date && parseInt(selected.index) === parseInt(a.index)) {
                    // * Set found
                    found = true;
                    break;
                }
            }
        }

        // ? If not found
        if (!found) {
            // * First Hour key is 0
            aKey = 0;
        }
        found = false;

        // * Loop the Dates for the Second Hour
        for (bKey in calendar.props.selectedIndex) {
            if (Object.hasOwnProperty.call(calendar.props.selectedIndex, bKey)) {
                const selected = calendar.props.selectedIndex[bKey];
                // ? If the second Hour match with a Date
                if (b.date === selected.date && parseInt(selected.index) === parseInt(b.index)) {
                    // * Set found
                    found = true;
                    break;
                }
            }
        }

        // ? If not found
        if (!found) {
            // * Second Hour key is 0
            bKey = 0;
        }

        // ? If First Hour key bigger than second one
        if (aKey > bKey) {
            // * Return 1
            return 1;
        }

        // ? If First Hour key tinier than second one
        if (aKey < bKey) {
            // * Return -1
            return -1;
        }

        // * Return 0
        return 0;
    }
}

/**
 * * Check if the data is ok.
 * @param {*} params
 */
function checkHours () {
    // ? If there are Hours
    if (hours.length >= 1) {
        // * Loop the Hours
        hours: for (const hour of hours) {
            // * Loop the Dates
            for (const date of calendar.props.selectedIndex) {
                // ? The Hour match with a Date
                if (date.date === hour.date && date.index === hour.index) {
                    // * Active the Day
                    activeDay(date.date);
    
                    // * Continue
                    continue hours;
                }
            }
    
            // * Remove Hour if does not match with any Date
            removeHour(hour);
        }
    }

    // * Check PayPal state
    checkPayPalState();

    // * Sort the Hours
    hours.sort(sort());
}

/**
 * * Check if the PayPal has to be enable or not.
 */
function checkPayPalState () {  
    console.log("Final data:");
    console.log([
        [...calendar.props.selectedIndex],
        [...hours],
    ]);  

    // ? If the quantity of Dates & Hours is less than the correct one
    if (calendar.props.selectedIndex.length < (type.id_type === 1 ? 1 : 4) && hours.length < (type.id_type === 1 ? 1 : 4)) {
        // * Disable PayPal
        paypalActions.disable();
    } else {
        // * Enable PayPal
        paypalActions.enable();
    }
}

/**
 * * Print the Teacher available Hours.
 * @param {*} params
 */
async function printHours (params) {
    console.log("Date clicked:");
    console.log(params.clicked);
    // * Search the Lessons
    let query = await Fetch.get(`/api/users/${ slug }/lessons`);
    if (query.response.code === 200) {
        lessons = query.response.data.lessons;
    }

    // * Save the current globally
    current = params.clicked;

    // * Clear the <ul> Hours
    let list = document.querySelector("ul.hours");
    list.innerHTML = "";

    // * Disable PayPal
    paypalActions.disable();

    // * Parse the selected Date
    let date = new Date(current.date.split("-"));

    // * Loop the Days
    for (const day of days) {
        // ? If the Date Day match with a Day
        if (date.getDay() === day.id_day) {
            console.log("Day clicked:");
            console.log(day);

            console.log("Hours:");
            // * Loop the Hours
            for (const hour of day.hours) {
                // * Activate the Hour
                hour.active = true;
                hour.checked = false;

                // ? If a Lessons was found
                if (hasLesson(current.date)) {
                    // * Loop the Lessons
                    lessons: for (const foundLesson of findLessons(current.date)) {
                        // ? If the current Lesson is not the same as another Teacher Lesson
                        if (lesson.id_lesson !== foundLesson.id_lesson) {
                            // * Loop the Lesson Days
                            for (const dayFromLesson of foundLesson.days) {
                                // * Loop the Day Hours
                                for (const hourFromLesson of dayFromLesson.hours) {
                                    // ? If the Hour match with a Day Hour
                                    if (hourFromLesson.id_hour === hour.id_hour && dayFromLesson.date === current.date) {
                                        // * Deactivate the Hour
                                        hour.active = false;
                                        break lessons;
                                    }
                                }
                            }
                        }
                    }
                }

                // * Loop the old clicked Hours
                for (const oldHour of hours) {
                    // ? If the new Hour match with the older Hour
                    if (oldHour.value === hour.id_hour && oldHour.date === current.date) {
                        // * Checked the Hour
                        hour.checked = true;
                    }
                }

                // * Create the <li>
                let item = new Html("li", {
                    innerHTML: [
                        ["input", {
                            props: {
                                type: type.id_type === 1 ? "radio": "checkbox",
                                name: `date-${ current.index }-hours[]`,
                                id: `date-${ current.index }-hour-${ hour.id_hour }`,
                                defaultValue: hour.id_hour,
                                dataset: {
                                    date: current.date,
                                    index: current.index,
                                },
                            }, state: {
                                id: true,
                                checked: hour.checked,
                                disabled: !hour.active,
                            }, callbacks: {
                                change: {
                                    function: addHour,
                                    params: { hour: hour },
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

                console.log(hour);
                // * Append the <li>
                list.appendChild(item.html);
            }
        }
    }

    // * Check if everything is OK
    checkHours();
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
 * * Submit form callback function
 * @param {*} params
 */
function submit (params) {
    if (document.querySelector("#input-mercadopago").checked) {
        document.querySelector("form#checkout").submit();
    }
    if (document.querySelector("#input-paypal").checked) {
        // ! PayPal does not support trigger click button event
    }
}

document.addEventListener("DOMContentLoaded", function (e) {
    if (type.id_type !== 2) {
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
        
        calendar = new InputDateMakerJS({
            lang: "es",
            availableWeekDays: enableDays,
            name: "dates[]",
            classes: ["checkout", "form-input"],
            quantity: (type.id_type === 1 ? 1 : 4),
        }, {
            enablePastDates: false,
            enableToday: false,
            generate: document.querySelector(".dropdown-main > section:first-of-type"),
            uncheck: false,
        }, {
            function: printHours,
        });

        createHours((type.id_type === 1 ? 1 : 4));
    }

    new TabMenuJS({
        id: "methods"
    }, {
        open: "mercadopago",
    }, {
        function: changeButton,
    });

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
});