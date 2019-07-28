<template>
	<div class="container">
		<SearchNav :query="query" index="1"/>
		<ais-instant-search :search-client="searchClient" :index-name="index">
			<div class="row justify-content-center">
				<div class="col-md-8 offset-md-4">
					<ais-search-box :placeholder="'Search '+indexName+'...'" v-model="query"/>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-4">
					<RefineBrandSearch />
				</div>
				<div class="col-md-8">
					<ais-hits class="mt-4">
						<div slot-scope="{items}">
							<div v-if="items.length" class="list-group list-small">
								<router-link v-for="item in items" 
									:to="{ name: 'brands.show', params: {id: item.id} }" 
									:key="item.id" class="list-group-item">
									<img :src="imageUrl(item.image)">
									{{item.name}}
								</router-link>
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
	import RefineBrandSearch from '../components/RefineBrandSearch'
	import SearchNav from '../components/SearchNav'
	import EmptyList from '../components/EmptyList'
	import searchMixin from '../searchMixin'

	export default {
		mixins: [searchMixin],
		components: {
			RefineBrandSearch,
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
				index: 'brands',
				query: this.$route.query.q ? this.$route.query.q : '',
				routing: {
					router: this.searchRouter(this.$router),
					stateMapping: {
						stateToRoute(uiState) {
							let routeState = {
								q: uiState.query,
								numproduct:
									uiState.range &&
									uiState.range['product_count'] &&
									uiState.range['product_count'].replace(':', '~'),
								numfav:
									uiState.range &&
									uiState.range['fav_count'] &&
									uiState.range['fav_count'].replace(':', '~'),
							}
							return routeState
						},
						routeToState(routeState) {
							return {
								query: routeState.q,
								range: {
									'product_count': routeState.numproduct && routeState.numproduct.replace('~', ':'),
									'fav_count': routeState.numfav && routeState.numfav.replace('~', ':'),
								},
							}
						},
					},
				}
			}
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			}
		},
	}
</script>