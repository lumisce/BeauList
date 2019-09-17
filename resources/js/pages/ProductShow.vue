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
				<div v-if="item" class="card text-center" style="padding:40px;">
					<img :src="item.image" class="mx-auto w-50 h-50">
					<h2>{{item.name}}</h2>
					<router-link :to="{ name: 'brands.show', params: {id: item.brand.id} }" :key="item.brand.id">{{item.brand.name}}</router-link>
					<p>{{item.description}}</p>
					<div v-for="qp in qps">
						<p>
							{{qp.quantity}}{{qp.unit}} / 
							<i class="fa fa-krw" aria-hidden="true"></i>
							{{qp.price}}
						</p>
					</div>
					<router-link :to="{ name: 'categories.show', params: {id: item.category.id} }" :key="item.category.id">{{item.category.name}}</router-link>
					<span class="avg-rating">
						<i class="rating-icon rating-icon-star fa fa-star"></i> 
						<span>{{ avgRating }} ({{ rating[1] }})</span>
					</span>	
					<Favorite :isBrand="false" :favoriteCount="favoriteCount" 
						:isMyFav="isMyFav" @bsAlert="bsAlert">
					</Favorite>
					<Rate :myRating="myRating" @bsAlert="bsAlert"
						@setAvgRating="setAvgRating">
					</Rate>
					<AddToList :item="item" @bsAlert="bsAlert"></AddToList>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import pageMixin from '../pageMixin'
	import Favorite from '../components/Favorite'
	import Rate from '../components/Rate'
	import AddToList from '../components/AddToList'

	export default {
		mixins: [pageMixin],
		components: {
			Favorite,
			Rate,
			AddToList,
		},
		data() {
			return {
				item: null,
				rating: null,
				myRating: 0,
				favoriteCount: 0,
				isMyFav: false,
				qps: [{
					quantity : '-',
					unit: '-',
					currency: '-',
					price: '-'
				}],
			}
		},
		computed: {
			avgRating() {
				return this.rating[0] ? this.rating[0].toFixed(2) : '0.00'
			},
		},
		methods: {
			setQP() {
				let qps = this.item.quantityprices
				this.qps =  qps.length ? qps : this.qps
			},
			setAvgRating(rating) {
				this.rating = rating
			},
			loadData(id) {
				let url = '/api/products/'+id
				this.axios.get(url).then(response => {
					this.item = response.data.item
					this.rating = response.data.rating
					this.favoriteCount = response.data.favoriteCount
					this.isMyFav = response.data.isMyFav
					this.myRating = response.data.myRating
					this.setQP()
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