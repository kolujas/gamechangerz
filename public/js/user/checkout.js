// ? External repositories
import { Dropdown as DropdownJS } from "../../submodules/DropdownJS/js/Dropdown.js";
import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { InputDateMaker as InputDateMakerJS } from "../../submodules/InputDateMakerJS/js/InputDateMaker.js";
import { Notification as NotificationJS } from "../../submodules/NotificationJS/js/Notification.js";
import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";
import { Validation as ValidationJS } from "../../submodules/ValidationJS/js/Validation.js";

import Asset from "../components/Asset.js";
import Token from "../components/Token.js";

let calendar = false, hours = [], lessons = [], paypalActions;
const token = Token.get();

paypal_sdk.Buttons({
    onInit: function(data, actions) {
        if (parseInt(type.id_type) !== 2 ) {

        }
        actions.disable();
        paypalActions = actions;
    },
    style: {
        layout: 'horizontal',
        tagline: false,
        size: 'responsive',
    },
    createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    value: type.price,
                }, custom_id: lesson.id_lesson,
            }]
        });
    }, onApprove: function (data, actions) {
        return actions.order.capture().then((details) => {
            document.querySelector('form#checkout').submit();
        });
}}).render('.cho-container');

function dd (params) {
    switch (params.opened) {
        case 'mercadopago':
            document.querySelector('.cho-container .btn').style.display = 'flex';
            document.querySelector('.cho-container .paypal-buttons').style.display = 'none';
            break;
        case 'paypal':
            document.querySelector('.cho-container .btn').style.display = 'none';
            document.querySelector('.cho-container .paypal-buttons').style.display = 'block';
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
                document.querySelector('form#checkout').submit();
            });
    }}).render('#paypal main');
}

/**
 * * Updates a the current Lesson.
 */
async function updateLesson () {
    // * Set the FormData
    let formData = new FormData();
    let hours = [];
    for (const input of document.querySelectorAll('input[name="hours[]"]')) {
        hours.push(input.value);
    }
    formData.set('hours', hours);
    let dates = [];
    for (const input of document.querySelectorAll('input[name="dates[]"]')) {
        dates.push(input.value);
    }
    formData.set('dates', dates);

    // * Send the Query
    let query = await Fetch.send({
        url: `/api/lessons/${ lesson.id_lesson }/update`,
        method: 'put'
    }, {
        'Accept': 'application/json',
        'Authorization': "Bearer " + token.data,
        'Content-type': 'application/json; charset=UTF-8',
    }, formData);

    // ? If the response throws success
    if (query.response.code === 200) {
        // createPayPal();
    }

    // ? If the response throws error
    if (query.response.code === 500) {
        // TODO: Throw notification & go back to the previous step
    }
}

/**
 * * Add an Hour.
 * @param {*} params
 * @param {*} hour
 */
 async function addHour (params, hour) {
    // * Disable PayPal
    paypalActions.disable();

    // * Check if an Hour was used
    let formData = new FormData();
    formData.set('date', params.clicked.date);
    formData.set('id_type', type.id_type);
    formData.set('id_hour', hour.id_hour);
    let query = await Fetch.send({
        url: `/api/users/${ slug }/lessons`,
        method: 'post'
    }, {
        'Accept': 'application/json',
        'Authorization': "Bearer " + token.data,
        'Content-type': 'application/json; charset=UTF-8',
    }, formData);

    // ? If the query success
    if (query.response.code === 200) {
        // ? If the Hour was not used
        if (!query.response.found) {
            // * Get the last Hour <input>
            let input = hours.shift();

            // ? If the <input> was selected
            if (input.hasAttribute('data-index')) {
                // ? If there are Calendar Hours
                if (document.querySelectorAll('ul.hours input').length) {
                    // * Loop the Calendar Hours
                    for (const html of document.querySelectorAll('ul.hours input')) {
                        // ? If the Calendar Hour match with the Hour <input>
                        if (parseInt(html.value) === parseInt(input.value) && html.dataset.date === input.dataset.date ) {
                            // * Unchecked the Calendar Hour
                            html.checked = false;
                        }
                    }
                }
            }

            // * Get the selected index
            let index = params.clicked.index;

            // * Loop the Hours
            for (const aux of hours) {
                // ? If an Hour match with the selected
                if (aux.dataset.date === params.clicked.date && parseInt(aux.dataset.index) + 1 > index) {
                    // * Creates a new selected index
                    index = parseInt(aux.dataset.index) + 1;
                }
            }

            // * Replace the Hour params
            input.dataset.date = params.clicked.date;
            input.dataset.index = index;
            input.value = hour.id_hour;
            input.checked = true;

            // * Add the new Hour <input>
            hours.push(input);

            // * Check the Dates
            checkDates(params);

            // * Active the Day
            activeDay(params.clicked.date);

            // * Get the Hours
            let hourValues = [];
            for (const hour of hours) {
                if (hour.value) {
                    hourValues.push({
                        index: parseInt(hour.dataset.index),
                        date: hour.dataset.date,
                    });
                }
            }

            // ? If the qunatity of Hours is valid
            if (hourValues.length === calendar.props.quantity) {
                // * Update the Lesson
                updateLesson();
            }
        }

        // ? If the Hour was used
        if (query.response.found) {
            new NotificationJS({
                code: 403,
                message: `La fecha seleccionada ya se encuentra en uso`,
                classes: ['russo'],
            }, {
                open: true,
            });

            // * Remove Hour if does not match with any Date
            removeHour({
                index: parseInt(params.clicked.index),
                date: params.clicked.date,
            });
        }
    }

    // * Check PayPal state
    checkPayPalState();
}

