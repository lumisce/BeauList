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
					<div class="card-header">Register</div>
					<div class="card-body">
						<form @submit.prevent="register">

							<div class="form-group row">
								<label for="name" class="col-md-4 col-form-label text-md-right">
									Name
								</label>
								<div class="col-md-6">
									<input v-model="user.name" id="name" type="text" 
										class="form-control" required autofocus>
								</div>
							</div>

							<div class="form-group row">
								<label for="email" class="col-md-4 col-form-label text-md-right">
									Email address
								</label>
								<div class="col-md-6">
									<input v-model="user.email" id="email" type="email" 
										class="form-control" required autocomplete="email">
								</div>
							</div>

							<div class="form-group row">
								<label for="password" class="col-md-4 col-form-label text-md-right">
									Password
								</label>
								<div class="col-md-6">
									<input v-model="user.password" id="password" 
										type="password" minlength="8" class="form-control" 
										required autocomplete="new-password">
								</div>
							</div>

							<div class="form-group row">
								<label for="checkpassword" class="col-md-4 col-form-label text-md-right">
									Confirm Password
								</label>
								<div class="col-md-6">
									<input v-model="user.password_confirmation" id="checkpassword" 
										type="password" class="form-control" required>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-4">
									<button type="submit" class="btn btn-primary">Register</button>
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
		mixins: [pageMixin],
		data() {
			return {
				user: {
					name: '',
					email: '',
					password: '',
					password_confirmation: '',
				},
				errors: null
			}
		},
		methods: {
			register() {
				if (!this.isLoggedIn) {
					let formdata = {
						'_token': this.$csrf,
						...this.user
					}

					this.axios.post('/api/register', formdata).then(response => {
						if (response.data.status == 'success') {
							this.$router.push({
								name: 'login', 
								params: {
									fromRegister: true,
								}
							})
						} else if (response.data.errors) {
							let errors = response.data.errors
							let err = ""
							if (errors.name) {
								err = errors.name[0]
							} else if (errors.email) {
								err = errors.email[0]
							} else if (errors.password) {
								err = errors.password[0]
							}
							this.bsError(err)
						} else {
							this.bsError()
						}
					})
					.catch(err => {
						this.bsError()
					})
				}
			}
		},
	}
</script>