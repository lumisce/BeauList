<template>
	<div v-if="item" class="product-list-item list-group-item flex-wrap">
		<i v-if="isEditable" class="fa fa-align-justify align-self-center mr-3 order-item"></i>
		<i v-if="isRanked && index < 3" class="fa fa-certificate rank-bg" :class="rankBgClass"></i>
		<span v-if="isRanked" :class="rankClass">{{index+1}}</span>
	
		<router-link v-if="withBrand" class="d-none d-md-block"
			:to="{ name: 'brands.show', params: {id: item.brand.id} }" >
			<img :src="brandImageUrl">
		</router-link>
		<router-link :to="{ name: 'products.show', params: {id: item.id} }" class="align-items-center">
			<img :src="imageUrl" class="d-none d-md-block">
			<img :src="imageUrl" class="img-small d-md-none">
			<div class="product-info">
				<p class="name"><b>{{item.name}}</b></p>
				<p v-if="withBrand" class="sub-info d-md-none"><b>{{item.brand.name}}</b></p>
				<p class="sub-info">{{qp.quantity}}{{qp.unit}} / 
					 <i class="fa fa-krw" aria-hidden="true"></i>
					{{qp.price}}
				</p>
				<p class="sub-info">
					<span class="avg-rating">
						<i class="rating-icon rating-icon-star fa fa-star"></i>
						 <span>{{ avgRating }} ({{ numRaters }})</span>
					</span>
				</p>
			</div>
		</router-link>
		<div class="product-other">
			<p v-if="withMyRating" class="other-info">
				<i class="rating-icon rating-icon-star fa fa-star"></i>
				 {{item.rating.score}}
			</p>
			<button v-if="hasAdd" type="button" 
				@click="$emit('add', item)" class="btn btn-primary">
				Add
			</button>
			<i v-else-if="isEditable" class="fa fa-times remove-item" 
				@click="$emit('remove')"></i>
			<AddToList v-else :item="item" @reload="$emit('reload')"
				@bsAlert="(msg, status) => $emit('bsAlert', msg, status)">
			</AddToList>
		</div>
		<div v-if="isEditable" class="d-block w-100 mt-2">
			<textarea v-model="note" class="w-100" placeholder="Add a Note" 
				@change="$emit('addNote', item.id, note)">
			</textarea>
		</div>
		<div v-else-if="showNoteText && item.pivot.note.length" 
			class="d-block w-100 mt-2 bg-light p-1">
			<p>{{item.pivot.note}}</p>
		</div>
	</div>
</template>

<script>
	import AddToList from './AddToList'

	export default {
		components: {
			AddToList,
		},
		props: ['item', 'index', 'ratings', 'isRanked', 'withBrand', 
			'withMyRating', 'isEditable', 'hasAdd', 'showNoteText'],
		data() {
			return {
				note: ''
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
				return qps && qps.length ? qps[0] : unknown
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
				var rating = 0;
				if (this.ratings.length || Object.keys(this.ratings).length) {
					rating = this.ratings[this.item.id][0]
				}  else {
					rating = this.item.rating_score
				}
				return rating ? rating.toFixed(2) : '0.00'
			},
			numRaters() {
				if (this.ratings.length || Object.keys(this.ratings).length) {
					return this.ratings[this.item.id][1]
				} else {
					return this.item.rating_count
				}
			}
		},
		watch: {
			isEditable(newval, oldval) {
				this.setNote()
			}
		},
		methods: {
			setNote() {
				if (this.item.pivot && this.item.pivot.note) {
					this.note = this.item.pivot.note
				} else {
					this.note = ''
				}
			}
		},
		created() {
			this.setNote()
		}
	}
</script>