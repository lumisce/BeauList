import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
		status: '',
		token: localStorage.getItem('token') || '',
		user: {}
	},
	mutations: {
		auth_request(state) {
			state.status = 'loading'
		},
		auth_success(state, token, user) {
			state.status = 'success'
			state.token = token
			state.user = user
		},
		auth_error(state) {
			state.status = 'error'
		},
		logout(state) {
			state.status = ''
			state.token = ''
			state.user = {}
		},
		refresh(state, user) {
			state.user = user
		},
		refresh_token(state, token) {
			state.token = token
		}
	},
	actions: {
		login({commit}, user) {
			return new Promise((resolve, reject) => {
				commit('auth_request')
				axios.post('/api/login', user)
				.then(response => {
					const token = response.data.token
					const user = response.data.user
					localStorage.setItem('token', token)
					commit('auth_success', token, user)
					resolve(response)
				})
				.catch(err => {
					commit('auth_error')
					localStorage.removeItem('token')
					reject(err)
				})
			})
		},
		logout({commit}) {
			return new Promise((resolve, reject) => {
				commit('logout')
				axios.post('/api/logout')
				.then(response => {
					localStorage.removeItem('token')
					delete axios.defaults.headers.common['Authorization']
					resolve(response)
				})
				.catch(err => {
					commit('auth_error')
					reject(err)
				})
			})
		},
		refreshToken({commit}) {
			return new Promise((resolve, reject) => {
				axios.post('/api/refresh')
				.then(response => {
					const token = response.data.token
					localStorage.setItem('token', token)
					axios.defaults.headers.common['Authorization'] = 'Bearer '+state.token;
					commit('refresh_token', token)
					resolve(response)
				})
				.catch(err => {
					commit('auth_error')
					reject(err)
				})
			})
		},
		refresh({commit}, user) {
			commit('refresh', user)
		}
	},
	getters: {
		isLoggedIn: state => !!state.token,
		authStatus: state => state.status,
	}
})