<template>
	<div>
		<ais-panel>
			<ais-clear-refinements />
			<ais-current-refinements :transform-items="transformItems"
				:class-names="{'ais-CurrentRefinements-item': 'my-ais-CurrentRefinements-item'}"/>	
		</ais-panel>
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
				<p>Number of Favorites</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="fav_count">
					<div slot-scope="{currentRefinement, range, refine}">
						<vue-slider
							:min="range.min"
							:max="range.max"
							:value="toValue(currentRefinement, range)"
							@change="refine({ min: $event[0], max: $event[1] })">
						</vue-slider>
					</div>
				</ais-range-input>
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Number of Ratings</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="rating_count">
					<div slot-scope="{currentRefinement, range, refine}">
						<vue-slider
							:min="range.min"
							:max="range.max"
							:value="toValue(currentRefinement, range)"
							@change="refine({ min: $event[0], max: $event[1] })">
						</vue-slider>
					</div>
				</ais-range-input>
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
	import VueSlider from 'vue-slider-component'
	import 'vue-slider-component/theme/antd.css'

	export default {
		components: {
			VueSlider,
		},
		methods: {
			toValue(value, range) {
				return [
					value.min !== null ? value.min : range.min,
					value.max !== null ? value.max : range.max,
				];
			},
			transformItems(items) {
				const labels = {
					'brand.name': 'Brands', 
					'category0_name': 'Category', 
					'rating_count': 'Num. of Rating', 
					'rating_score': 'Rating Score'
				}

				items.forEach(item => {
					if (labels[item.label]) {
						item.label = labels[item.label]
					}
				})
				return items
			}
		}
	}
</script>