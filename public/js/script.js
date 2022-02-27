/**
 * * Print a <input> value in a <video>.
 * @param {nodeElement} input
 * @param {nodeElement} video
 */
function printVideo (input, video) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;

    var match = input.value.match(regExp);

    let videoId;

    if (match && match[2].length == 11) {
        videoId = match[2];
    } else {
        videoId = 'error';
    }
    
    console.log(videoId);

    if (videoId == 'error') {
        video.html(`<a href='${ input.value }' class='w-full russo color-black btn btn-one btn-outline' target='_blank'><span class='px-4 py-2 text-lg'>Material enviado</span></a>`);
    } else {
        video.html(`<iframe src='//www.youtube.com/embed/${ videoId }' frameborder='0' allowfullscreen></iframe>`);
    }
}

function changeType (btn) {
    let input;
    for (const className of btn.classList) {
        if (/input-/.exec(className)) {
            input = document.querySelector(`input[name=${ className.split('input-')[1] }]`);
        }
    }
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
    if (btn.children[0].classList.contains('fa-eye')) {
        btn.children[0].classList.remove('fa-eye');
        btn.children[0].classList.add('fa-eye-slash');
    } else {
        btn.children[0].classList.add('fa-eye');
        btn.children[0].classList.remove('fa-eye-slash');
    }
}

document.addEventListener('DOMContentLoaded', (e) => {
    if (document.querySelectorAll('.dropdown').length) {
        for (const html of document.querySelectorAll('.dropdown')) {
            new window.dropdown({
                id: html.id
            });
        }
    }

    if (status.hasOwnProperty('code')) {
        new window.notification({
            ...status,
            classes: ['russo'],
        }, {
            open: true,
        });
    }

    if (document.querySelectorAll('.seePassword').length) {
        for (const btn of document.querySelectorAll('.seePassword')) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                changeType(this);
            });
        }
    }
});