<template>
	<nav aria-label="Page navigation">
		<ul class="pagination">
			<li v-if="pagination.current_page > 1" class="page-item">
				<a href="" aria-label="Previous" class="page-link"
					@click.prevent="changePage(pagination.current_page-1)">
					<span aria-hidden="true">«</span>
				</a>
			</li>
			<li v-for="page in pageNumber" class="page-item"
				:class="{'active': page == pagination.current_page}">
				<a href="" @click.prevent="changePage(page)" class="page-link">
					{{page}}
				</a>
			</li>
			<li v-if="pagination.current_page < pagination.last_page" class="page-item">
				<a href="" aria-label="Next" class="page-link"
					@click.prevent="changePage(pagination.current_page+1)">
					<span aria-hidden="true">»</span>
				</a>
			</li>
		</ul>
	</nav>
</template>

<script>
	export default {
		props: {
			pagination: {
				type: Object,
				required: true
			},
			offset: {
				type: Number,
				default: 4
			}
		},
		computed: {
			pageNumber() {
				if (!this.pagination.to) {
					return []
				}
				let from = this.pagination.current_page - this.offset
				if (from < 1) {
					from = 1
				}
				let to = from + (this.offset * 2)
				if (to >= this.pagination.last_page) {
					to = this.pagination.last_page
				}
				let pages = []
				for (let page = from; page <= to; page++) {
					pages.push(page)
				}
				return pages
			}
		},
		methods: {
			changePage(page) {
				this.pagination.current_page = page
				this.$emit('paginate')
			}
		}
	}
</script>