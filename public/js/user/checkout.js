// ? External repositories
import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";
import { InputDateMaker as InputDateMakerJS } from "../../submodules/InputDateMakerJS/js/InputDateMaker.js";

function hasLesson (date) {
    let found = false;
    for (const lesson of lessons) {
        for (const day of lesson.days) {
            if (day.date === date) {
                found = true;
            }
        }
    }
    return found;
}

function findLesson (date) {
    for (const lesson of lessons) {
        for (const day of lesson.days) {
            if (day.date === date) {
                return lesson;
            }
        }
    }
}

function parseDate (date) {
    date = new Date(date.split('-'));
    return date.getDay();
}

function printHours (params) {
    let lesson = false;
    if (hasLesson(params.inputDateMaker.html.value)) {
        lesson = findLesson(params.inputDateMaker.html.value);
    }
    let date = parseDate(params.inputDateMaker.html.value);
    let html = document.querySelector('.hours');
    html.innerHTML = '';
    for (const day of days) {
        if (date === day.day.id_day) {
            for (const hour of day.hours) {
                if (lesson) {
                    for (const dayFromLesson of lesson.days) {
                        if (dayFromLesson.hour.id_hour === hour.id_hour && dayFromLesson.date === params.inputDateMaker.html.value) {
                            hour.active = false;
                        }
                    }
                } else {
                    hour.active = true;
                }
                let item = document.createElement('li');
                html.appendChild(item);
                    let input = document.createElement('input');
                    input.type = 'radio';
                    input.name = 'hour';
                    input.id = `hour-${ hour.id_hour }`;
                    input.value = hour.id_hour;
                    item.appendChild(input);
                    if (!hour.active) {
                        input.disabled = true;
                    }
        
                    let label = document.createElement('label');
                    label.classList.add('btn', 'p-3', 'color-white');
                    label.htmlFor = `hour-${ hour.id_hour }`;
                    item.appendChild(label);
                    label.addEventListener('click', function (e) {
                        changeDate(this.htmlFor);
                    });
                        let span = document.createElement('span');
                        label.appendChild(span);
                        span.classList.add('mr-2');
                        span.innerHTML = `${ hour.from } - ${ hour.to }`;
            }
        }
    }
    if (!html.innerHTML) {
        let li = document.createElement('li');
        li.classList.add('col-span-2', 'md:col-span-3');
        html.appendChild(li);
            let p = document.createElement('p');
            li.classList.add('color-white');
            p.innerHTML = 'No se encontraron horas para el día de hoy.';
            li.appendChild(p);
    }
    if (date !== new Date().getDay() && type.id_type === 3) {
        document.querySelector('.calendar main:not(.compressed)').classList.add;
    }
}

function changeDate (id) {
    let value = document.querySelector(`input[id=${ id }]`).value;
    document.querySelector('#hours').value = value;
}

document.addEventListener('DOMContentLoaded', function (e) {
    if (type.id_type !== 2) {
        let enableDays = [];
        for (const day of days) {
            enableDays.push(day.day.id_day);
        }
    
        let calendar = new InputDateMakerJS({
            id: 'calendar-1',
            lang: 'es',
            availableWeekDays: enableDays,
        }, {
            enablePastDates: false,
        }, {
            function: printHours,
            params: {
                //
        }});
    }

    let tab = new TabMenuJS({
        id: 'methods'
    }, {
        open: ['skins'],
    });
});