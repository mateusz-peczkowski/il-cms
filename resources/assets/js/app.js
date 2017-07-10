/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
//import {http} from './services/http'



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));
require('./../talvbansal/media-manager/js/media-manager');
Vue.component('uploader', require('./components/Uploader.vue'));
Vue.component('modal-manager', require('./components/ModalManager.vue'));

const app = new Vue({
    el: '#app',
    data: {
        showMediaManager: false
    },
    methods: {
        openMediaManager () {
            this.$refs.modalManager.showMediaManager = true
        }
    }
});