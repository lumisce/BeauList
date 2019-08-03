<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="alert-container">
					<transition name="slide-fade">
					<div v-if="showAlert" class="alert" 
						:class="{'alert-success': alertSuccess, 
						'alert-danger': !alertSuccess}" role="alert">
						<span>{{ alertMessage }}</span>
					</div>
					</transition>
				</div>
				<div class="card">
					<div class="card-header">Create New List</div>
					<div class="card-body">
						<form @submit.prevent>
							<div class="form-group row">
								<label for="name" 
									class="col-md-3 col-form-label text-md-right">
									Name
								</label>
								<div class="col-md-8">
									<input id="name" type="text" class="form-control" 
										autofocus required v-model.trim="name" 
										@keydown.enter.prevent>
								</div>
							</div>
							 <div class="form-group row">
								<label for="description" 
									class="col-md-3 col-form-label text-md-right">
									Description
								</label>
								<div class="col-md-8">
									<textarea id="description" class="form-control" 
										:rows="rowSize" v-model="description">
									</textarea>
								</div>
							</div>
						</form>
					</div>
				</div>

				<ProductMiniSearch @add="add" />

				<div class="card mt-4">
					<div class="card-header">Products</div>
					<div v-if="products.length" class="list-group list-group-flush rank-list">
						<draggable v-model="products" group="products" 
							@start="drag=true" @end="drag=false">
							<ProductListItem v-for="(product, index) in products" 
								:index="index" :key="product.id" :item="product" 
								:ratings="[]" :isRanked="false" :withBrand="true" 
								:isEditable="true" @addNote="addNote" 
								@remove="remove(index)">
							</ProductListItem>
						</draggable>
					</div>
					<EmptyList v-else></EmptyList>
				</div>
			</div>
		</div>
		<div style="height:10rem"></div>
		<div class="row justify-content-center fixed-bottom bg-white p-3 shadow-sm">
			<div class="col-md-8 d-flex">
				<button type="button" class="btn btn-primary ml-auto" 
					@click="createList">
					Create
				</button>
			</div>
		</div>
	</div>
</template>

<script>
	import ProductMiniSearch from '../components/ProductMiniSearch'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'
	import pageMixin from '../pageMixin'
	import blistMixin from '../blistMixin'
	import draggable from 'vuedraggable'

	export default {
		mixins: [pageMixin, blistMixin],
		components: {
			ProductMiniSearch,
			ProductListItem,
			EmptyList,
			draggable,
		},
		data() {
			return {
				name: '',
				description: '',
				products: [],
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
			rowSize() {
				return Math.max(5, this.description.split('\n').length)
			}
		},
		methods: {
			add(product) {
				let hasId = this.products.some((item) => { return item.id == product.id })
				if (this.products.length && hasId) {
					this.bsAlert('error', product.name+" has already been added!")
				} else {
					product['note'] = ''
					this.products.push(product)
				}
			},
			createList() {
				if (this.isLoggedIn) {
					let formdata = {
						'_token': this.$csrf,
						'name': this.name,
						'description': this.description.trim(),
						'products': this.getProductsData()
					}
					this.axios.post('/api/lists', formdata).then(response => {
						if (response.data.status == 'success') {
							this.$router.push('/lists/'+response.data.id)
						} else if (response.data.errors) {
							this.bsAlert('error', response.data.errors.name[0])
						} else {
							this.bsAlert('error', '')
						}
					}).catch(err => {
						this.bsAlert('error', '')
					})
				}
			},
		},
	}
</script>