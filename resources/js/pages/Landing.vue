<template>
	<div>
		<div class="jumbotron jumbotron-fluid landing">

			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 text-center">
						<h1 class="display-4">The website to curate lists of beauty products!</h1>
						<p class="lead">and browse lists curated by other users</p>

						<div v-if="!isLoggedIn">
							<router-link class="mr-1 btn btn-light btn-lg"
								:to="{ name: 'login' }">
								Sign In
							</router-link>
							or
							<router-link class="ml-1 btn btn-outline-light btn-lg"
								:to="{ name: 'search' }">
								Browse
							</router-link>
						</div>
						<div v-else>
							<router-link class="mr-1 btn btn-light btn-lg"
								:to="{ name: 'search' }">
								Browse Products and Lists
							</router-link>
						</div>
					</div>
				</div>
				
			</div>
			<p class="copyright"><a href="https://www.flickr.com/photos/12836528@N00/32695243503">"Used cosmetics shrine"</a><span>by <a href="https://www.flickr.com/photos/12836528@N00">kevin dooley</a></span> is licensed under <a href="https://creativecommons.org/licenses/by/2.0/?ref=ccsearch&atype=html" style="margin-right: 5px;">CC BY 2.0</a><a href="https://creativecommons.org/licenses/by/2.0/?ref=ccsearch&atype=html" target="_blank" rel="noopener noreferrer" style="display: inline-block;white-space: none;opacity: .7;margin-top: 2px;margin-left: 3px;height: 22px !important;"><img style="height: inherit;margin-right: 3px;display: inline-block;" src="https://search.creativecommons.org/static/img/cc_icon.svg" /><img style="height: inherit;margin-right: 3px;display: inline-block;" src="https://search.creativecommons.org/static/img/cc-by_icon.svg" /></a></p>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
			}
		},
		computed: {
			isLoggedIn() {
				return this.$store.getters.isLoggedIn
			},
		},
	}
</script>