module.exports = {
	methods: {
		bsAlert(status, msg) {
			this.showAlert = true
			this.alertMessage = msg
			if (status == 'success') {
				this.alertSuccess = true
			} else if (status == 'error') {
				this.alertSuccess = false
				this.alertMessage = 'Something went wrong. Please try again.'
			}
			setTimeout(() => {
				this.showAlert = false
			}, 3000);
		}
	}
};