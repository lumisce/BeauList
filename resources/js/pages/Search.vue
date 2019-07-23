<template>
	<ais-instant-search :search-client="searchClient" :index-name="index">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<ais-search-box :placeholder="'Search '+indexName+'...'"></ais-search-box>
					<div class="d-flex mt-2">
						<div class="form-check input-inline">
							<input v-model="index" class="form-check-input" 
								type="radio" id="index" value="products" checked>
							<label class="form-check-label" for="index">
								Products
							</label>
						</div>
						<div class="form-check input-inline">
							<input v-model="index" class="form-check-input" 
								type="radio" id="index" value="brands">
							<label class="form-check-label" for="index">
								Brands
							</label>
						</div>
						<div class="form-check input-inline">
							<input v-model="index" class="form-check-input" 
								type="radio" id="index" value="blists">
							<label class="form-check-label" for="index">
								Lists
							</label>
						</div>
					</div>
					<ais-hits class="mt-4">
						<div slot-scope="{items}">
							<div v-if="items.length">
								<div v-if="index == 'products' && Number.isInteger(items[0].rating_count)" >
									<ProductListItem v-for="(item, index) in items" class="w-100"
										:index="index" :key="item.id" :item="item" :withBrand="true"
										:ratings="[]" :isRanked="false" @bsAlert="bsAlert">
									</ProductListItem>
								</div>
								<div v-else-if="index == 'brands'">
									<div class="list-group list-small">
										<router-link v-for="item in items" 
											:to="{ name: 'brands.show', params: {id: item.id} }" 
											:key="item.id" class="list-group-item">
											<img :src="imageUrl(item.image)">
											{{item.name}}
										</router-link>
									</div>
								</div>
								<div v-else-if="index == 'blists'">
									<div class="list-group list-small">
										<div v-for="item in items" :key="item.id" class="list-group-item d-flex">
											<router-link :to="{ name: 'lists.show', params: {id: item.id} }">
												{{item.name}} 
												<p v-if="item.products" class="sub-info d-inline">
													({{item.products.length}})
												</p>
											</router-link>
											<span v-if="item.user_id" class="ml-auto sub-info">by 
												<router-link class="text-secondary"
													:to="{ name: 'users.show', params: {id: item.user_id} }">
													{{item.user_name}}
												</router-link>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div v-else class="card">
								<EmptyList></EmptyList>
							</div>
						</div>
					</ais-hits>
				</div>
			</div>
		</div>
	</ais-instant-search>
</template>

<script>
	import algoliasearch from 'algoliasearch/lite'
	import pageMixin from '../pageMixin'
	import Save from '../components/Save'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'

	export default {
		mixins: [pageMixin],
		components: {
			Save,
			ProductListItem,
			EmptyList,
		},
		data() {
			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				index: 'products',
				items: [],
			}
		},
		computed: {
			indexName() {
				return this.index == 'blists' ? 'lists' : this.index
			},
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			}
		},
		created() {
		}
	}
</script>