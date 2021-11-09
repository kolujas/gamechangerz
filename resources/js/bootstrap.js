window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

window.ckeditor = require( '@ckeditor/ckeditor5-build-inline' );

window.moment = require('moment');
window.moment.locale('es');

window.class = require('juancruzagb/JuanCruzAGB/js/Class').default;

window.countdown = require('juancruzagb/CountDownJS/js/CountDown').default;

window.dropdown = require('juancruzagb/DropdownJS/js/Dropdown').default;

window.filter = require('juancruzagb/FilterJS/js/Filter').default;

window.html = require('juancruzagb/HTMLCreatorJS/js/HTMLCreator').default;

window.inputdate = require('juancruzagb/InputDateMakerJS/js/InputDateMaker').default;

window.inputfile = require('juancruzagb/InputFileMakerJS/js/InputFileMaker').InputFileMaker;

window.modal = require('juancruzagb/ModalJS/js/Modal').default;

window.navmenu = require('juancruzagb/NavMenuJS/js/NavMenu').default;

window.notification = require('juancruzagb/NotificationJS/js/Notification').default;

window.sidebar = require('juancruzagb/SidebarJS/js/Sidebar').default;

window.tabmenu = require('juancruzagb/TabMenuJS/js/TabMenu').default;

window.validation = require('juancruzagb/ValidationJS/js/Validation').default;

window.localstorage = require('juancruzagb/ProvidersJS/js/LocalStorageServiceProvider').LocalStorageServiceProvider;
window.url = require('juancruzagb/ProvidersJS/js/URLServiceProvider').URLServiceProvider;