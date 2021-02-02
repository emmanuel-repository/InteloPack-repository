require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import router from './router'



import Vuetify from 'vuetify'
Vue.use(Vuetify);

const app = new Vue({
    el: '#app', router,  vuetify: new Vuetify(),
});
