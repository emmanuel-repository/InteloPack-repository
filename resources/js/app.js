require('./bootstrap');

window.Vue = require('vue');


import router from './router'
import Vuex from 'vuex'
import Vuelidate from "vuelidate";


// import Vuetify from 'vuetify'
// Vue.use(Vuetify);
Vue.use(Vuelidate);

const app = new Vue({
    el: '#app', 
    router,
    // vuetify: new Vuetify(),
}); 
  