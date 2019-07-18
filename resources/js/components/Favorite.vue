<template>
	<div>
		<div>
			<span class="fav" :class="{on: isFavorite || !isLoggedIn}" @click="favorite">
				<i class="fav-icon fa fa-heart"></i> <span class="count">{{count}}</span>
			</span>
		</div>
		<p v-if="!isLoggedIn" class="sub-info">Login to Favorite</p>
	</div>
</template>

<script>
	export default {
		props: ['isBrand', 'favoritedBy', 'isMyFav'],
		data() {
			return {
				isFavorite: false,
				count: 0,
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
		},
		methods: {
			favorite() {
				if (this.isLoggedIn) {
					let formdata = {
						'id': this.$route.params.id, 
					}
					let kind = this.isBrand == "true" ? 'brands' : 'products'
					this.axios.post('/api/'+kind+'/favorite', formdata).then(response => {
						let action = 'Added to Favorites!'
						if (response.data.action == 'removed') {
							action = 'Removed from Favorites!'
							this.isFavorite = false
						} else {
							this.isFavorite = true
						}
						this.count = response.data.count
						this.$emit('bsAlert', response.data.status, action)
					}).catch(err => {
						this.$emit('bsAlert', 'error', '')
					})
				}
			},
		},
		created() {
			this.isFavorite = this.isMyFav
			this.count = this.favoritedBy.length
		}
	}
</script>