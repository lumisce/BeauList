<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 offset-md-4">
				<ais-instant-search :search-client="searchClient" :index-name="index">
					<ais-search-box :placeholder="'Search '+indexName+'...'" v-model="query" />
				</ais-instant-search>
				<div class="d-flex mt-2">
					<div class="form-check input-inline" v-for="(item, idx) in indices" >
						<input v-model="index" class="form-check-input" 
							type="radio" :id="item" :value="item" checked>
						<label class="form-check-label" :for="item">
							{{indexNames[idx]}}
						</label>
					</div>
				</div>
			</div>
		</div>
		<ProductSearch v-if="index==indices[0]" :query="query" :index="index" />
		<BrandSearch v-else-if="index==indices[1]" :query="query" :index="index" />
		<BlistSearch v-else-if="index==indices[2]" :query="query" :index="index" />
	</div>
</template>

<script>
	import algoliasearch from 'algoliasearch/lite'
	import ProductSearch from '../components/ProductSearch'
	import BrandSearch from '../components/BrandSearch'
	import BlistSearch from '../components/BlistSearch'

	export default {
		components: {
			ProductSearch,
			BrandSearch,
			BlistSearch,
		},
		data() {
			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				index: 'products',
				query: '',
				indices: ['products', 'brands', 'blists'],
				indexNames: ['Products', 'Brands', 'Lists']
			}
		},
		computed: {
			indexName() {
				return this.indexNames[this.indices.indexOf(this.index)]
			},
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			}
		},
	}
</script>