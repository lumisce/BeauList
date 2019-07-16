<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="alert-container">
				</div>
				<div class="card text-center" style="padding:40px;">
					<img v-if="item" :src="imageUrl(item.image)" class="mx-auto" style="height:200px;width:200px;">
					<h2 v-if="item">{{item.name}}</h2>
					<p v-if="item">{{item.description}}</p>
					<!-- Favorite -->
				</div>

				<div class="card mt-4">
					<div class="card-header">Products ({{products.length}})</div>
						<div class="list-group list-group-flush rank-list" id="list-tab" role="tablist">
							<!-- ProductListItem     v-for -->
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
				item: null,
				products: [],
				ratings: [],
			}
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			}
		},
		created() {
			let url = this.$domain+'/api/brands/'+this.$route.params.id;
			console.log(url);
			this.axios.get(url).then(response => {
				this.item = response.data.item;
				this.products = response.data.products;
				this.products = response.data.products;
				this.ratings = response.data.ratings;
				console.log(response);
			});
		}
	}
</script>