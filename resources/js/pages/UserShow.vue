<template>
	<div v-if="user" class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<h2 v-if="isMe">My Profile</h2>
				<h2 v-else>{{user.name}}'s Profile</h2>
				<div class="card">
					<div class="card-header">
						Info
					</div>
					<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
						<router-link class="list-group-item"
							:to="{ name: 'users.favbrands', params: {id: user.id} }">
							Favorite Brands
						</router-link>
						<router-link class="list-group-item"
							:to="{ name: 'users.favproducts', params: {id: user.id} }">
							Favorite Products
						</router-link>
						<router-link class="list-group-item"
							:to="{ name: 'users.ratedproducts', params: {id: user.id} }">
							Rated Products
						</router-link>
						<router-link class="list-group-item"
							:to="{ name: 'users.savedlists', params: {id: user.id} }">
							Saved Lists
						</router-link>
					</div>
				</div>
				<div class="card mt-2">
					<div class="card-header">
						<ul class="nav nav-pills card-header-pills justify-content-right" style="margin-bottom:-1rem;">
							<li class="nav-item" style=""><p class="nav-link">Curated Lists</p></li>
							<li v-if="isMe" class="nav-item ml-auto">
								<router-link :to="{ name: 'lists.create' }" class="nav-link active">
									Add
								</router-link>
							</li>
						</ul>
					</div>
					<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
						<router-link v-for="list in lists" :key="list.id" class="list-group-item"
							:to="{ name: 'lists.show', params: {id: list.id} }">
							{{list.name}}
						</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Favorite from '../components/Favorite'
	import ProductListItem from '../components/ProductListItem'

	export default {
		components: {
			ProductListItem,
		},
		data() {
			return {
				user: null,
				showAlert: false,
				alertSuccess: true,
				alertMessage: '',
				lists: [],
				isMe: false,
			}
		},
		computed: {
		},
		methods: {
		},
		created() {
			let url = '/api/users/'+this.$route.params.id;
			this.axios.get(url).then(response => {
				this.user = response.data.user
				this.lists = response.data.lists
				this.isMe = response.data.isMe
			});
		}
	}
</script>