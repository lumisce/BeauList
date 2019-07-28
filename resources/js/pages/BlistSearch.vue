<template>
	<div class="container">
		<SearchNav :query="query" index="2"/>
		<ais-instant-search :search-client="searchClient" :index-name="index">
			<div class="row justify-content-center">
				<div class="col-md-8 offset-md-4">
					<ais-search-box :placeholder="'Search '+indexName+'...'" v-model="query" />
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-4">
					<RefineBlistSearch />
				</div>
				<div class="col-md-8">
					<ais-hits class="mt-4">
						<div slot-scope="{items}">
							<div v-if="items.length" class="list-group">
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
	import RefineBlistSearch from '../components/RefineBlistSearch'
	import SearchNav from '../components/SearchNav'
	import EmptyList from '../components/EmptyList'
	import searchMixin from '../searchMixin'

	export default {
		mixins: [searchMixin],
		components: {
			RefineBlistSearch,
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
				index: 'blists',
				query: this.$route.query.q ? this.$route.query.q : '',
				routing: {
					router: this.searchRouter(this.$router),
					stateMapping: {
						stateToRoute(uiState) {
							let routeState = {
								q: uiState.query,
								products:
									uiState.refinementList &&
									uiState.refinementList['products.name'] &&
									uiState.refinementList['products.name'].join('~'),
								users:
									uiState.refinementList &&
									uiState.refinementList['user_name'] &&
									uiState.refinementList['user_name'].join('~'),
								category:
									uiState.hierarchicalMenu &&
									uiState.hierarchicalMenu['category0_name'] &&
									uiState.hierarchicalMenu['category0_name'].join('~'),
								numproduct:
									uiState.range &&
									uiState.range['product_count'] &&
									uiState.range['product_count'].replace(':', '~'),
								numsaved:
									uiState.range &&
									uiState.range['saved_count'] &&
									uiState.range['saved_count'].replace(':', '~'),
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
									'products.name': routeState.products && routeState.products.split('~'),
									'user_name': routeState.users && routeState.users.split('~'),
								},
								hierarchicalMenu: {
									'category0_name': routeState.category && routeState.category.split('~'),
								},
								range: {
									'product_count': routeState.numproduct && routeState.numproduct.replace('~', ':'),
									'saved_count': routeState.numsaved && routeState.numsaved.replace('~', ':'),
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
				}
			}
		},
	}
</script>