<template>
	<div>
		<ais-panel>
			<template slot="header">
				<p>Category</p>
			</template>
			<template slot="default">
				<ais-hierarchical-menu
					:attributes="['category0_name', 'category1_name']" />
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Brand</p>
			</template>
			<template slot="default">
				<ais-refinement-list
					attribute="brand.name"
					operator="or"
					:searchable=true
					searchable-placeholder="Search brands" />
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Number of Rating</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="rating_count" />
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Rating Score</p>
			</template>
			<template slot="default">
				<ais-rating-menu attribute="rating_score" />
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Status</p>
			</template>
			<template slot="default">
				<ais-toggle-refinement attribute="discontinued"
					label="Discontinued" />
			</template>
		</ais-panel>

	</div>
</template>

<script>
	export default {
		computed: {
			now() {
				return new Date()
			}
		},
		methods: {
			transformDates(items) {
				return items.map(item => this.toDaystamp(new Date(item)))
			},
			toDaystamp(dt) {
				return Math.round(dt.getTime()/1000)
			},
		}
	}
</script>