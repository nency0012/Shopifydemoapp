window._ = require('lodash');
window.Vue = require('vue').default;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import PolarisVue from '@hulkapps/polaris-vue';
import '@hulkapps/polaris-vue/dist/polaris-vue.css';
Vue.use(PolarisVue);

import './components';
import router from './routes';

const app = new Vue({
    el: '#app',
    router,
});


