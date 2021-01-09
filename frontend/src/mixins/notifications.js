export const notifications = {
    methods: {
        errorNotify(message) {
            this.$notify({type: 'danger', verticalAlign: 'top', horizontalAlign: 'center', message: message});
        },
        successNotify(message) {
            this.$notify({type: 'success', verticalAlign: 'top', horizontalAlign: 'center', message: message});
        },
    }
};