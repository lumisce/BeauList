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
				<div class="card text-center" style="padding:40px;">
					<h2>{{item.name}}</h2>
					<router-link v-if="!isMine"
						:to="{ name: 'users.show', params: {id: item.user.id} }">
						{{item.user.name}}
					</router-link>
					<p>{{item.description}}</p>
					<Save :saveCount="saveCount" :isMySaved="isSaved" 
						:isMine="isMine" @bsAlert="bsAlert">
					</Save>
				</div>

				<div class="card mt-4">
					<div class="card-header">Products ({{Object.keys(products).length}})</div>
					<div v-if="Object.keys(products).length" class="list-group list-group-flush rank-list">
						<ProductListItem v-for="(product, index) in products" 
							:index="index" :key="product.id" :item="product" 
							:ratings="ratings" :isRanked="false" :withBrand="true"
							@bsAlert="bsAlert" @reload="loadList">
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
	import Save from '../components/Save'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'

	export default {
		mixins: [pageMixin],
		components: {
			Save,
			ProductListItem,
			EmptyList,
		},
		data() {
			return {
				item: null,
				products: [],
				ratings: [],
				saveCount: 0,
				isSaved: false,
				isMine: false,
				showAlert: false,
				alertSuccess: true,
				alertMessage: '',
			}
		},
		computed: {
			imageUrl() {
				return this.item ? '/images/'+this.item.image : ''
			},
		},
		methods: {
			loadList() {
				let url = '/api/lists/'+this.$route.params.id;
				this.axios.get(url).then(response => {
					this.item = response.data.item;
					this.products = response.data.products;
					this.ratings = response.data.ratings;
					this.saveCount = response.data.saveCount;
					this.isSaved = response.data.isSaved;
					this.isMine = response.data.isMine;
				});
			}
		},
		created() {
			this.loadList()
		}
	}
</script>