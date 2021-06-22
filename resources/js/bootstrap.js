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
// window.Aligment = require( '@ckeditor/ckeditor5-alignment/src/alignment' );
// window.Blockquote = require( '@ckeditor/ckeditor5-block-quote/src/blockquote' );
// window.Bold = require( '@ckeditor/ckeditor5-basic-styles/src/bold' );
// window.Essentials = require( '@ckeditor/ckeditor5-essentials/src/essentials' );
// window.HorizontalLine = require( '@ckeditor/ckeditor5-horizontal-line/src/horizontalline' );
// window.Italic = require( '@ckeditor/ckeditor5-basic-styles/src/italic' );
// window.List = require( '@ckeditor/ckeditor5-list/src/list' );
// window.Paragraph = require( '@ckeditor/ckeditor5-paragraph/src/paragraph' );
// window.Title = require( '@ckeditor/ckeditor5-heading/src/title' );
// Plugins to include in the build.
// window.ckeditor.builtinPlugins = [
	// require( '@ckeditor/ckeditor5-alignment/src/alignment' ),
	// require( '@ckeditor/ckeditor5-block-quote/src/blockquote' ),
	// require( '@ckeditor/ckeditor5-basic-styles/src/bold' ),
	// require( '@ckeditor/ckeditor5-essentials/src/essentials' ),
	// require( '@ckeditor/ckeditor5-horizontal-line/src/horizontalline' ),
	// require( '@ckeditor/ckeditor5-basic-styles/src/italic' ),
	// require( '@ckeditor/ckeditor5-list/src/list' ),
	// require( '@ckeditor/ckeditor5-paragraph/src/paragraph' ),
	// require( '@ckeditor/ckeditor5-heading/src/title' )
// ];