<template>
	<div v-if="user" class="container">
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
				<h2 v-if="isMe">My Profile</h2>
				<h2 v-else>{{user.name}}'s Profile</h2>
				<div class="card">
					<div class="card-header">
						Info
					</div>
					<div class="list-group list-group-flush list-small" id="list-tab">
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
						<ul class="nav card-header-pills">
							<li class="nav-item">
								<p class="nav-link">Curated Lists</p>
							</li>
							<li v-if="isMe" class="nav-item ml-auto">
								<router-link :to="{ name: 'lists.create' }" 
									class="nav-link">
									Add
								</router-link>
							</li>
						</ul>
					</div>
					<div v-if="lists.length" class="list-group list-group-flush list-small">
						<router-link v-for="list in lists" :key="list.id" 
							class="list-group-item"
							:to="{ name: 'lists.show', params: {id: list.id} }">
							{{list.name}}
						</router-link>
					</div>
					<EmptyList v-else></EmptyList>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Favorite from '../components/Favorite'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'
	import pageMixin from '../pageMixin'

	export default {
		props: ['fromDelete'],
		mixins: [pageMixin],
		components: {
			ProductListItem,
			EmptyList,
		},
		data() {
			return {
				user: null,
				lists: [],
				isMe: false,
			}
		},
		computed: {
		},
		methods: {
		},
		created() {
			console.log(this.fromDelete)
			if (this.fromDelete) {
				this.bsAlert('success', 'Successfully deleted!')
			}

			let url = '/api/users/'+this.$route.params.id;
			this.axios.get(url).then(response => {
				this.user = response.data.user
				this.lists = response.data.lists
				this.isMe = response.data.isMe
			});
		}
	}
</script>