import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";
import User from "./User.js";

function refreshList () {
    $('.filter-pagination').pagination({
        dataSource: users,
        pageSize: 10,
        autoHidePrevious: true,
        autoHideNext: true,
        callback: function (data, pagination) {
            if (URL.findOriginalRoute() === '/users') {
                updateUsersList({data, pagination});
            }
            if (URL.findOriginalRoute() === '/teachers') {
                updateTeachersList({data, pagination});
            }
        }
    });
}

function addUser (user) {
    let list = document.querySelector('.users + .list');
    list.appendChild(User.generateComponent('user', user));
}

function addTeacher (user) {
    
}

function updateUsersList (params) {
    document.querySelector('.users + .list').innerHTML = '';
    for (const user of params.data) {
        addUser(user);
    }
}

function updateTeachersList (params) {
    document.querySelector('.teachers + .list').innerHTML = '';
    for (const user of params.data) {
        addTeacher(user);
    }
}

async function getUsers (role = 0) {
    let query;
    switch (role) {
        case 0:
            query = await Fetch.get(`/api/users`, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
            });
            if (query.response.code === 200) {
                users = query.response.data.users;
                refreshList();
            }
            break;
        case 1:
            query = await Fetch.get(`/api/teachers`, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
            });
            if (query.response.code === 200) {
                users = query.response.data.users;
                refreshList();
            }
            break;
    }
}

document.addEventListener('DOMContentLoaded', function (e) {
    if (URL.findOriginalRoute() === '/teachers') {
        getUsers(1);
    }
    $('.filter-pagination').pagination({
        dataSource: users,
        pageSize: 10,
        autoHidePrevious: true,
        autoHideNext: true,
    });
});