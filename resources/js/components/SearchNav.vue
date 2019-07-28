<template>
	<div class="row justify-content-center">
		<div class="col-md-8 offset-md-4">
			<div class="mb-2 d-flex nav-pills">
				<router-link :to="routeTo('search.products')" 
					class="nav-link nav-item" :class="selectedClass(0)">
					Products
				</router-link>
				<router-link :to="routeTo('search.brands')" 
					class="nav-link nav-item" :class="selectedClass(1)">
					Brands
				</router-link>
				<router-link :to="routeTo('search.lists')" 
					class="nav-link nav-item" :class="selectedClass(2)">
					Lists
				</router-link>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['query', 'index'],
		methods: {
			routeTo(routeName) {
				if (this.query.length) {
					return { name: routeName, query: {q: this.query} }
				}
				return { name: routeName }
			},
			selectedClass(i) {
				return {'disabled font-weight-bold': this.index==i }
			}
		}
	}
</script>