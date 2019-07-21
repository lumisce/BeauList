<template>
	<div v-if="user" class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="alert-container">
					<transition name="slide-fade">
					<div v-if="showAlert" class="alert" 
						:class="{'alert-success': alertSuccess, 'alert-danger': !alertSuccess}" 
						role="alert">
						<span>{{ alertMessage }}</span>
					</div>
					</transition>
				</div>
				<div class="card">
					<div v-if="isMe" class="card-header">
						My Favorite Products ({{items.length}})
					</div>
					<div v-else class="card-header">
						{{user.name}}'s Favorite Products ({{items.length}})
					</div>
					<div class="list-group list-group-flush rank-list" role="tablist">
						<ProductListItem v-for="(product, index) in items" 
							:index="index" :key="product.id" :item="product" 
							:ratings="ratings" :isRanked="false" :withBrand="true"
							@bsAlert="bsAlert">
						</ProductListItem>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import pageMixin from '../pageMixin'
	import ProductListItem from '../components/ProductListItem'

	export default {
		mixins: [pageMixin],
		components: {
			ProductListItem,
		},
		data() {
			return {
				items: [],
				ratings: [],
				user: null,
				isMe: false,
				showAlert: false,
				alertSuccess: true,
				alertMessage: '',
			}
		},
		methods: {
			loadList() {
				let url = '/api/users/'+this.$route.params.id+'/favproducts';
				this.axios.get(url).then(response => {
					this.items = response.data.items;
					this.ratings = response.data.ratings;
					this.user = response.data.user;
					this.isMe = response.data.isMe;
				});
			}
		},
		created() {
			this.loadList()
		}
	}
</script>