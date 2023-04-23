window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '7092bf4526a75faa4a8e',
    authEndpoint: 'https://ardwtalb.fudex-tech.net/ard-w-talab/public/broadcasting/auth',
    cluster: 'eu',
    forceTLS: false,
    encrypted:false
});


window.Echo.connector.pusher.connection.bind('connecting', function(){
    console.log('connecting');
});
