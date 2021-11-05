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

    if (error) {
        new window.notification({
            ...error,
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