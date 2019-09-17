<template>
	<div class="container">
		<SearchNav index="1"/>
		<ais-instant-search :search-client="searchClient" :index-name="index">
			<ais-configure
			  :hits-per-page.camel="20"
			/>
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
					<ais-infinite-hits class="mt-4" :classNames="{
						'ais-InfiniteHits-item': 'list-group-item',
						'ais-InfiniteHits-list': 'small-list-group'}">
						<router-link slot="item" slot-scope="{ item, index }"
							:to="{ name: 'brands.show', params: {id: item.id} }" 
							class="list-group-item">
							<img :src="item.image">
							{{item.name}}
						</router-link>
						<div slot="loadMore" slot-scope="{ page, isLastPage, refineNext }" 
							class="w-100 d-flex justify-content-center">
							<button :disabled="isLastPage" @click="refineNext" 
								class="btn-primary mt-2 p-1 px-2 showMore">
								Show more results
							</button>
						</div>
					</ais-infinite-hits>
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
	}
</script>