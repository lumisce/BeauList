<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
			<h1>{{ title }}</h1>
			<p>{{ message }}</p>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			code: {
				type: Number,
			},
			message: {
				type: String,
				default: "Sorry, Something went wrong"
			}
		},
		computed: {
			title() {
				return this.code ? 'Error '+this.code : 'Error'
			}
		},
	}
</script>