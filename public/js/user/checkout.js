// ? External repositories
import { Dropdown as DropdownJS } from "../../submodules/DropdownJS/js/Dropdown.js";
import { InputDateMaker as InputDateMakerJS } from "../../submodules/InputDateMakerJS/js/InputDateMaker.js";
import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";
import { Validation as ValidationJS } from "../../submodules/ValidationJS/js/Validation.js";

let dropdowns = [], enableDays = [], calendar ,hours = [];

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

function findLesson (date) {
    let lessonsToSend = [];
    for (const lesson of lessons) {
        for (const day of lesson.days) {
            if (day.date === date) {
                lessonsToSend.push(lesson);
            }
        }
    }
    return lessonsToSend;
}

function findHour (id_hour) {
    for (const day of days) {
        for (const hour of day.hours) {
            if (hour.id_hour === id_hour) {
                return hour;
            }
        }
    }
}

function parseDate (date) {
    return new Date(date.split('-'));
}

function saveHour (params, hour) {
    // console.log('new hour');
    let input = hours.shift();
    // console.log({
    //     index: (input.hasAttribute('data-index') ? input.dataset.index : undefined),
    //     date: (input.hasAttribute('data-date') ? input.dataset.date : undefined),
    // });
    // console.log('to');
    if (input.hasAttribute('data-index')) {
        if (document.querySelectorAll('ul.hours input').length) {
            for (const html of document.querySelectorAll('ul.hours input')) {
                if (parseInt(html.value) === parseInt(input.value) && html.dataset.date === input.dataset.date ) {
                    html.checked = false;
                }
            }
        }
    }
    input.dataset.date = params.clicked.date;
    let index = params.clicked.index;
    for (const hour of hours) {
        if (hour.dataset.date === params.clicked.date) {
            if (parseInt(hour.dataset.index) + 1 > index) {
                index = parseInt(hour.dataset.index) + 1;
            }
        }
    }
    input.dataset.index = index;
    input.value = hour.id_hour;
    input.checked = true;
    hours.push(input);
    // console.log({
    //     index: index,
    //     date: params.clicked.date,
    //     input: params.clicked.input,
    // });
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }
    // console.log('hours');
    // console.log([...hourValues]);
    // console.log('indexes');
    // console.log([...calendar.props.selectedIndex]);
    checkDates(params);
    addDay(params.clicked.date);
}

function addDate (params) {
    // console.log('add date');
    let date = calendar.htmls.shift();
    date.value = hours[hours.length - 1].dataset.date;
    calendar.htmls.push(date);
    let index = 1;
    for (const selected of calendar.props.selectedIndex) {
        if (index <= parseInt(selected.index)) {
            index = parseInt(selected.index) + 1;
        }
    }
    let selected = {
        index: index,
        date: date.value,
        input: params.clicked.input,
    }
    // console.log(selected);
    if (calendar.props.selectedIndex.length === calendar.props.quantity) {
        calendar.props.selectedIndex.shift();
    }
    calendar.props.selectedIndex.push(selected);
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }
    // console.log('hours');
    // console.log([...hourValues]);
    // console.log('indexes');
    // console.log([...calendar.props.selectedIndex]);
    addDay(params.clicked.date);
}

function removeDay (date) {
    // console.log('remove day');
    for (const day of calendar.days) {
        if (day.dataset.date === date) {
            if (day.classList.contains('withDate')) {
                day.classList.remove('withDate');
            }
            // console.log(day);
            day.checked = false;
            break;
        }
    }
}

function addDay (date) {
    // console.log('add day');
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }
    for (const day of calendar.days) {
        if (day.dataset.date === date) {
            for (const hourValue of hourValues) {
                if (hourValue.date === day.dataset.date) {
                    if (!day.classList.contains('withDate')) {
                        day.classList.add('withDate');
                    }
                }
            }
            // console.log(day);
            day.checked = true;
            break;
        }
    }
}

function removeDate (params) {
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
    let remove = 0, selected;
    for (const key of keys) {
        selected = calendar.props.selectedIndex.splice((key - remove), 1)[0];
        // console.log('remove date');
        // console.log(selected);
        for (const html of [...calendar.htmls]) {
            if (html.value === selected.date) {
                let date = calendar.htmls.splice((key - remove), 1)[0];
                date.value = null;
                calendar.htmls.push(date);
                break;
            }
        }
        remove++;
    }
    if (remove) {
        let found = false;
        for (const hour of hours) {
            if (parseInt(hour.dataset.index) === selected.index && hour.dataset.date === selected.date) {
                removeHour(selected);
                continue;
            }
            if (hour.dataset.date === selected.date) {
                found = true;
            }
        }
        if (!found) {
            removeDay(selected.date);
        }
        addDate(params);
    }
}

function checkDates (params) {
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }
    let dateValues = [];
    for (const selected of calendar.props.selectedIndex) {
        dateValues.push(selected);
    }
    if (hourValues.length > dateValues.length) {
        addDate(params);
    } else if (hourValues.length > 1) {
        if (hourValues.length === 4) {
            removeDate(params);
        }
    }
}

