<template>
	<ais-instant-search :search-client="searchClient" :index-name="index">
		<div class="row justify-content-center">
			<ais-configure :query="query" />
			<div class="col-md-4">
				<RefineBlistSearch />
			</div>
			<div class="col-md-8">
				<ais-hits class="mt-4">
					<div slot-scope="{items}">
						<div v-if="items.length" class="list-group list-small">
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
</template>

<script>
	import algoliasearch from 'algoliasearch/lite'
	import RefineBlistSearch from '../components/RefineBlistSearch'
	import EmptyList from '../components/EmptyList'

	export default {
		components: {
			RefineBlistSearch,
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