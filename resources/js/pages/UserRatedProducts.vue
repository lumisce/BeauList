<template>
	<div v-if="user" class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 d-flex flex-column">
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
					<div v-if="isMe" class="card-header">
						Products I Rated ({{pagination.total}})
					</div>
					<div v-else class="card-header">
						Products {{user.name}} Rated ({{pagination.total}})
					</div>
					<div v-if="items.length" class="list-group list-group-flush rank-list">
						<ProductListItem v-for="(product, index) in items" 
							:index="index" :key="product.id" :item="product" 
							:ratings="ratings" :isRanked="false" :withBrand="true"
							:withMyRating="true"
							@bsAlert="bsAlert">
						</ProductListItem>
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
	import pageMixin from '../pageMixin'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'
	import Pagination from '../components/Pagination'

	export default {
		mixins: [pageMixin],
		components: {
			ProductListItem,
			EmptyList,
			Pagination,
		},
		data() {
			return {
				items: [],
				pagination: {},
				ratings: [],
				user: null,
				isMe: false,
			}
		},
		methods: {
			loadList() {
				const id = this.$route.params.id
				const page = this.pagination.current_page
				const url = '/api/users/'+id+'/ratedproducts?page='+page;
				this.axios.get(url).then(response => {
					this.user = response.data.user;
					this.isMe = response.data.isMe;
					this.items = response.data.items;
					this.pagination = response.data.pagination;
					this.ratings = response.data.ratings;
				});
			}
		},
		created() {
			this.loadList()
		}
	}
</script>