function removeHour (selected) {
    // console.log('remove hour');
    // console.log(selected);
    let hour, keys = [];
    for (const key in [...hours]) {
        if (Object.hasOwnProperty.call(hours, key)) {
            hour = hours[key];
            if (hour.dataset.date === selected.date && parseInt(hour.dataset.index) === parseInt(selected.index)) {
                keys.push(key);
                break;
            }
        }
    }
    let remove = 0;
    for (const key of keys) {
        hours.splice((key - remove), 1);
        remove++;
    }
    hour.value = null;
    hour.removeAttribute('data-date');
    hour.removeAttribute('data-index');
    hour.checked = false;
    hours.unshift(hour);
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }
    // console.log('hours');
    // console.log([...hourValues]);
    // console.log('indexes');
    // console.log([...calendar.props.selectedIndex]);
    let found = false;
    for (const hour of hours) {
        if (hour.dataset.date === selected.date) {
            found = true;
            break;
        }
    }
    if (!found) {
        removeDay(selected.date);
    }
    for (const input of [...document.querySelectorAll('ul.hours input')]) {
        if (parseInt(input.dataset.index) === parseInt(selected.index) && input.dataset.date === selected.date) {
            input.checked = false;
        }
    }
}

function sort () {
    return function (a, b) {
        let aKey = 0, bKey = 0, found = false;
        for (aKey in calendar.props.selectedIndex) {
            if (Object.hasOwnProperty.call(calendar.props.selectedIndex, aKey)) {
                const selected = calendar.props.selectedIndex[aKey];
                if (a.dataset.date === selected.date && parseInt(selected.index) === parseInt(a.dataset.index)) {
                    found = true;
                    break;
                }
            }
        }
        if (!found) {
            aKey = 0;
        }
        found = false;
        for (bKey in calendar.props.selectedIndex) {
            if (Object.hasOwnProperty.call(calendar.props.selectedIndex, bKey)) {
                const selected = calendar.props.selectedIndex[bKey];
                if (b.dataset.date === selected.date && parseInt(selected.index) === parseInt(b.dataset.index)) {
                    found = true;
                    break;
                }
            }
        }
        if (!found) {
            bKey = 0;
        }
        if (aKey > bKey) {
            return 1;
        }
        if (aKey < bKey) {
            return -1;
        }
        return 0;
    }
}

function orderHours (params) {
    // console.log('order hours');
    hours.sort(sort());
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
                input: hour,
            });
        }
    }
    // console.log('hours');
    // console.log([...hourValues]);
    // console.log('indexes');
    // console.log([...calendar.props.selectedIndex]);
}

function checkHours (params) {
    let hourValues = [];
    for (const hour of hours) {
        if (hour.value) {
            hourValues.push({
                index: parseInt(hour.dataset.index),
                date: hour.dataset.date,
            });
        }
    }
    let dateValues = [];
    for (const selected of calendar.props.selectedIndex) {
        dateValues.push(selected);
    }
    if (hourValues.length >= 1) {
        hours: for (const hourValue of hourValues) {
            for (const dateValue of dateValues) {
                if (dateValue.date === hourValue.date && dateValue.index === hourValue.index) {
                    continue hours;
                }
            }
            removeHour(hourValue);
        }
    }
    orderHours(params);
}

function printHours (params) {
    let list = params.inputDateMaker.htmls[0].parentNode.nextElementSibling.children[0];
    list.innerHTML = '';
    if (params.clicked.state) {
        if (params.dates.length) {
            checkHours(params);
            let lessons = false;
            if (hasLesson(params.clicked.date)) {
                lessons = findLesson(params.clicked.date);
            }
            let date = parseDate(params.clicked.date);
            for (const day of days) {
                if (date.getDay() === day.day.id_day) {
                    for (const hour of day.hours) {
                        if (lessons) {
                            hour.active = true;
                            lessons: for (const lesson of lessons) {
                                for (const dayFromLesson of lesson.days) {
                                    for (const hourFromLesson of dayFromLesson.hours) {
                                        if (hourFromLesson.id_hour === hour.id_hour && dayFromLesson.date === params.clicked.date) {
                                            hour.active = false;
                                            break lessons;
                                        }
                                    }
                                }
                            }
                        }
                        if (!lessons) {
                            hour.active = true;
                        }
                        let item = document.createElement('li');
                        list.appendChild(item);
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
                            for (const hour of hours) {
                                if (hour.value) {
                                    if (hour.value === input.value && hour.dataset.date === input.dataset.date) {
                                        input.checked = true;
                                        if (parseInt(hour.dataset.index) !== parseInt(params.clicked.index)) {
                                            input.dataset.index = hour.dataset.index;
                                        }
                                    }
                                }
                            }
                            if (!hour.active) {
                                input.disabled = true;
                            }
                            input.addEventListener('change', function (e) {
                                saveHour(params, hour);
                            });
                
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

document.addEventListener('DOMContentLoaded', function (e) {
    dropdowns.push(new DropdownJS({
        id: 'date-1',
    }, {
        open: true,
    }));

    if (type.id_type !== 2) {
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
            params: {}
        });

        createHours((type.id_type === 1 ? 1 : 4));
    }

    new TabMenuJS({
        id: 'methods'
    }, {
        open: 'mercadopago',
    });

    validation.checkout.ValidationJS = new ValidationJS({
        id: 'checkout',
        rules: validation.checkout.rules,
        messages: validation.checkout.messages,
    });
});