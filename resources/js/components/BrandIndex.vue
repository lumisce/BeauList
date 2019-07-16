<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">Brands</div>
						<div class="list-group list-group-flush list-small" id="list-tab" role="tablist">
							<a v-for="item in items" :href="brandUrl(item.id)" class="list-group-item"><img :src="imageUrl(item.image)">{{item.name}}</a>
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
				items: []
			}
		},
		methods: {
			brandUrl(id) {
				return '/brands/'+id
			},
			imageUrl(path) {
				return '/images/'+path
			}
		},
		created() {
			this.axios.get('/api/brands').then(response => {
				this.items = response.data.items;
			});
		}
	}
</script>