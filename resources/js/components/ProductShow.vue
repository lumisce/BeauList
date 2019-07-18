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
					<img :src="imageUrl" class="mx-auto w-50 h-50">
					<h2>{{item.name}}</h2>
					<p>{{item.description}}</p>
					<Favorite isBrand="false" :favoritedBy="favoritedBy" 
						:isMyFav="isMyFav" @bsAlert="bsAlert">
					</Favorite>
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
			let url = '/api/products/'+this.$route.params.id;
			this.axios.get(url).then(response => {
				this.item = response.data.item;
				this.rating = response.data.rating;
				this.favoritedBy = response.data.favoritedBy;
				this.isMyFav = response.data.isMyFav;
			});
		}
	}
</script>