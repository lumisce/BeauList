/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

import Vue from 'vue';

import VueInstantSearch from 'vue-instantsearch';
Vue.use(VueInstantSearch);

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import router from './router.js';

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import Vuex from 'vuex';
Vue.use(Vuex)
import store from './store.js';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import App from './components/App'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {
		if (store.getters.isLoggedIn) {
			next()
		} else {
			next('/login')
		}
	} else if (to.matched.some(record => record.meta.guest)) {
		if (store.getters.isLoggedIn) {
			router.push(from)
		} else {
			next()
		}
	} else {
		next()
	}
})

Vue.prototype.$csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
Vue.prototype.$hasPasswordReset = false;

axios.defaults.headers.common['Accept'] = 'application/json';

axios.interceptors.request.use(request => {
	console.log('Starting Request', request)
	return request
})

axios.interceptors.response.use(response => {
	console.log('Response:', response)
	return response
}, error => {
	if (error.response.status == 401) {
		store.dispatch('expire').then(() => {
			router.push('/login')
		})
    } else if (error.response.status == 404) {
    	router.push('/404')
    } else {
    	router.push({
			name: 'error', 
			params: {
				code: error.response.status,
				message: error.response.statusText,
			}
		})
    }

})

const app = new Vue({
	el: '#app',
	components: { App },
	router,
	store,
	computed: {
		token() {
			return this.$store.state.token;
		},
		isLoggedIn() {
			return this.$store.getters.isLoggedIn
		},
	},
	data() {
		return {
			user: null
		}
	},
	watch: {
		isLoggedIn(newisloggedin,oldisloggedin) {
			if (newisloggedin) {
				this.setUser()
			}
		},
	}, 
	methods: {
		updateAuth() {
			if (this.isLoggedIn) {
				this.refreshToken()
			} else {
				delete axios.defaults.headers.common['Authorization'];
			}
		},
		refreshToken() {
			axios.defaults.headers.common['Authorization'] = 'Bearer '+this.token;
			axios.post('/api/refresh').then(response => {
				const token = response.data.token
				this.$store.dispatch('refreshToken', token).then(() => {
					axios.defaults.headers.common['Authorization'] = 'Bearer '+token;
					this.setUser()
					this.setTokenRefresh(response.data.expires_in)
				})
			}).catch(err => {
				this.$store.dispatch('expire').then(() => {
					this.$router.push('/login')
				})
			})
		},
		setUser() {
			axios.defaults.headers.common['Authorization'] = 'Bearer '+this.token;
			axios.get('/api/user').then(response => {
				this.user = response.data.user
				this.$store.dispatch('refresh', response.data.user)
			})
		},
		setTokenRefresh(time) {
			let _this = this;
			setTimeout(function() {
				_this.refreshToken()
			}, time*1000/3)
		}
	},
	created() {
		this.updateAuth()
	}
});