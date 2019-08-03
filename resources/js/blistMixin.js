module.exports = {
	methods: {
		addNote(id, note) {
			let i = this.products.findIndex((item) => { return item.id == id })
			if (i >= 0) {
				this.products[i].note = note
			}
		},
		editNote(id, note) {
			console.log('edit'+note)
			let i = this.products.findIndex((item) => { return item.id == id })
			if (i >= 0) {
				this.products[i].pivot.note = note
			}
		},
		remove(i) {
			this.products.splice(i, 1);
		},
		getProductsData(isNew = true) {
			return this.products.map((item, i) => {
				if (isNew) {
					return {'id': item.id, 'note': item.note, 
						'position': i+1}
				} else {
					return {'id': item.id, 'note': item.pivot.note, 
						'position': i+1}
				}
			})
		},
	}
};