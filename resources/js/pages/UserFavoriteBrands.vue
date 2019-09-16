<template>
	<div v-if="user" class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 d-flex flex-column">
				<div class="card">
					<div v-if="isMe" class="card-header">
						My Favorite Brands ({{pagination.total}})
					</div>
					<div v-else class="card-header">
						{{user.name}}'s Favorite Brands ({{pagination.total}})
					</div>
					<div v-if="items.length" class="list-group list-group-flush list-small">
						<router-link v-for="item in items" 
							:to="{ name: 'brands.show', params: {id: item.id} }" 
							:key="item.id" class="list-group-item">
							<img :src="imageUrl(item.image)">
							{{item.name}}
						</router-link>
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
	import EmptyList from '../components/EmptyList'
	import Pagination from '../components/Pagination'
	
	export default {
		components: {
			EmptyList,
			Pagination,
		},
		data() {
			return {
				items: [],
				pagination: {},
				user: null,
				isMe: false
			}
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			},
			loadList() {
				const id = this.$route.params.id
				const page = this.pagination.current_page
				const url = '/api/users/'+id+'/favbrands?page='+page;
				this.axios.get(url).then(response => {
					this.user = response.data.user;
					this.isMe = response.data.isMe;
					this.items = response.data.items;
					this.pagination = response.data.pagination;
				});
			}
		},
		created() {
			this.loadList()
		}
	}
</script>