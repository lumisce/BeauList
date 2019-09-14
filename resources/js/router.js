import Vue from 'vue'
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Landing from './pages/Landing'
import Register from './pages/Register'
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
import ProductSearch from './pages/ProductSearch'
import BrandSearch from './pages/BrandSearch'
import BlistSearch from './pages/BlistSearch'

export default new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/register',
			name: 'register',
			component: Register,
		},
		{
			path: '/login',
			name: 'login',
			component: Login,
			props: true,
			meta: {
				guest: true,
			}
		},
		{
			path: '/',
			name: 'home',
			component: Landing,
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
			props: true,
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
			redirect: '/search/products',
		}, {
			path: '/search/products',
			name: 'search.products',
			component: ProductSearch,
		}, {
			path: '/search/brands',
			name: 'search.brands',
			component: BrandSearch,
		}, {
			path: '/search/lists',
			name: 'search.lists',
			component: BlistSearch,
		}
	]
});