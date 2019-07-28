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
				<p>Products</p>
			</template>
			<template slot="default">
				<ais-refinement-list
					attribute="products.name"
					operator="and"
					:searchable=true
					searchable-placeholder="Search products"
				/>
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Users</p>
			</template>
			<template slot="default">
				<ais-refinement-list
					attribute="user_name"
					operator="or"
					:searchable=true
					searchable-placeholder="Search users"
				/>
			</template>
		</ais-panel>

		<ais-panel>
			<template slot="header">
				<p>Number of Saved</p>
			</template>
			<template slot="default">
				<ais-range-input attribute="saved_count">
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
					'products.name': 'Products', 
					'user_name': 'Users', 
					'product_count': 'Num. of Products', 
					'saved_count': 'Num. of Saved', 
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