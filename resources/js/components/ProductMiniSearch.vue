<template>
	<div class="mt-4">
		<ais-instant-search :search-client="searchClient" index-name="products">
			<ais-configure :hitsPerPage="5" />
			
			<ais-search-box :placeholder="'Search Products...'" v-model="query"/>

			<ais-hits v-if="query.length">
				<div slot-scope="{items}">
					<div v-if="items.length" class="list-group">
						<ProductListItem v-for="(item, index) in items" class="w-100"
							:index="index" :key="item.id" :item="item" :withBrand="true"
							:ratings="[]" :isRanked="false" :inListCreate="true" 
							@add="$emit('add', item)" hasAdd="true">
						</ProductListItem>
					</div>
					<div v-else class="card">
						<EmptyList text="No items found"></EmptyList>
					</div>
				</div>
			</ais-hits>
		</ais-instant-search>
	</div>
</template>

<script>
	import algoliasearch from 'algoliasearch/lite'
	import ProductListItem from '../components/ProductListItem'
	import EmptyList from '../components/EmptyList'

	export default {
		components: {
			ProductListItem,
			EmptyList
		},
		data() {
			return {
				searchClient: algoliasearch(
					process.env.MIX_ALGOLIA_APP_ID,
					process.env.MIX_ALGOLIA_SEARCH
				),
				query: '',
			}
		},
	}
</script>