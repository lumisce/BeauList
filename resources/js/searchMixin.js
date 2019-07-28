module.exports = {
	data() {
		return {
			indices: ['products', 'brands', 'blists'],
			indexNames: ['Products', 'Brands', 'Lists'],
		}
	},
	computed: {
		indexName() {
			return this.indexNames[this.indices.indexOf(this.index)]
		},
	},
};