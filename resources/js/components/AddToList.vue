<template>
	<p v-if="!isLoggedIn" class="sub-info">Login to Add to List</p>
	<p v-else-if="!lists.length" class="sub-info">Create a List to Add Item in</p>
	<div v-else class="dropdown add-to-list">
		<button v-if="lists.length" class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdown-menu-btn">Add to List</button>
		<div v-if="lists.length" class="dropdown-menu" aria-labelledby="dropdown-menu-btn">
			<button v-for="list in lists" type="button" class="dropdown-item" :value="list.id">
				<i class="fa text-primary" :class="checkListClass(list.id)"></i>
			 	{{list.name}}
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['item'],
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
			lists() {
				return this.$store.state.user.blists
			},
		},
		watch: {
			isMyFav(newValue, oldValue) {
				this.isFavorite = newValue
			},
			favoritedBy(newValue, oldValue) {
				this.count = newValue.length
			},
		},
		methods: {
			checkListClass(id) {
				var contains = (el, x) => {
					return el.id == x
				}
				return item.blists.some(containsId(id)) ? 'fa-check-square-o' : 'fa-square-o'
			},
			favorite() {
				if (this.isLoggedIn) {
					let formdata = {
						'id': this.$route.params.id, 
					};
					this.axios.post('/api/brands/favorite', formdata).then(response => {
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
	}
</script>