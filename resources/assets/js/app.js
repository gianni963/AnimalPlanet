
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import InstantSearch from 'vue-instantsearch';

window.Vue = require('vue');

window.events = new Vue();

Vue.use(InstantSearch);

let authorizations = require('./authorizations');

window.flash = function (message, level = 'success') {
    window.events.$emit('flash', {message, level});
};

window.Vue.prototype.authorize =  function (...params) {
	if (! window.pettube.signedIn) return false;

	if(typeof params[0] === 'string'){
		return authorizations[params[0]](params[1]);
	}
	
	return params[0](window.pettube.user);
};

Vue.prototype.signedIn = window.pettube.signedIn;

var VueResource =  require('vue-resource');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('video-upload', require('./components/VideoUpload.vue'));
Vue.component('video-player', require('./components/VideoPlayer.vue'));
Vue.component('video-vote', require('./components/VideoVote.vue'));
Vue.component('video-comments', require('./components/VideoComments.vue'));
Vue.component('subscribe', require('./components/Subscription.vue'));
Vue.component('data-table', require('./components/DataTable.vue'));
Vue.component('data-tablevideo', require('./components/DataTableVideo.vue'));
Vue.component('data-tablecomment', require('./components/DataTableComment.vue'));
Vue.component('data-tablechannel', require('./components/DataTableChannel.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('user-notifications', require('./components/UserNotifications.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('wysiwyg', require('./components/Wysiwyg.vue'));


Vue.component('thread-view', require('./pages/Thread.vue'));



Vue.http.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('#csrf-token').content;

Vue.use(VueResource);
const app = new Vue({
    el: '#app',
    data: window.pettube
});


