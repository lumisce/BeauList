<template>
	<div v-if="item" class="container">
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
				<div class="card text-center" :class="{'thick': !editMode}">
					<a v-if="isMine && !editMode" href="#" class="top-right" @click.prevent="edit">
						<i class="fa fa-edit"></i>
					</a>
					<div v-else-if="isMine" class="ml-auto mb-3">
						<a href="#" class="btn btn-outline-secondary" @click.prevent="cancel">
							Cancel
						</a>
						<a href="#" class="ml-1 btn btn-primary" @click.prevent="update">
							Save
						</a>
					</div>
					<form v-if="isMine && editMode" @submit.prevent>
						<div class="form-group row">
							<label for="name" 
								class="col-md-3 col-form-label text-md-right">
								Name
							</label>
							<div class="col-md-8">
								<input id="name" type="text" class="form-control" 
									autofocus required v-model.trim="item.name" 
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
									:rows="rowSize" v-model="item.description">
								</textarea>
							</div>
						</div>
						<button type="button" class="btn btn-danger" 
							@click="deleteItem">Delete</button>
					</form>
					<div v-else>
						<h2>{{item.name}}</h2>
						<router-link v-if="!isMine"
							:to="{ name: 'users.show', params: {id: item.user.id} }">
							{{item.user.name}}
						</router-link>
						<p>{{item.description}}</p>
						<Save :saveCount="saveCount" :isMySaved="isSaved" 
							:isMine="isMine" @bsAlert="bsAlert">
						</Save>
					</div>
				</div>

				<div class="card mt-4">
					<div class="card-header">
						<ul class="nav card-header-pills">
							<li class="nav-item">
								<p class="nav-link">
									Products ({{Object.keys(products).length}})
								</p>
							</li>
							<li v-if="isMine && !editProductsMode" class="nav-item ml-auto">
								<a class="nav-link" href="#"
									@click.prevent="editProducts">
									Edit
								</a>
							</li>
							<div v-else-if="isMine" class="d-flex ml-auto">
								<li class="nav-item">
									<a class="nav-link btn btn-outline-secondary" href="#"
										@click.prevent="cancelProducts">
										Cancel
									</a>
								</li>
								<li class="nav-item ml-1">
									<a class="nav-link btn btn-primary" href="#"
										@click.prevent="updateProducts">
										Apply
									</a>
								</li>
							</div>
						</ul>
					</div>
					<div v-if="Object.keys(products).length" 
						class="list-group list-group-flush rank-list">
						<draggable v-model="products" group="products" 
							@start="drag=true" @end="drag=false">
							<ProductListItem v-for="(product, index) in products" 
								:index="index" :key="product.id" :item="product" 
								:ratings="ratings" :isRanked="false" :withBrand="true"
								@bsAlert="bsAlert" @reload="loadList" :showNoteText="true" 
								:isEditable="editProductsMode" @addNote="editNote" 
								@remove="remove(index)">
							</ProductListItem>
						</draggable>
					</div>
					<EmptyList v-else></EmptyList>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Save from '../components/Save'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'
	import pageMixin from '../pageMixin'
	import blistMixin from '../blistMixin'
	import draggable from 'vuedraggable'

	export default {
		mixins: [pageMixin, blistMixin],
		components: {
			Save,
			ProductListItem,
			EmptyList,
			draggable,
		},
		data() {
			return {
				item: null,
				products: [],
				ratings: [],
				saveCount: 0,
				isSaved: false,
				isMine: false,
				editMode: false,
				editProductsMode: false,
				oldProducts: [],
				oldItem: null,
			}
		},
		computed: {
			imageUrl() {
				return this.item ? '/images/'+this.item.image : ''
			},
			rowSize() {
				return Math.max(3, this.item.description.split('\n').length)
			},
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
		},
		methods: {
			loadList() {
				this.loadData(this.$route.params.id)
			},
			editProducts() {
				this.oldProducts = JSON.parse(JSON.stringify(this.products))
				this.editProductsMode = true
			},
			cancelProducts() {
				this.products = this.oldProducts
				this.editProductsMode = false
			},
			updateProducts() {
				if (this.isLoggedIn && this.isMine) {
					let formdata = {
						_token: this.$csrf,
						products: this.getProductsData(false)
					}
					let url = '/api/lists/'+this.item.id+'/products'
					this.axios.post(url, formdata).then(response => {
						if (response.data.status == 'success') {
							this.bsAlert('Successfully Updated!')
							this.editProductsMode = false
						} else {
							this.bsError()
						}
					}).catch(err => {
						this.bsError()
					})
				}
			},
			edit() {
				this.oldItem = JSON.parse(JSON.stringify(this.item))
				this.editMode = true
			},
			cancel() {
				this.item = this.oldItem
				this.editMode = false
			},
			update() {
				if (this.isLoggedIn && this.isMine) {
					let formdata = {
						_token: this.$csrf,
						_method: 'patch',
						name: this.item.name,
						description: this.item.description.trim(),
					}
					let url = '/api/lists/'+this.item.id
					this.axios.post(url, formdata).then(response => {
						if (response.data.status == 'success') {
							this.bsAlert('Successfully Updated!')
							this.editMode = false
						} else if (response.data.errors) {
							this.bsError(response.data.errors.name[0])
						} else {
							this.bsError()
						}
					}).catch(err => {
						this.bsError()
					})
				}
			},
			deleteItem() {
				if (this.isLoggedIn && this.isMine) {
					let formdata = {
						_token: this.$csrf,
						_method: 'delete'
					}
					let url = '/api/lists/'+this.item.id
					this.axios.post(url, formdata).then(response => {
						if (response.data.status == 'success') {
							this.$router.push({
								name: 'users.show', 
								params: {
									id: this.item.user_id,
									fromDelete: true,
								}
							})
						} else {
							this.bsError()
						}
					}).catch(err => {
						this.bsError()
					})
				}
			},
			loadData(id) {
				let url = '/api/lists/'+id
				this.axios.get(url).then(response => {
					this.item = response.data.item;
					this.products = response.data.products;
					this.ratings = response.data.ratings;
					this.saveCount = response.data.saveCount;
					this.isSaved = response.data.isSaved;
					this.isMine = response.data.isMine;

					this.item.description = 
						this.item.description ? this.item.description : ''
				});
			},
		},
		created() {
			this.loadList()
		},
		beforeRouteUpdate (to, from, next) {
			const id = to.params.id
			this.loadData(id)
			next()
		},
	}
</script>