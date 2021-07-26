import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import Filter from "../../submodules/FilterJS/js/Filter.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";

import User from "../components/User.js";

let filter;

function makePages (data) {
    if (data.current.length) {
        $(".filter-pagination").pagination({
            dataSource: data.current,
            pageSize: 10,
            autoHidePrevious: true,
            autoHideNext: true,
            callback: function (data, pagination) {
                if (URL.findOriginalRoute() === "/users") {
                    updateUsersList(data);
                }
                if (URL.findOriginalRoute() === "/teachers") {
                    updateTeachersList(data);
                }
            }
        });
    }
    if (!data.current.length) {
        if (URL.findOriginalRoute() === "/users") {
            if (document.querySelector(".filter-pagination")) {
                document.querySelector(".filter-pagination").innerHTML = "";
            }
            updateUsersList(data);
        }
        if (URL.findOriginalRoute() === "/teachers") {
            if (document.querySelector(".filter-pagination")) {
                document.querySelector(".filter-pagination").innerHTML = "";
            }
            updateTeachersList(data);
        }
    }
}

function addUser (user) {
    let list = document.querySelector(".users + .list");
    list.appendChild(User.component("user", user));
}

function addTeacher (user) {
    let list = document.querySelector(".teachers + .list ul");
    list.appendChild(User.component("teacher", user));
}

function updateUsersList (data) {
    let list = document.querySelector(".users + .list");
    list.innerHTML = "";
    if (data.length) {
        for (const user of data) {
            addUser(user);
        }
    }
    if (!data.length) {
        let item = document.createElement("li");
        item.innerHTML = "No hay usuarios que mostrar";
        item.classList.add("col-span-10", "w-full", "text-center");
        list.appendChild(item);
    }
}

function updateTeachersList (data) {
    let list = document.querySelector(".teachers + .list ul");
    list.innerHTML = "";
    if (data.length) {
        for (const user of data) {
            addTeacher(user);
        }
    }
    if (!data.length) {
        let item = document.createElement("li");
        item.innerHTML = "No hay usuarios que mostrar";
        list.appendChild(item);
    }
}

function createUsersFilter () {
    let value = document.querySelector("input[type=search].filter-input").value;
    filter = new Filter({
        id: "filter-users",
        limit: 10,
        order: {
            "stars": "DESC",
            "lessons-done": { value: "DESC", active: false },
            "username": "ASC",
        }, rules: {
            "username|name" : value ? { values: [{ regex: value }] } : null,
            "teammate": null,
        },
    }, {}, {
        run: {
            function: makePages,
        }
    }, users);
    filter.run();
}

function createTeachersFilter () {
    let value = document.querySelector("input[type=search].filter-input").value;
    let max = 0, min = 0;
    for (const user of users) {
        for (const price of user.prices) {
            if (!min) {
                min = parseInt(price.price);
            }
            if (!max) {
                max = parseInt(price.price);
            }
            if (max < parseInt(price.price)) {
                max = parseInt(price.price);
            }
            if (min > parseInt(price.price)) {
                min = parseInt(price.price);
            }
        }
    }
    for (const input of document.querySelectorAll(".range-slider input")) {
        if (input.name === "min-price") {
            input.value = min;
        }
        if (input.name === "max-price") {
            input.value = max;
        }
        input.max = max;
        input.min = min;
    }
    changeText();
    filter = new Filter({
        id: "filter-teachers",
        limit: 10,
        order: {
            "important": "DESC",
            "stars": "DESC",
            "prices:*.price": { value: "ASC", active: false },
            "username": "ASC",
        }, rules: {
            "username|name": { values: [{ regex: value }] },
            "games:*.slug": null,
            "prices:*.price": { comparator: "><", strict: false },
            "days:*.hours:*.time": { strict: false },
        },
    }, {}, {
        run: {
            function: makePages,
        }
    }, users);
    filter.run();
}

async function getUsers (role = 0) {
    let query;
    switch (role) {
        case 0:
            query = await Fetch.get(`/api/users`, {
                "Accept": "application/json",
                "Content-type": "application/json; charset=UTF-8",
            });
            if (query.response.code === 200) {
                users = query.response.data.users;
                createUsersFilter();
            }
            break;
        case 1:
            query = await Fetch.get(`/api/teachers`, {
                "Accept": "application/json",
                "Content-type": "application/json; charset=UTF-8",
            });
            if (query.response.code === 200) {
                users = query.response.data.users;
                createTeachersFilter();
            }
            break;
    }
}

/**
 * * Change slider text values.
 */
function changeText () {
    // * Get bar inputs
    let minBar = document.querySelector(".range-slider input.range-slider-bar.min");
    let maxBar = document.querySelector(".range-slider input.range-slider-bar.max");

    // * Get text inputs
    let minText = document.querySelector(".range-slider input.range-slider-text.min");
    let maxText = document.querySelector(".range-slider input.range-slider-text.max");

    // * Get values
    let minValue = parseFloat(minBar.value);
    let maxValue = parseFloat(maxBar.value);

    // * Determine which is larger
    if (minValue > maxValue) {
        // * Save temporally the larger
        let tmp = {
            name: maxBar.name,
            value: maxValue
        };

        // * Replace the second slide
        maxBar.name = minBar.name;
        maxValue = minValue;
        
        // * Replace the first slide
        minBar.name = tmp.name;
        minValue = tmp.value; 
    }
    
    // * Put the text
    maxText.max = maxValue;
    maxText.min = minValue;
    maxText.value = maxValue;
    minText.max = maxValue;
    minText.min = minValue;
    minText.value = minValue;

    changeTextWidth();
}

/**
 * * Change slider bar values.
 */
function changeBar () {
    // * Get bar inputs
    let minBar = document.querySelector(".range-slider input.range-slider-bar.min");
    let maxBar = document.querySelector(".range-slider input.range-slider-bar.max");

    // * Get text inputs
    let minText = document.querySelector(".range-slider input.range-slider-text.min");
    let maxText = document.querySelector(".range-slider input.range-slider-text.max");

    // * Change the bar inputs value
    minBar.value = minText.value;
    maxBar.value = maxText.value;

    changeTextWidth();
}

function changeTextWidth () {
    for (const input of document.querySelectorAll(".range-slider .range-slider-text")) {
        let label = document.querySelector(`.range-slider label[for="${ input.id }"]`);
        label.innerHTML = input.value;
        input.setAttribute("style", `--width: ${ label.offsetWidth }px`);
    }
}

document.addEventListener("DOMContentLoaded", function (e) {
    if (URL.findOriginalRoute() === "/users") {
        getUsers(0);
    }
    if (URL.findOriginalRoute() === "/teachers") {
        getUsers(1);

        // * Apply Sliders events
        for (const input of document.querySelectorAll(".range-slider input.range-slider-bar")) {
            input.addEventListener("input", function(){
                changeText();
            })
        }
        for (const input of document.querySelectorAll(".range-slider input.range-slider-text")) {
            input.addEventListener("input", function(){
                changeBar();
            })
        }
    
        // * Set default values
        changeText();
    }
});