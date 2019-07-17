<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="alert-container">
					<transition name="slide-fade">
					<div v-if="showAlert" class="alert" :class="{'alert-success' : alertSuccess, 'alert-danger' : !alertSuccess}" role="alert"><span>{{ alertMessage }}</span></div>
					</transition>
				</div>
				<div class="card text-center" style="padding:40px;">
					<img v-if="item" :src="imageUrl" class="mx-auto" style="height:200px;width:200px;">
					<h2 v-if="item">{{item.name}}</h2>
					<p v-if="item">{{item.description}}</p>
					<Favorite :favoritedBy="favoritedBy" :isMyFav="isMyFav" @bsAlert="bsAlert"></Favorite>
				</div>

				<div class="card mt-4">
					<div class="card-header">Products ({{products.length}})</div>
						<div class="list-group list-group-flush rank-list" id="list-tab" role="tablist">
							<ProductListItem v-for="(product, index) in products" 
								:index="index" :key="product.id" :item="product" :ratings="ratings"></ProductListItem>
						</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Favorite from './Favorite'
	import ProductListItem from './ProductListItem'

	export default {
		components: {
			Favorite,
			ProductListItem,
		},
		data() {
			return {
				item: null,
				products: [],
				ratings: [],
				favoritedBy: [],
				isMyFav: false,
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
			bsAlert(status, msg) {
				this.showAlert = true
				this.alertMessage = msg
				if (status == 'success') {
					this.alertSuccess = true
				} else if (status == 'error') {
					this.alertSuccess = false
					this.alertMessage = 'Something went wrong. Please try again.'
				}
				setTimeout(() => {
					this.showAlert = false
				}, 3000);
			}
		},
		created() {
			let url = '/api/brands/'+this.$route.params.id;
			this.axios.get(url).then(response => {
				this.item = response.data.item;
				this.products = response.data.products;
				this.ratings = response.data.ratings;
				this.favoritedBy = response.data.favoritedBy;
				this.isMyFav = response.data.isMyFav;
			});
		}
	}
</script>