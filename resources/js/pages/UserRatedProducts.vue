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
						Products I Rated ({{items.length}})
					</div>
					<div v-else class="card-header">
						Products {{user.name}} Rated ({{items.length}})
					</div>
					<div v-if="items.length" class="list-group list-group-flush rank-list">
						<ProductListItem v-for="(product, index) in items" 
							:index="index" :key="product.id" :item="product" 
							:ratings="ratings" :isRanked="false" :withBrand="true"
							:withMyRating="true"
							@bsAlert="bsAlert">
						</ProductListItem>
					</div>
					<EmptyList v-else></EmptyList>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import pageMixin from '../pageMixin'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'

	export default {
		mixins: [pageMixin],
		components: {
			ProductListItem,
			EmptyList,
		},
		data() {
			return {
				items: [],
				ratings: [],
				user: null,
				isMe: false,
			}
		},
		methods: {
			loadList() {
				let url = '/api/users/'+this.$route.params.id+'/ratedproducts';
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