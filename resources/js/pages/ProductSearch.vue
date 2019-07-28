<template>
	<div class="container">
		<SearchNav :query="query" index="0"/>
		<ais-instant-search :search-client="searchClient" :index-name="index">
			<div class="row justify-content-center">
				<div class="col-md-8 offset-md-4">
					<ais-search-box :placeholder="'Search '+indexName+'...'" v-model="query"/>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-4">
					<RefineProductSearch />
				</div>
				<div class="col-md-8">
					<ais-hits class="mt-4">
						<div slot-scope="{items}">
							<div v-if="items.length" class="list-group">
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
	</div>
</template>

<script>
	import algoliasearch from 'algoliasearch/lite'
	import RefineProductSearch from '../components/RefineProductSearch'
	import ProductListItem from '../components/ProductListItem'
	import SearchNav from '../components/SearchNav'
	import EmptyList from '../components/EmptyList'
	import pageMixin from '../pageMixin'
	import searchMixin from '../searchMixin'
	import { history as historyRouter } from 'instantsearch.js/es/lib/routers'

	export default {
		mixins: [searchMixin, pageMixin],
		components: {
			RefineProductSearch,
			ProductListItem,
			SearchNav,
			EmptyList,
		},
		data() {
			const vueRouter = this.$router

			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				index: 'products',
				query: this.$route.query.q ? this.$route.query.q : '',
				routing: {
					router: this.searchRouter(this.$router),
					stateMapping: {
						stateToRoute(uiState) {
							let routeState = {
								q: uiState.query || '',
								brands:
									(uiState.refinementList &&
										uiState.refinementList['brand.name'] &&
										uiState.refinementList['brand.name'].join('~')),
								category:
									(uiState.hierarchicalMenu &&
										uiState.hierarchicalMenu['category0_name'] &&
										uiState.hierarchicalMenu['category0_name'].join('~')),
								numrating:
									uiState.range &&
									uiState.range['rating_count'] &&
									uiState.range['rating_count'].replace(':', '~'),
								rating:
									uiState.ratingMenu &&
									uiState.ratingMenu['rating_score'],
							}
							if (uiState.toggle && uiState.toggle['discontinued'] &&
								uiState.toggle['discontinued'] == true) {
								routeState['status'] = 'discontinued'
							}

							return routeState
						},
						routeToState(routeState) {
							return {
								query: routeState.q,
								refinementList: {
									'brand.name': routeState.brands && routeState.brands.split('~'),
								},
								hierarchicalMenu: {
									'category0_name': routeState.category && routeState.category.split('~'),
								},
								range: {
									'rating_count': routeState.numrating && routeState.numrating.replace('~', ':'),
								},
								ratingMenu: {
									'rating_score': routeState.rating,
								},
								toggle: {
									'discontinued': routeState.status == 'discontinued',
								},
							}
						},
					},
				},
			}
		},
	}
</script>