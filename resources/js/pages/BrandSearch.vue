<template>
	<div class="container">
		<SearchNav index="1"/>
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
			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				index: 'brands',
				query: '',
			}
		},
		methods: {
			imageUrl(path) {
				return '/images/'+path
			}
		},
	}
</script>