<template>
	<div>
		<nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm sticky-top">
			<div class="container">
				<router-link :to="{ name: 'home' }" class="navbar-brand">{{ title }}</router-link>
				<button class="navbar-toggler" type="button" data-toggle="collapse" 
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
					aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<router-link :to="{ name: 'categories.index' }"
								class="nav-link" :class="{'whiter': onCategories}">
								Categories
							</router-link>
						</li>
						<li class="nav-item">
							<router-link :to="{ name: 'brands.index' }"
								class="nav-link" :class="{'whiter': onBrands}">
								Brands
							</router-link>
						</li>
						<li class="nav-item">
							<router-link :to="{ name: 'search' }" class="nav-link"
								:class="{'whiter': onSearch}">
								Browse
							</router-link>
						</li>
					</ul>

					<!-- Right Side Of Navbar -->
					<AuthNav :user="user"></AuthNav>
				</div>
			</div>
		</nav>

		<main class="py-4">
			<router-view></router-view>
		</main>
	</div>
</template>
<script>
	import AuthNav from './AuthNav'
	export default {
		components: {
			AuthNav
		},
		props: ['title', 'user'],
		data() {
			return {
			}
		},
		computed: {
			onBrands() {
				return this.$route.name == 'brands.index'
			},
			onCategories() {
				return this.$route.name == 'categories.index'
			},
			onSearch() {
				return this.$route.name.split('.')[0] == 'search'
			},
		},
	}
</script>