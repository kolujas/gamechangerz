import Post from "../components/Post.js";

function addPostsList (data) {
    document.querySelector('.posts').appendChild(Post.component('list', data));
}

document.addEventListener('DOMContentLoaded', function (e) {
    $('.filter-pagination').pagination({
        dataSource: posts,
        pageSize: 10,
        autoHidePrevious: true,
        autoHideNext: true,
        callback: function (data, pagination) {
            addPostsList(data);
        }
    });
});