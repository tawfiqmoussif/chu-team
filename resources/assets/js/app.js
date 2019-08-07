
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';
import jQuery from 'jquery';
global.jQuery = jQuery;
global.$ = jQuery
let bootstrap = require('bootstrap')
import 'bootstrap/dist/css/bootstrap.css'



import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


import swal from 'sweetalert2'
window.swal = swal;

const Toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.Toast = Toast;


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));


import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  })

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue') },
    { path: '/developer', component: require('./components/Developer.vue') },
    { path: '/users', component: require('./components/Utilisateurs.vue') },
    { path: '/profile', component: require('./components/Profile.vue') },
    { path: '/brancardiers', component: require('./components/Brancardiers.vue')},
    { path: '/login', component: require('./components/auth/Login.vue')},
    { path: '/demandeurs', component: require('./components/Demandeurs.vue')},
    { path: '/majors', component: require('./components/Major.vue')},
    { path: '/services', component: require('./components/Services.vue')},
    { path: '/coordinateurs', component: require('./components/Coordinateurs.vue')},
    { path: '*', component: require('./components/NotFound.vue') }, 

]

const router = new VueRouter({
    mode: 'hash',
    routes // short for `routes: routes`
  })



Vue.filter('upText', function(text){
    if(Text ==='') return Text;
    else
    return text.charAt(0).toUpperCase() + text.slice(1)
});
function isEmpty(str) {
    return (!str || 0 === str.length);
}
Vue.filter('metier', function(text){
    if(!isEmpty(Text)) 
    return text.charAt(0).toUpperCase() + text.slice(1);
    else
    return 'Administrateur';
   
});
Vue.filter('myDate',function(created){
    return moment(created).format('MMMM Do YYYY');
});

Vue.filter('changeTemp',function(Text){
    if(Text===1) return 'Oui'; 
    else return 'Non';
});

Vue.filter('sans',function(Text){
    if(Text==='Sans') return 'not_active'; return Text;
});


window.Fire =  new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);

Vue.component(
    'vue-login',
    require('./components/auth/Login.vue')
);

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router,
    data:{
        search: ''
    },
    methods:{
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),

        printme() {
            window.print();
        }
    }
});
