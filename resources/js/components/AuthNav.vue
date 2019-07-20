<template>
	<ul class="navbar-nav ml-auto">
		<!-- Authentication Links -->
		<div v-if="!isLoggedIn" class="right-nav">
			<li class="nav-item">
				<router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="/register">Register</a>
			</li>
		</div>
		<div v-else class="right-nav">
			<li class="nav-item dropdown">
				<a id="navbarDropdown" class="nav-link dropdown-toggle" 
					href="#" role="button" aria-haspopup="true" 
					aria-expanded="false" @click.prevent="dropdown">
					{{ user.name }} <span class="caret"></span>
				</a>

				<div class="dropdown-menu dropdown-menu-right" 
					:class="{'show' : showDropdown}" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="/profile">My Profile</a>
					<a class="dropdown-item" href="/logout" @click.prevent="logout">Logout</a>
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
			}
		}, 
	}
</script>