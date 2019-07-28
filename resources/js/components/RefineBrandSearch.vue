<template>
	<div>
		<ais-panel>
			<ais-clear-refinements />
			<ais-current-refinements :transform-items="transformItems"
				:class-names="{'ais-CurrentRefinements-item': 'my-ais-CurrentRefinements-item'}"/>	
		</ais-panel>
		<ais-panel>
			<template slot="header">
				<p>Number of Products</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="product_count">
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
					'product_count': 'Num. of Products', 
					'fav_count': 'Num. of Favorites', 
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