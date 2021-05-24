import { Filter as FilterJS} from "../../submodules/FilterJS/js/Filter.js";
import { FetchServiceProvider as Fetch } from "../../submodules/ProvidersJS/js/FetchServiceProvider.js";
import { URLServiceProvider as URL } from "../../submodules/ProvidersJS/js/URLServiceProvider.js";
import User from "./User.js";

let filter;

function makePages (data) {
    if (data.current.length) {
        $('.filter-pagination').pagination({
            dataSource: data.current,
            pageSize: 10,
            autoHidePrevious: true,
            autoHideNext: true,
            callback: function (data, pagination) {
                if (URL.findOriginalRoute() === '/users') {
                    updateUsersList(data);
                }
                if (URL.findOriginalRoute() === '/teachers') {
                    updateTeachersList(data);
                }
            }
        });
    }
    if (!data.current.length) {
        if (URL.findOriginalRoute() === '/users') {
            if (document.querySelector('.filter-pagination')) {
                document.querySelector('.filter-pagination').innerHTML = '';
            }
            updateUsersList(data);
        }
        if (URL.findOriginalRoute() === '/teachers') {
            if (document.querySelector('.filter-pagination')) {
                document.querySelector('.filter-pagination').innerHTML = '';
            }
            updateTeachersList(data);
        }
    }
}

function addUser (user) {
    let list = document.querySelector('.users + .list');
    list.appendChild(User.generateComponent('user', user));
}

function addTeacher (user) {
    let list = document.querySelector('.teachers + .list ul');
    list.appendChild(User.generateComponent('teacher', user));
}

function updateUsersList (data) {
    let list = document.querySelector('.users + .list');
    list.innerHTML = '';
    if (data.length) {
        for (const user of data) {
            addUser(user);
        }
    }
    if (!data.length) {
        let item = document.createElement('li');
        item.innerHTML = "No hay usuarios que mostrar";
        item.classList.add("col-span-10", "w-full", "text-center");
        list.appendChild(item);
    }
}

function updateTeachersList (data) {
    let list = document.querySelector('.teachers + .list ul');
    list.innerHTML = '';
    if (data.length) {
        for (const user of data) {
            addTeacher(user);
        }
    }
    if (!data.length) {
        let item = document.createElement('li');
        item.innerHTML = "No hay usuarios que mostrar";
        list.appendChild(item);
    }
}

function createUsersFilter () {
    filter = new FilterJS({
        id: 'filter-users',
        limit: 10,
        order: [
            ['stars', 'DESC'],
            'username',
        ], rules: {
            search: [['username','name']],
            teammate: true,
        },
    }, {}, {
        run: {
            function: makePages,
        }
    }, users);
    filter.run();
}

function createTeachersFilter () {
    filter = new FilterJS({
        id: 'filter-teachers',
        limit: 10,
        order: [
            ['important', 'DESC'],
            ['stars', 'DESC'],
            'username',
        ], rules: {
            search: [['username','name']],
            games: 'games:*.slug',
            price: ['prices:[0,1].price', '<=', null, false],
            time: 'days:*.hours:*.time',
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
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
            });
            if (query.response.code === 200) {
                users = query.response.data.users;
                createUsersFilter();
            }
            break;
        case 1:
            query = await Fetch.get(`/api/teachers`, {
                'Accept': 'application/json',
                'Content-type': 'application/json; charset=UTF-8',
            });
            if (query.response.code === 200) {
                users = query.response.data.users;
                createTeachersFilter();
            }
            break;
    }
}

document.addEventListener('DOMContentLoaded', function (e) {
    if (URL.findOriginalRoute() === '/users') {
        getUsers(0);
    }
    if (URL.findOriginalRoute() === '/teachers') {
        getUsers(1);
    }
});