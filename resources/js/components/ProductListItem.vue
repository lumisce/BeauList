<template>
	<div v-if="item" class="product-list-item list-group-item">
		<i v-if="isRanked && index < 3" class="fa fa-certificate rank-bg" :class="rankBgClass"></i>
		<span v-if="isRanked" :class="rankClass">{{index+1}}</span>
	
		<router-link v-if="withBrand" :to="{ name: 'brands.show', params: {id: item.brand.id} }">
			<img :src="brandImageUrl">
		</router-link>
		<router-link :to="{ name: 'products.show', params: {id: item.id} }">
			<img :src="imageUrl">
			<div class="product-info">
				<p class="name"><b>{{item.name}}</b></p>
				<p class="sub-info">{{qp.quantity}}{{qp.unit}} / <i class="fa fa-krw" aria-hidden="true"></i>{{qp.price}}</p>
				<p class="sub-info"><span class="avg-rating"><i class="rating-icon rating-icon-star fa fa-star"></i> <span>{{ avgRating }} ({{ ratings[item.id][1] }})</span></span></p>
			</div>
		</router-link>
		<div class="product-other">
			<p v-if="withMyRating" class="other-info">
				<i class="rating-icon rating-icon-star fa fa-star"></i>
				 {{item.rating.score}}
			</p>
			<AddToList :item="item" @reload="$emit('reload')"
				@bsAlert="(status, msg) => $emit('bsAlert', status, msg)">
			</AddToList>
		</div>
	</div>
</template>

<script>
	import AddToList from './AddToList'

	export default {
		components: {
			AddToList,
		},
		props: ['item', 'index', 'ratings', 'isRanked', 'withBrand', 'withMyRating'],
		data() {
			return {
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
			qp() {
				let qps = this.item.quantityprices
				let unknown = {
					quantity : '-',
					unit: '-',
					currency: '-',
					price: '-'
				}
				return qps.length ? qps[0] : unknown
			},
			imageUrl() {
				return '/images/'+this.item.image
			},
			brandImageUrl() {
				return '/images/'+this.item.brand.image
			},
			productUrl() {
				return '/products/'+this.item.id
			},
			rankBgClass() {
				return 'rank-bg-'+(this.index+1)
			},
			rankClass() {
				return this.index < 3 ? 'rank-top' : 'rank'
			},
			avgRating() {
				let rating = this.ratings[this.item.id][0]
				return rating ? rating.toFixed(2) : '0.00'
			}
		},
	}
</script>