function submit (params) {
    switch (params.type) {
        case "create":
            validation.coupon.create.ValidationJS.html.action = `/panel/coupons/create`;
            document.querySelector("form#coupon-form input[name=_method]").value = "POST";
            break;
        case "delete":
            validation.coupon.create.ValidationJS.html.action = `/panel/coupons/${ coupon.slug }/delete`;
            document.querySelector("form#coupon-form input[name=_method]").value = "DELETE";
            break;
        case "update":
            validation.coupon.create.ValidationJS.html.action = `/panel/coupons/${ coupon.slug }/update`;
            document.querySelector("form#coupon-form input[name=_method]").value = "PUT";
            break;
    }
    validation.coupon.create.ValidationJS.html.submit();
}

if (validation.hasOwnProperty("coupon")) {
    validation.coupon.create.ValidationJS = new window.validation({
        id: "coupon-form",
        rules: validation.coupon.create.rules,
        messages: validation.coupon.create.messages.es,
    }, {
        submit: false,
        active: true,
    }, {
        valid: {
            function: submit,
            params: {
                type: "create",
            },
        }
    });
    validation.coupon.update.ValidationJS = new window.validation({
        id: "coupon-form",
        rules: validation.coupon.update.rules,
        messages: validation.coupon.update.messages.es,
    }, {
        submit: false,
        active: false,
    }, {
        valid: {
            function: submit,
            params: {
                type: "update",
            },
        }
    });
    validation.coupon.delete.ValidationJS = new window.validation({
        id: "coupon-form",
        rules: validation.coupon.delete.rules,
        messages: validation.coupon.delete.messages.es,
    }, {
        submit: false,
        active: false,
    }, {
        valid: {
            function: submit,
            params: {
                type: "delete",
            },
        }
    });
}

document.querySelector('.editBtn').addEventListener('click', function(){
    validation.coupon.create.ValidationJS.setState("active", false);
    validation.coupon.update.ValidationJS.setState("active", true);
});   

document.querySelector('.cancelBtn').addEventListener('click', function(){
    validation.coupon.update.ValidationJS.setState("active", false);
    validation.coupon.delete.ValidationJS.setState("active", false);
});

document.querySelector('.deleteBtn').addEventListener('click', function(){
    validation.coupon.create.ValidationJS.setState("active", false);
    validation.coupon.delete.ValidationJS.setState("active", true);
});

document.addEventListener("DOMContentLoaded", function () {
    if (/update/.exec(window.url.findHashParameter())) {
        validation.coupon.create.ValidationJS.setState("active", false);
        validation.coupon.update.ValidationJS.setState("active", true);
    }
    
    if (/delete/.exec(window.url.findHashParameter())) {
        validation.coupon.create.ValidationJS.setState("active", false);
        validation.coupon.delete.ValidationJS.setState("active", true);
    }
});