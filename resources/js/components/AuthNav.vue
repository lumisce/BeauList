<template>
	<ul class="navbar-nav ml-auto">
		<div v-if="!isLoggedIn" class="right-nav">
			<li class="nav-item">
				<router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/register">Register</a>
			</li>
		</div>
		<div v-else class="right-nav">
			<li v-if="user" class="nav-item dropdown">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" 
					href="#" role="button" aria-haspopup="true" 
					aria-expanded="false" @click.prevent="dropdown" @blur="hideDropdown">
					{{ user.name }} <span class="caret"></span>
				</a>

				<div class="dropdown-menu dropdown-menu-right" 
					:class="{'show' : showDropdown}" aria-labelledby="navbarDropdown">
					<router-link :to="{ name: 'users.show', params: {id: user.id}}" 
						class="dropdown-item" event="mousedown" @mousedown.native="hideDropdown">
						My Profile
					</router-link>
					<a class="dropdown-item" href="/logout" @mousedown.prevent="logout">Logout</a>
				</div>
			</li>
		</div>
	</ul>
</template>

<script>
	export default {
		props: ['user'],
		data() {
			return {
				csrf: this.$csrf,
				showDropdown: false,
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
		},
		methods: {
			logout() {
				this.showDropdown = false
				this.$store.dispatch('logout')
				.then(() => {
					this.$router.push('/login')
				})
			},
			dropdown() {
				this.showDropdown = !this.showDropdown
			},
			hideDropdown() {
				this.showDropdown = false
			},
		}, 
	}
</script>