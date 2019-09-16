<template>
	<div v-if="user" class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 d-flex flex-column">
				<div class="card">
					<div v-if="isMe" class="card-header">My Saved Lists ({{pagination.total}})</div>
					<div v-else class="card-header">{{user.name}}'s Saved Lists ({{pagination.total}})</div>
					<div v-if="pagination.total" class="list-group list-group-flush rank-list">
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
				<Pagination :pagination="pagination" 
					@paginate="loadList()" class="mt-2 align-self-center">
				</Pagination>
			</div>
		</div>
	</div>
</template>

<script>
	import Favorite from '../components/Favorite'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'
	import Pagination from '../components/Pagination'

	export default {
		components: {
			Favorite,
			ProductListItem,
			EmptyList,
			Pagination,
		},
		data() {
			return {
				items: [],
				pagination: {},
				user: null,
				isMe: false,
			}
		},
		methods: {
			loadList() {
				const id = this.$route.params.id
				const page = this.pagination.current_page
				const url = '/api/users/'+id+'/savedlists?page='+page;
				this.axios.get(url).then(response => {
					this.user = response.data.user
					this.isMe = response.data.isMe
					this.items = response.data.items
					this.pagination = response.data.pagination
				});
			}
		},
		created() {
			this.loadList()
		}
	}
</script>