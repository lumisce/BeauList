<template>
	<div v-if="item" class="container">
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
				<h2>{{ item.name }}</h2>
				<div class="card mt-4">
					<div class="card-header">Products ({{products.length}})</div>
					<div v-if="products.length" class="list-group list-group-flush rank-list" id="list-tab" role="tablist">
						<ProductListItem v-for="(product, index) in products" 
							:index="index" :key="product.id" :item="product" :withBrand="true"
							:ratings="ratings" :isRanked="true" @bsAlert="bsAlert">
						</ProductListItem>
					</div>
					<EmptyList v-else></EmptyList>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import pageMixin from '../pageMixin'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'

	export default {
		mixins: [pageMixin],
		components: {
			ProductListItem,
			EmptyList,
		},
		data() {
			return {
				item: null,
				products: [],
				ratings: [],
			}
		},
		computed: {
			imageUrl() {
				return this.item ? '/images/'+this.item.image : ''
			},
		},
		methods: {
			loadData(id) {
				let url = '/api/categories/'+id
				this.axios.get(url).then(response => {
					this.item = response.data.item;
					this.products = response.data.products;
					this.ratings = response.data.ratings;
				});
			}
		},
		created() {
			this.loadData(this.$route.params.id)
		},
		beforeRouteUpdate (to, from, next) {
			const id = to.params.id
			this.loadData(id)
			next()
		},
	}
</script>