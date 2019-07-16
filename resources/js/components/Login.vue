<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="alert-container">
					<div v-if="errors" class="alert alert-danger" role="alert"><span>{{errors.email[0]}}</span></div>
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

							<!-- <div class="form-group row">
								<div class="col-md-6 offset-md-4">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="remember" id="remember">
										<label class="form-check-label" for="remember">
											Remember Me
										</label>
									</div>
								</div>
							</div> -->

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-4">
									<button type="submit" class="btn btn-primary">Login</button>

									<a v-if="hasPasswordReset" class="btn btn-link" href="/password/request">
										Forgot Your Password?
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
	export default {
		data() {
			return {
				csrf: this.$csrf,
				hasPasswordReset: this.$hasPasswordReset,
				user: {
					email: '',
					password: '',				
				},
				errors: null
			}
		},
		methods: {
			login() {
				this.$store.dispatch('login', {'email':this.user.email, 'password':this.user.password})
				.then(() => this.$router.push('/'))
				.catch(err => {
					console.log(err.response)
					this.errors = err.response.data.errors
				})
			}
		},
	}
</script>