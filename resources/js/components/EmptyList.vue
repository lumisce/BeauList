<template>
	<div class="text-center p-4">
		<h1><i class="fa fa-exclamation text-secondary"></i></h1>
		<p v-if="text" class="sub-info">{{text}}</p>
		<p v-else class="sub-info">No Items Here</p>
	</div>
</template>

<script>
	export default {
		props: ['text']
	}
</script>