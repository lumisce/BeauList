<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 d-flex flex-column">
				<div class="card">
					<div class="card-header">Brands</div>
					<div class="list-group list-group-flush list-small">
						<router-link v-for="item in items" 
							:to="{ name: 'brands.show', params: {id: item.id} }" 
							:key="item.id" class="list-group-item">
							<img :src="item.image">
							{{item.name}}
						</router-link>
					</div>
				</div>
				<Pagination :pagination="pagination" 
					@paginate="loadList()" class="mt-2 align-self-center">
				</Pagination>
			</div>
		</div>
	</div>
</template>

<script>
	import Pagination from '../components/Pagination'

	export default {
		components: {
			Pagination,
		},
		data() {
			return {
				items: [],
				pagination: {},
			}
		},
		methods: {
			loadList() {
				const page = this.pagination.current_page
				const url = '/api/brands?page='+page;
				this.axios.get(url).then(response => {
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