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
		login({commit, dispatch}, user) {
			return new Promise((resolve, reject) => {
				commit('auth_request')
				axios.post('/api/login', user)
				.then(response => {
					const token = response.data.token
					axios.defaults.headers.common['Authorization'] = 'Bearer '+token;
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
				axios.post('/api/logout')
				.then(response => {
					localStorage.removeItem('token')
					delete axios.defaults.headers.common['Authorization']
					commit('logout')
					resolve(response)
				})
				.catch(err => {
					commit('logout')
					localStorage.removeItem('token')
					delete axios.defaults.headers.common['Authorization']
					resolve(err)
				})
			})
		},
		expire({commit}) {
			return new Promise((resolve, reject) => {
				commit('logout')
				localStorage.removeItem('token')
				delete axios.defaults.headers.common['Authorization']
				resolve()
			})
		},
		refreshToken({commit, dispatch}, token) {
			return new Promise((resolve, reject) => {
				localStorage.setItem('token', token)
				commit('refresh_token', token)
				resolve()
			})
		},
		refresh({commit, dispatch}, user) {
			commit('refresh', user)
		}
	},
	getters: {
		isLoggedIn: state => !!state.token,
		authStatus: state => state.status,
	}
})