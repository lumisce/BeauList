<template>
	<ais-instant-search :search-client="searchClient" :index-name="index">
		<div class="row justify-content-center">
			<ais-configure :query="query" />
			<div class="col-md-4">
				<RefineProductSearch />
			</div>
			<div class="col-md-8">
				<ais-hits class="mt-4">
					<div slot-scope="{items}">
						<div v-if="items.length" class="list-group list-small">
							<ProductListItem v-for="(item, index) in items" class="w-100"
								:index="index" :key="item.id" :item="item" :withBrand="true"
								:ratings="[]" :isRanked="false" @bsAlert="bsAlert">
							</ProductListItem>
						</div>
						<div v-else class="card">
							<EmptyList></EmptyList>
						</div>
					</div>
				</ais-hits>
			</div>
		</div>
	</ais-instant-search>
</template>

<script>
	import algoliasearch from 'algoliasearch/lite'
	import RefineProductSearch from '../components/RefineProductSearch'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'
	import pageMixin from '../pageMixin'

	export default {
		mixins: [pageMixin],
		components: {
			RefineProductSearch,
			ProductListItem,
			EmptyList,
		},
		props: ['query', 'index'],
		data() {
			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				items: [],
			}
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			}
		},
	}
</script>