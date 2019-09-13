<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="alert-container">
					<transition name="slide-fade">
					<div v-if="showAlert" class="alert" 
						:class="{'alert-success': alertSuccess, 
						'alert-danger': !alertSuccess}" role="alert">
						<span>{{ alertMessage }}</span>
					</div>
					</transition>
				</div>
				<div class="card">
					<div class="card-header">Login</div>
					<div class="card-body">
						<form @submit.prevent="login">
							<input type="hidden" name="_token" :value="csrf">

							<div class="form-group row">
								<label for="email" class="col-md-4 col-form-label text-md-right">Email address</label>
								<div class="col-md-6">
									<input v-model="user.email" id="email" type="email" class="form-control" required autocomplete="email" autofocus>
								</div>
							</div>

							<div class="form-group row">
								<label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
								<div class="col-md-6">
									<input v-model="user.password" id="password" type="password" class="form-control" required autocomplete="current-password">
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-4">
									<button type="submit" class="btn btn-primary">Login</button>
									or
									<router-link class=""
										:to="{ name: 'register' }">
										Click here to Register
									</router-link>
									</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import pageMixin from '../pageMixin'

	export default {
		props: ['fromRegister'],
		mixins: [pageMixin],
		data() {
			return {
				csrf: this.$csrf,
				user: {
					email: '',
					password: '',				
				},
			}
		},
		methods: {
			login() {
				this.$store.dispatch('login', {'email':this.user.email, 'password':this.user.password})
				.then(() => this.$router.push('/search'))
				.catch(err => {
					this.bsError(err.response.data.errors.email[0])
				})
			}
		},
		created() {
			if (this.fromRegister) {
				this.bsAlert('Successfully registered!')
			}
		}
	}
</script>