<template>
	<div class="container">
		<SearchNav :query="query" index="0"/>
		<ais-instant-search :search-client="searchClient" :index-name="index">
			<ais-configure
			  :hits-per-page.camel="20"
			/>
			<div class="row justify-content-center">
				<div class="col-md-8 offset-md-4">
					<ais-search-box placeholder="Search Products..." v-model="query"/>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-4">
					<RefineProductSearch />
				</div>
				<div class="col-md-8">
					<ais-infinite-hits class="mt-4" :classNames="{
						'ais-InfiniteHits-item': 'list-group-item',
						'ais-InfiniteHits-list': 'list-group'}">
						<ProductListItem slot="item" slot-scope="{ item, index }" class=""
							:index="index" :key="item.id" :item="item" :withBrand="true"
							:ratings="[]" :isRanked="false" @bsAlert="bsAlert">
						</ProductListItem>
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
	import RefineProductSearch from '../components/RefineProductSearch'
	import ProductListItem from '../components/ProductListItem'
	import SearchNav from '../components/SearchNav'
	import EmptyList from '../components/EmptyList'
	import pageMixin from '../pageMixin'

	export default {
		mixins: [pageMixin],
		components: {
			RefineProductSearch,
			ProductListItem,
			SearchNav,
			EmptyList,
		},
		data() {
			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				index: process.env.MIX_ALGOLIA_PREFIX+'products',
				query: '',
			}
		},
	}
</script>