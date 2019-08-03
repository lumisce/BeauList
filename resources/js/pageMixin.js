module.exports = {
	data() {
		return {
			showAlert: false,
			alertSuccess: true,
			alertMessage: '',
		}
	},
	methods: {
		bsError(msg='') {
			if (!msg.length) {
				this.alertMessage = 'Something went wrong. Please try again.'
			} else {
				this.alertMessage = msg
			}
			this.alertSuccess = false
			this.showAlert = true
			setTimeout(() => {
				this.showAlert = false
			}, 3000);
		},
		bsAlert(msg, status='success') {
			this.alertMessage = msg
			this.alertSuccess = status == 'success'
			if (!this.alertSuccess && !msg.length) {
				this.alertMessage = 'Something went wrong. Please try again.'
			} 
			this.showAlert = true
			setTimeout(() => {
				this.showAlert = false
			}, 3000);
		},
	}
};