/**
 * * Add a Date
 * @param {*} params
 */
function addDate (params) {
    // * Get the last Date
    let date = calendar.htmls.shift();

    // * Repalce the Date params
    date.value = hours[hours.length - 1].dataset.date;

    // * Add the new Date <input>
    calendar.htmls.push(date);

    // * Get a new Index
    let index = 1;
    for (const selected of calendar.props.selectedIndex) {
        if (index <= parseInt(selected.index)) {
            index = parseInt(selected.index) + 1;
        }
    }

    // * Create a new selectged object
    let selected = {
        index: index,
        date: date.value,
        input: params.clicked.input,
    }

    // ? If there are 4 Calendar selected Dates
    if (calendar.props.selectedIndex.length === calendar.props.quantity) {
        // * Remove a selected Date
        calendar.props.selectedIndex.shift();
    }

    // * Add the new selected object
    calendar.props.selectedIndex.push(selected);

    // * Active the Day
    activeDay(params.clicked.date);
}

/**
 * * Activate a Day
 * @param {string} date
 */
function activeDay (date) {
    // * Get the Hours
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }

    // * Loop the Days
    for (const day of calendar.days) {
        // ? If the Day match with the selected Date
        if (day.dataset.date === date) {
            // * Loop the Hours
            for (const hourValue of hourValues) {
                // ? If the Day match with the Hour
                if (hourValue.date === day.dataset.date) {
                    // * Add className
                    if (!day.classList.contains('withDate')) {
                        day.classList.add('withDate');
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
    // * Loop the Days
    for (const day of calendar.days) {
        // ? If the Day Date match with the selected Date 
        if (day.dataset.date === date) {
            // * Unchecked
            if (day.classList.contains('withDate')) {
                day.classList.remove('withDate');
            }
            day.checked = false;
            break;
        }
    }
}

/**
 * * Remove a Date
 * @param {*} params
 */
function removeDate (params) {
    // * Get the removed Date keys
    let keys = [];
    indexes: for (const key in [...calendar.props.selectedIndex]) {
        if (Object.hasOwnProperty.call(calendar.props.selectedIndex, key)) {
            const selected = calendar.props.selectedIndex[key];
            for (const hour of [...hours]) {
                if (parseInt(hour.dataset.index) === parseInt(selected.index) && selected.date === hour.dataset.date) {
                    continue indexes;
                }
            }
            keys.push(key);
        }
    }

    // * Loop the removed Date keys
    let remove = 0, selecteds = [];
    for (const key of keys) {
        // * Get & remove a Calendar selected object
        let selected = calendar.props.selectedIndex.splice((key - remove), 1)[0];
        selecteds.push(selected);

        // * Loop the Calendar Dates
        for (const html of [...calendar.htmls]) {
            // ? If a Date match with the selected object removed
            if (html.value === selected.date) {
                // * Clean the Calendar Date <input>
                let date = calendar.htmls.splice((key - remove), 1)[0];
                date.value = null;
                calendar.htmls.push(date);
                break;
            }
        }
        remove++;
    }

    // ? If there was a removed object
    if (remove) {
        // * Loop the Hours
        let found = false;
        hours: for (const hour of hours) {
            // * Loop the Calendar removed selected objects
            for (const selected of selecteds) {
                // ? If an Hour match with a selected object removed
                if (parseInt(hour.dataset.index) === selected.index && hour.dataset.date === selected.date) {
                    // * Remove an Hour
                    removeHour(selected);
                    continue hours;
                }
                // ? If an Hour Date match with a selected object removed Date
                if (hour.dataset.date === selected.date) {
                    // * Set found
                    found = true;
                }
            }
        }

        // ? If not found
        if (!found) {
            // * Deactivate a Day
            deactiveDay(selected.date);
        }

        // * Add a Date
        addDate(params);
    }
}

/**
 * * Check the Dates.
 * @param {*} params
 */
function checkDates (params) {
    // * Get the Hours
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }

    // * Get the Dates
    let dateValues = [];
    for (const selected of calendar.props.selectedIndex) {
        dateValues.push(selected);
    }

    // ? If the Hours are more than the Dates
    if (hourValues.length > dateValues.length) {
        // * Add a Date
        addDate(params);
    // ? If there are more than 1 Hours
    } else if (hourValues.length > 1) {
        // ? If there are 4 Hours
        if (hourValues.length === 4) {
            // * Remove a Date
            removeDate(params);
        }
    }
}

/**
 * * Remove an Hour.
 * @param {object} selected
 */
function removeHour (selected) {
    // * Loop the Hours
    let hour, key = false;
    for (key in [...hours]) {
        if (Object.hasOwnProperty.call(hours, key)) {
            hour = hours[key];
            // ? The Hour match with the one who has to be removed
            if (hour.dataset.date === selected.date && parseInt(hour.dataset.index) === parseInt(selected.index)) {
                // * Break the loop
                break;
            }
            key = false;
        }
    }

    // ? If an Hour has to be removed
    if (key) {
        // * Remove Hour
        hour.value = null;
        hour.removeAttribute('data-date');
        hour.removeAttribute('data-index');
        hour.checked = false;
        hours.unshift(hour);

        // * Loop <inputs>
        for (const input of [...document.querySelectorAll('ul.hours input')]) {
            // ? If the <input> match with the selected
            if (parseInt(input.dataset.index) === parseInt(selected.index) && input.dataset.date === selected.date) {
                // * Unchecked
                input.checked = false;
            }
        }
    }

    // * Check if there is another Date selected
    let found = false;
    for (const hour of hours) {
        if (hour.dataset.date === selected.date) {
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
                if (a.dataset.date === selected.date && parseInt(selected.index) === parseInt(a.dataset.index)) {
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
                if (b.dataset.date === selected.date && parseInt(selected.index) === parseInt(b.dataset.index)) {
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
 * * Check if the Hours are clicked.
 * @param {*} params
 */
function checkHours (params) {
    // * Get the Hours
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }

    // * Get the Dates
    let dateValues = [];
    for (const selected of calendar.props.selectedIndex) {
        dateValues.push(selected);
    }

    // ? There are Hours
    if (hourValues.length >= 1) {
        // * Loop the Hours
        hours: for (const hourValue of hourValues) {
            // * Loop the Dates
            for (const dateValue of dateValues) {
                // ? The Hour match with a Date
                if (dateValue.date === hourValue.date && dateValue.index === hourValue.index) {
                    // * Continue
                    continue hours;
                }
            }

            // * Remove Hour if does not match with any Date
            removeHour(hourValue);
        }
    }

    // TODO: Check lessons

    // * Check PayPal state
    checkPayPalState();

    // * Sort the Hours
    hours.sort(sort());
}

/**
 * * Check if the PayPal has to be enable or not.
 */
function checkPayPalState () {
    // * Get the Hours
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }

    // * Get the Dates
    let dateValues = [];
    for (const selected of calendar.props.selectedIndex) {
        dateValues.push(selected);
    }
    
    // ? If the quantity of Dates & Hours is less than the correct one
    if (dateValues.length < calendar.props.quantity && hourValues.length < calendar.props.quantity) {
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
    // * Clear the <ul> Hours
    let list = params.inputDateMaker.htmls[0].parentNode.nextElementSibling.children[0];
    list.innerHTML = '';

    // * Disable PayPal
    paypalActions.disable();

    // * Search the Lessons
    let query = await Fetch.get(`/api/users/${ slug }/lessons`);
    list.innerHTML = '';

    // ? If the query success
    if (query.response.code === 200) {
        lessons = query.response.data.lessons;
        // ? Date clicked
        if (params.clicked.state) {
            // ? There are dates
            if (params.dates.length) {
                // * Check the Hours
                checkHours(params);

                // * Find Lessons
                let foundLessons = false;
                if (hasLesson(params.clicked.date)) {
                    foundLessons = findLessons(params.clicked.date);
                }

                // * Parse the selected Date
                let date = new Date(params.clicked.date.split('-'));

                // * Loop the Days
                for (const day of days) {
                    // ? If the Date Day match with a Day
                    if (date.getDay() === day.day.id_day) {
                        // * Loop the Hours
                        for (const hour of day.hours) {
                            // * Activate the Hour
                            hour.active = true;

                            // ? If a Lessons was found
                            if (foundLessons) {
                                // * Loop the Lessons
                                lessons: for (const foundLesson of foundLessons) {
                                    // * Loop the Lesson Days
                                    for (const dayFromLesson of foundLesson.days) {
                                        // * Loop the Day Hours
                                        for (const hourFromLesson of dayFromLesson.hours) {
                                            // ? If the Hour match with a Day Hour
                                            if (hourFromLesson.id_hour === hour.id_hour && dayFromLesson.date === params.clicked.date) {
                                                // * Deactivate the Hour
                                                hour.active = false;
                                                break lessons;
                                            }
                                        }
                                    }
                                }
                            }
                            
                            // * Create the Hour <li>
                            let item = document.createElement('li');
                            list.appendChild(item);
                                // * Create the Hour <input>
                                let input = document.createElement('input');
                                if (type.id_type === 1) {
                                    input.type = 'radio';
                                }
                                if (type.id_type === 3) {
                                    input.type = 'checkbox';
                                }
                                input.name = `date-${ params.clicked.index }-hours[]`;
                                input.id = `date-${ params.clicked.index }-hour-${ hour.id_hour }`;
                                input.value = hour.id_hour;
                                input.dataset.date = params.clicked.date;
                                input.dataset.index = params.clicked.index;
                                item.appendChild(input);

                                // * Loop the Hours
                                for (const hour of hours) {
                                    // ? If an Hour was selected
                                    if (hour.value) {
                                        // ? If the new Hour match with the older Hour
                                        if (hour.value === input.value && hour.dataset.date === input.dataset.date) {
                                            // * Checked the Hour <input>
                                            input.checked = true;

                                            // ? If the older Hour Date does not match with the selected Date
                                            if (parseInt(hour.dataset.index) !== parseInt(params.clicked.index)) {
                                                // * Replace the Date
                                                input.dataset.index = hour.dataset.index;
                                            }
                                        }
                                    }
                                }

                                // ? If the Hour was not activated
                                if (!hour.active) {
                                    // * Disabled the Hour <input>
                                    input.disabled = true;
                                }

                                // * Set the <input> change event
                                input.addEventListener('change', function (e) {
                                    // * Save the Hour
                                    addHour(params, hour);
                                });
                    
                                // * Create the Hour <label>
                                let label = document.createElement('label');
                                label.classList.add('btn', 'btn-four', 'btn-outline', 'color-white');
                                label.htmlFor = `date-${ params.clicked.index }-hour-${ hour.id_hour }`;
                                item.appendChild(label);
                                    let span = document.createElement('span');
                                    label.appendChild(span);
                                    span.classList.add('py-2', 'px-4');
                                    span.innerHTML = `${ hour.from } - ${ hour.to }`;
                        }
                    }
                }
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
        let input = document.createElement('input');
        input.type = 'checkbox';
        input.name = `hours[]`;
        input.value = null;
        input.classList.add('form-input');
        document.querySelector('div.hours').appendChild(input);
        hours.push(input);
    }
}

/**
 * * Submit form callback function
 * @param {*} params
 */
function submit (params) {
    if (document.querySelector('#input-mercadopago').checked) {
        document.querySelector('form#checkout').submit();
    }
    if (document.querySelector('#input-paypal').checked) {
        // ! PayPal does not support trigger click button event
    }
}

document.addEventListener('DOMContentLoaded', function (e) {
    if (type.id_type !== 2) {
        new DropdownJS({
            id: 'date-1',
        }, {
            open: true,
        });

        let enableDays = [];
        for (const day of days) {
            enableDays.push(day.day.id_day);
        }
        
        calendar = new InputDateMakerJS({
            lang: 'es',
            availableWeekDays: enableDays,
            name: 'dates[]',
            classes: ['form-input'],
            quantity: (type.id_type === 1 ? 1 : 4),
        }, {
            enablePastDates: false,
            enableToday: false,
            generate: document.querySelector('.dropdown-main > section:first-of-type'),
            uncheck: false,
        }, {
            function: printHours,
        });

        createHours((type.id_type === 1 ? 1 : 4));
    }

    new TabMenuJS({
        id: 'methods'
    }, {
        open: 'mercadopago',
    }, {
        function: dd,
    });

    validation.checkout.ValidationJS = new ValidationJS({
        id: 'checkout',
        rules: validation.checkout.rules,
        messages: validation.checkout.messages,
    }, {
        submit: false
    }, {
        submit: {
            function: submit,
        }
    });
});