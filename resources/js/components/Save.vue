<template>
	<div>
		<div>
			<span class="fav" :class="onClass" @click="save">
				<i class="fav-icon fa fa-bookmark"></i> <span class="count">{{count}}</span>
			</span>
		</div>
		<p v-if="!isLoggedIn" class="sub-info">Login to Save this List</p>
	</div>
</template>

<script>
	export default {
		props: ['saveCount', 'isMySaved', 'isMine'],
		data() {
			return {
				isSaved: this.isMySaved,
				count: this.saveCount,
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
			onClass() {
				return {on: this.isSaved || !this.isLoggedIn || this.isMine}
			}
		},
		methods: {
			save() {
				if (this.isLoggedIn && !this.isMine) {
					let formdata = {
						'id': this.$route.params.id, 
					}
					this.axios.post('/api/lists/save', formdata).then(response => {
						let action = 'Added to Saved Lists!'
						if (response.data.action == 'removed') {
							action = 'Removed from Saved Lists!'
							this.isSaved = false
						} else {
							this.isSaved = true
						}
						this.count = response.data.count
						this.$emit('bsAlert', action, response.data.status)
					}).catch(err => {
						this.$emit('bsError')
					})
				}
			},
		},
	}
</script>