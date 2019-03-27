
window._ = require('lodash');
const BASEURL = 'http://shopperreport.errandaapp.com';

import { Message } from 'element-ui'

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
window.axios.defaults.baseURL = 'http://localhost:8000';
//window.axios.defaults.baseURL = 'http://localhost:8000'


window.axios.interceptors.response.use(function (response) {
    let res = response.data || {};
    let code = res.code;
    let method = response.config.method;
    if(code == 0) {
        if(res.message) {
            Notifier.success(res.message || "")
        }
    } else {
        if(res.message) {
            Notifier.error(res.message || "")
        }
    }
    return response.data;
}, function (error) {
    let errResponse = error.response || {};
    if(errResponse.status ==422) {
        let data = errResponse.data || {}
        let errors = data.errors
        Object.keys(errors).forEach((error)=> {
            let ers = errors[error] || [];
            ers.forEach((er)=> {
                Notifier.error(er)
            })
            return;
        })
    } else if(errResponse.status == 500) {
        Notifier.error(error.message || "");
    } else if(errResponse.status == 401) {
        location.href = `${BASEURL}/login`;   
    }
    return Promise.reject(error);
  });
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
