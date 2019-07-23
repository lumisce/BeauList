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
import Login from './pages/Login'
import BrandIndex from './pages/BrandIndex'
import BrandShow from './pages/BrandShow'
import CategoryIndex from './pages/CategoryIndex'
import CategoryShow from './pages/CategoryShow'
import ProductShow from './pages/ProductShow'
import BlistCreate from './pages/BlistCreate'
import BlistShow from './pages/BlistShow'
import UserShow from './pages/UserShow'
import UserSavedBlists from './pages/UserSavedBlists'
import UserFavoriteBrands from './pages/UserFavoriteBrands'
import UserFavoriteProducts from './pages/UserFavoriteProducts'
import UserRatedProducts from './pages/UserRatedProducts'
import Search from './pages/Search'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const router = new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/login',
			name: 'login',
			component: Login,
		},
		{
			path: '/home',
			name: 'home',
			component: BrandIndex,
		}, {
			path: '/brands',
			name: 'brands.index',
			component: BrandIndex,
		}, {
			path: '/brands/:id',
			name: 'brands.show',
			component: BrandShow,
		}, {
			path: '/categories',
			name: 'categories.index',
			component: CategoryIndex,
		}, {
			path: '/categories/:id',
			name: 'categories.show',
			component: CategoryShow,
		}, {
			path: '/products/:id',
			name: 'products.show',
			component: ProductShow,
		}, {
			path: '/lists/create',
			name: 'lists.create',
			component: BlistCreate,
			meta: {
				requiresAuth: true,
			}
		}, {
			path: '/lists/:id',
			name: 'lists.show',
			component: BlistShow,
		}, {
			path: '/users/:id',
			name: 'users.show',
			component: UserShow,
		}, {
			path: '/users/:id/savedlists',
			name: 'users.savedlists',
			component: UserSavedBlists,
		}, {
			path: '/users/:id/favbrands',
			name: 'users.favbrands',
			component: UserFavoriteBrands,
		}, {
			path: '/users/:id/favproducts',
			name: 'users.favproducts',
			component: UserFavoriteProducts,
		}, {
			path: '/users/:id/ratedproducts',
			name: 'users.ratedproducts',
			component: UserRatedProducts,
		}, {
			path: '/search',
			name: 'search',
			component: Search,
		}
	]

});

router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {
		if (store.getters.isLoggedIn) {
			next()
			return
		}
		next('/login')
	} else {
		next()
	}
})

Vue.prototype.$csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
Vue.prototype.$hasPasswordReset = false;

axios.defaults.baseURL = 'http://beaulist.test';
axios.defaults.headers.common['Accept'] = 'application/json';

axios.interceptors.request.use(request => {
  console.log('Starting Request', request)
  return request
})

axios.interceptors.response.use(response => {
  console.log('Response:', response)
  return response
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
		token(newtoken,oldtoken) {
			this.updateAuth(newtoken)
		},
		isLoggedIn(newisloggedin,oldisloggedin) {
			if (newisloggedin) {
				this.setUser()
			}
		},
	}, 
	methods: {
		updateAuth() {
			if (this.isLoggedIn) {
				axios.defaults.headers.common['Authorization'] = 'Bearer '+this.token;
			} else {
				delete axios.defaults.headers.common['Authorization'];
			}
		},
		setUser() {
			axios.get('/api/user').then(response => {
				this.user = response.data.user
				this.$store.dispatch('refresh', response.data.user)
			})
		},
	},
	created() {
		this.updateAuth(this.token)
		if (this.isLoggedIn) {
			this.setUser()
		}
	}
});