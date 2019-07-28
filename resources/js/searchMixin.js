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
	methods: {
		searchRouter(vRouter) {
			return {
				read() {
					console.log(vRouter.currentRoute.query)
					return vRouter.currentRoute.query;
				},
				write(routeState) {
					vRouter.push({
						query: routeState,
					});
				},
				createURL(routeState) {
					return vRouter.resolve({
						query: routeState,
					}).href;
				},
				onUpdate(cb) {
					this._onPopState = event => {
						const routeState = event.state;
						if (!routeState) {
							cb(this.read());
						} else {
							cb(routeState);
						}
					};
					window.addEventListener('popstate', this._onPopState);
				},
				dispose() {
					window.removeEventListener('popstate', this._onPopState);
					this.write();
				},
			}
		}
	}
};