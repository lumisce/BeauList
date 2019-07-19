<template>
	<p v-if="!isLoggedIn" class="sub-info">Login to Rate or Favorite </p>
	<div v-else @change="rate" class="rating-group">
		<form id="rating-form">
			<input v-model="rating" class="rating-input rating-input-none" name="rating" id="rating-none" value="0" type="radio" checked="checked"/>
			<label for="rating-none" aria-label="No Rating" class="rating-label"><i class="rating-icon rating-icon-none fa fa-times"></i></label>

			<label for="rating-1" aria-label="1 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
			<input v-model="rating" class="rating-input" name="rating" id="rating-1" value="1" type="radio" />

			<label for="rating-2" aria-label="2 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
			<input v-model="rating" class="rating-input" name="rating" id="rating-2" value="2" type="radio" />

			<label for="rating-3" aria-label="3 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
			<input v-model="rating" class="rating-input" name="rating" id="rating-3" value="3" type="radio" />

			<label for="rating-4" aria-label="4 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
			<input v-model="rating" class="rating-input" name="rating" id="rating-4" value="4" type="radio" />

			<label for="rating-5" aria-label="5 Star" class="rating-label"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
			<input v-model="rating" class="rating-input" name="rating" id="rating-5" value="5" type="radio" />
		</form>
	</div>
</template>

<script>
	export default {
		props: ['myRating'],
		data() {
			return {
				rating: this.myRating,
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
		},
		methods: {
			rate() {
				if (this.isLoggedIn) {
					let formdata = {
						'id': this.$route.params.id, 
						'_token': this.$csrf,
						'rating': this.rating
					}
					this.axios.post('/api/products/rate', formdata).then(response => {
						let action = 'Successfully Rated!'
						if (this.rating == 0) {
							action = 'Successfully removed Rating!'
						}
						if (response.data.status == 'success') {
							this.$emit('setAvgRating', response.data.rating)
							this.$emit('bsAlert', 'success', action)
						} else {
							this.$emit('bsAlert', 'error', '')
						}
					}).catch(err => {
						this.$emit('bsAlert', 'error', '')
					})
				}
			},
		},
	}
</script>