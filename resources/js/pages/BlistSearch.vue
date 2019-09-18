<template>
	<div class="container">
		<SearchNav :query="query" index="2"/>
		<ais-instant-search :search-client="searchClient" :index-name="index">
			<ais-configure
			  :hits-per-page.camel="20"
			/>
			<div class="row justify-content-center">
				<div class="col-md-8 offset-md-4">
					<ais-search-box placeholder="Search Lists..." v-model="query" />
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-4">
					<RefineBlistSearch />
				</div>
				<div class="col-md-8">
					<ais-infinite-hits class="mt-4" :classNames="{
						'ais-InfiniteHits-item': 'list-group-item',
						'ais-InfiniteHits-list': 'small-list-group'
						}">
						<div slot="item" slot-scope="{ item, index }" class="d-flex list-group-item">
							<router-link
								:to="{ name: 'lists.show', params: {id: item.id} }" >
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
	import RefineBlistSearch from '../components/RefineBlistSearch'
	import SearchNav from '../components/SearchNav'
	import EmptyList from '../components/EmptyList'

	export default {
		components: {
			RefineBlistSearch,
			SearchNav,
			EmptyList,
		},
		data() {
			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				index: process.env.MIX_ALGOLIA_PREFIX+'blists',
				query: '',
			}
		},
	}
</script>