<template>
	<div>
		<p v-if="!isLoggedIn" class="sub-info">Login to Add to List</p>
		<p v-else-if="!lists.length" class="sub-info">Create a List to Add Item in</p>
		<div v-else class="btn-group">
			<button class="btn btn-sm btn-primary dropdown-toggle" 
				type="button" @click.prevent="dropdown" @blur="hideDropdown">
				Add to List
			</button>
			<div class="dropdown-menu" :class="{'show': showDropdown}">
				<button v-for="list in lists" type="button" 
					class="dropdown-item" @mousedown="addToList(list.id)">
					<i class="fa text-primary" :class="checkListClass(list.id)"></i>
				 	{{list.name}}
				</button>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['item'],
		data() {
			return {
				showDropdown: false,
				itemLists: this.item.blists,
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
		methods: {
			checkListClass(id) {
				var isInList = this.itemLists.some(el => el.id == id)
				return isInList ? 'fa-check-square-o' : 'fa-square-o'
			},
			dropdown() {
				this.showDropdown = !this.showDropdown
			},
			hideDropdown() {
				this.showDropdown = false
			},
			addToList(listId) {
				this.hideDropdown()

				if (this.isLoggedIn) {
					let formdata = {
						'id': this.item.id,
						'list': listId
					};
					this.axios.post('/api/products/addtolist', formdata).then(response => {
						let action = ''
						if (response.data.status == 'success') {
							action = 'Added to '+response.data.name+'!'
							if (response.data.action == 'removed') {
								action = 'Removed from '+response.data.name+'!'
							}
							this.itemLists = response.data.lists
							this.$emit('reload')
						}
						this.$emit('bsAlert', action, response.data.status)
					}).catch(err => {
						this.$emit('bsError')
					})
				}
			},
		},
	}
</script>