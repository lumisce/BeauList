<template>
	<div v-if="user" class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div v-if="isMe" class="card-header">My Saved Lists ({{items.length}})</div>
					<div v-else class="card-header">{{user.name}}'s Saved Lists ({{items.length}})</div>
					<div v-if="items.length" class="list-group list-group-flush rank-list">
						<div v-for="item in items" :key="item.id" class="list-group-item d-flex">
							<router-link :to="{ name: 'lists.show', params: {id: item.id} }">
								{{item.name}}
							</router-link>
							<span class="ml-auto sub-info">by 
								<router-link class="text-secondary"
									:to="{ name: 'users.show', params: {id: item.user.id} }">
									{{item.user.name}}
								</router-link>
							</span>
						</div>
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

	export default {
		components: {
			Favorite,
			ProductListItem,
			EmptyList,
		},
		data() {
			return {
				items: [],
				user: null,
				isMe: false,
			}
		},
		methods: {
		},
		created() {
			let url = '/api/users/'+this.$route.params.id+'/savedlists'
			this.axios.get(url).then(response => {
				this.items = response.data.items
				this.user = response.data.user
				this.isMe = response.data.isMe
			});
		}
	}
</script>