// ? External repositories
import { Dropdown as DropdownJS } from "../../submodules/DropdownJS/js/Dropdown.js";
import { InputDateMaker as InputDateMakerJS } from "../../submodules/InputDateMakerJS/js/InputDateMaker.js";
import { TabMenu as TabMenuJS } from "../../submodules/TabMenuJS/js/TabMenu.js";

let dropdowns = [], enableDays = [], lessons_parsed = [ ...lessons ];

function hasLesson (date) {
    let found = false;
    for (const lesson of lessons_parsed) {
        for (const day of lesson.days) {
            if (day.date === date) {
                found = true;
            }
        }
    }
    return found;
}

function findLesson (date) {
    for (const lesson of lessons_parsed) {
        for (const day of lesson.days) {
            if (day.date === date) {
                return lesson;
            }
        }
    }
}

function comparateLessons () {
    lessons_parsed = [ ...lessons ];
    lessons_parsed[lessons.length] = {
        days: [],
    }
    for (const input of document.querySelectorAll('.dropdown .dropdown-body section:first-of-type input[type=checkbox]')) {
        if (input.name !== 'hours[]') {
            let disabledDate = input.nextElementSibling.value;
            let hour = findHour(parseInt(input.name.split('[').pop().split(']').shift()));
            hour.active = false;
            lessons_parsed[lessons.length].days.push({
                date: disabledDate,
                hour: hour,
            });
        }
    }
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

function printHours (params) {
    removeDropdowns(parseInt(params.inputDateMaker.html.parentNode.parentNode.parentNode.id.split('-')[1]));
    let lesson = false;
    document.querySelector(`#hours-${ parseInt(params.inputDateMaker.html.parentNode.parentNode.parentNode.id.split('-')[1]) }`).name = `hours[]`;
    comparateLessons();
    if (hasLesson(params.inputDateMaker.html.value)) {
        lesson = findLesson(params.inputDateMaker.html.value);
    }
    let date = parseDate(params.inputDateMaker.html.value);
    let html = params.inputDateMaker.html.parentNode.nextElementSibling.children[0];
    html.innerHTML = '';
    for (const day of days) {
        if (date.getDay() === day.day.id_day) {
            for (const hour of day.hours) {
                if (lesson) {
                    hour.active = true;
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
                    input.name = `input-${ parseInt(params.inputDateMaker.html.parentNode.parentNode.parentNode.id.split('-')[1]) }-hour`;
                    input.id = `input-${ parseInt(params.inputDateMaker.html.parentNode.parentNode.parentNode.id.split('-')[1]) }-hour-${ hour.id_hour }`;
                    input.value = hour.id_hour;
                    item.appendChild(input);
                    if (!hour.active) {
                        input.disabled = true;
                    }
        
                    let label = document.createElement('label');
                    label.classList.add('btn', 'p-3', 'color-white');
                    label.htmlFor = `input-${ parseInt(params.inputDateMaker.html.parentNode.parentNode.parentNode.id.split('-')[1]) }-hour-${ hour.id_hour }`;
                    item.appendChild(label);
                    label.addEventListener('click', function (e) {
                        removeDropdowns(parseInt(params.inputDateMaker.html.parentNode.parentNode.parentNode.id.split('-')[1]));
                        changeDate(this.htmlFor, parseInt(params.inputDateMaker.html.parentNode.parentNode.parentNode.id.split('-')[1]));
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
    if (date.getDay() !== new Date().getDay() && type.id_type === 3) {
        document.querySelector('.calendar main:not(.compressed)').classList.add;
    }
}

function changeDate (id_hour, id_hours) {
    let hour = document.querySelector(`#${ id_hour }`);
    let hours = document.querySelector(`#hours-${ id_hours }`);
    hours.name = `hours[${ hour.value }]`;
    if (type.id_type === 3) {
        changeDropdownTitle(id_hour, id_hours);
        for (const dropdown of dropdowns) {
            dropdown.close();
        }
        if (dropdowns.length < 4 && id_hours === dropdowns.length) {
            createNewDropdown();
        }
    }
}

function changeDropdownTitle (id_hour, id_hours) {
    let date = document.querySelector(`#date-${ id_hours } #input-${ id_hours }`);
    let hour = document.querySelector(`#date-${ id_hours } .hours #${ id_hour } + label span`);
    let title = document.querySelector(`#date-${ id_hours } .dropdown-button h2`);
    title.innerHTML = '';
        let span = document.createElement('span');
        span.classList.add('mr-2');
        span.innerHTML = `Fecha ${ id_hours } reservada:`;
        title.appendChild(span);
        let span2 = document.createElement('span');
        span2.classList.add('color-four', 'mr-2');
        span2.innerHTML = `${ date.value.split('-')[2] } de ${ InputDateMakerJS.months['es'][parseInt(date.value.split('-')[1]) - 1].name } del ${ date.value.split('-')[0] }`;
        title.appendChild(span2);
        let br = document.createElement('br');
        title.appendChild(br);
        let span3 = document.createElement('span');
        span3.classList.add('mr-2');
        span3.innerHTML = `Entre las`;
        title.appendChild(span3);
        let span4 = document.createElement('span');
        span4.classList.add('color-four');
        span4.innerHTML = hour.innerHTML;
        title.appendChild(span4);
}

function createNewDropdown () {
    let dropdown_old = document.querySelector(`#date-${ dropdowns.length }`);
    dropdown_old.classList.add('mb-4');
    let dropdown = document.createElement('section');
    dropdown.id = `date-${ dropdowns.length + 1 }`;
    dropdown.classList.add('calendar', 'dropdown');
    dropdown_old.parentNode.appendChild(dropdown);
        let header = document.createElement('header');
        header.classList.add('dropdown-header', 'p-4');
        dropdown.appendChild(header);
            let button = document.createElement('button');
            button.classList.add('dropdown-button', 'p-2');
            header.appendChild(button);
                let h2 = document.createElement('h2');
                h2.classList.add('flex', 'flex-wrap', 'justify-start', 'color-white');
                h2.innerHTML = 'Elige la siguiente clase';
                button.appendChild(h2);
        let main = document.createElement('main');
        main.classList.add('dropdown-body', 'grid', 'grid-cols-1', 'xl:grid-cols-3', 'xl:px-8', 'xl:gap-8');
        dropdown.appendChild(main);
            let section1 = document.createElement('section');
            section1.classList.add('m-4');
            main.appendChild(section1);
                let hours = document.createElement('input');
                hours.type = 'checkbox';
                hours.name = 'hours[]';
                hours.checked = true;
                hours.id = `hours-${ dropdowns.length + 1 }`;
                section1.appendChild(hours);

                let date = document.createElement('input');
                date.type = 'date';
                date.name = 'dates[]';
                date.id = `input-${ dropdowns.length + 1 }`;
                section1.appendChild(date);
            let section2 = document.createElement('section');
            section2.classList.add('xl:col-span-2', 'mx-4', 'mb-4', 'xl:mt-4');
            main.appendChild(section2);
                let ul = document.createElement('ul');
                ul.classList.add('hours', `hours-${ dropdowns.length + 1 }`, 'grid', 'grid-cols-2', 'md:grid-cols-3', 'gap-4');
                section2.appendChild(ul);

    // let today = new Date(document.querySelector(`#date-${ dropdowns.length } main #input-${ dropdowns.length }`).value.split('-'));
    dropdowns.push (new DropdownJS({
        id: `date-${ dropdowns.length + 1 }`,
    }, {
        open: true,
    }));
    
    new InputDateMakerJS({
        id: date.id,
        lang: 'es',
        availableWeekDays: enableDays,
    }, {
        enablePastDates: false,
        enableToday: false,
    }, {
        function: printHours,
        params: {
            //
    }});
}

function removeDropdowns (length) {
    let removes = [];
    for (const key in dropdowns) {
        if (Object.hasOwnProperty.call(dropdowns, key)) {
            const dropdown = dropdowns[key];
            if (parseInt(key) + 1 > length) {
                dropdown.html.parentNode.removeChild(dropdown.html);
                removes.push(parseInt(key));
            }
        }
    }
    for (const key of removes) {
        dropdowns.splice(key, 1);
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
    
        let calendar = new InputDateMakerJS({
            lang: 'es',
            availableWeekDays: enableDays,
        }, {
            enablePastDates: false,
            enableToday: false,
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