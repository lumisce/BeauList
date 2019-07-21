<template>
	<div v-if="user" class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div v-if="isMe" class="card-header">
						My Favorite Brands ({{items.length}})
					</div>
					<div v-else class="card-header">
						{{user.name}}'s Favorite Brands ({{items.length}})
					</div>
						<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
							<router-link v-for="item in items" 
								:to="{ name: 'brands.show', params: {id: item.id} }" 
								:key="item.id" class="list-group-item">
								<img :src="imageUrl(item.image)">
								{{item.name}}
							</router-link>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				items: [],
				user: null,
				isMe: false
			}
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			}
		},
		created() {
			let url = '/api/users/'+this.$route.params.id+'/favbrands';
			this.axios.get(url).then(response => {
				this.items = response.data.items;
				this.user = response.data.user;
				this.isMe = response.data.isMe;
			});
		}
	}
</script>