<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="alert-container">
					<transition name="slide-fade">
					<div v-if="showAlert" class="alert" 
						:class="{'alert-success': alertSuccess, 'alert-danger': !alertSuccess}" 
						role="alert">
						<span>{{ alertMessage }}</span>
					</div>
					</transition>
				</div>
				<div class="card">
					<div class="card-header">Create New List</div>
					<div class="card-body">
						<form @submit.prevent="createList">
							<div class="form-group row">
								<label for="name" class="col-md-3 col-form-label text-md-right">Name</label>
								<div class="col-md-8">
									<input id="name" type="text" class="form-control" name="name" v-model.trim="name" required autofocus>
								</div>
							</div>
							 <div class="form-group row">
								<label for="description" class="col-md-3 col-form-label text-md-right">Description</label>
								<div class="col-md-8">
									<textarea id="description" class="form-control" name="description" :rows="rowSize" v-model="description"></textarea>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-8 offset-md-3">
									<button type="submit" class="btn btn-primary">Create</button>
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
				name: '',
				description: '',
				showAlert: false,
				alertSuccess: true,
				alertMessage: '',
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
			rowSize() {
				return Math.max(5, this.description.split('\n').length)
			}
		},
		methods: {
			createList() {
				if (this.isLoggedIn) {
					let formdata = {
						'id': this.$route.params.id, 
						'_token': this.$csrf,
						'name': this.name,
						'description': this.description.trim(),
					}
					this.axios.post('/api/lists', formdata).then(response => {
						if (response.data.status == 'success') {
							this.setUser()
							this.$router.push('/lists/'+response.data.id)
						} else {
							this.bsAlert('error', '')
						}
					}).catch(err => {
						this.bsAlert('error', '')
					})
				}
			},
			setUser() {
				this.axios.get('/api/user').then(response => {
					this.$store.dispatch('refresh', response.data.user)
				})
			},
		},
	}
</script>