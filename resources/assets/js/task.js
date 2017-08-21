/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the task. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './App.vue';
import VueRouter from 'vue-router';
import ElementUI from 'element-ui';

import Container from './components/partial/Container.vue';
import Box from './components/partial/Box.vue';
Vue.component('container', Container);
Vue.component('box', Box);

import 'element-ui/lib/theme-default/index.css';
import 'font-awesome/css/font-awesome.min.css';
import '../sass/_variables.scss';

import routes from './routes'
const router = new VueRouter({
    routes,
    scrollBehavior (to, from, savedPosition) {
        return {x: 0, y: 0}
    }
});

Vue.use(ElementUI);
Vue.use(VueRouter);

const app = new Vue({
    el: '#task',
    router,
    render: h => h(App)
});
