export const form_mixin = {
    computed: {
        form_data() {
            return Object.fromEntries(this.forms.map(this.getFormEntries));
        }
    },
    methods: {
        getFormEntries(form) {
            return Object.values({
                name: form.name.toLowerCase().trim(),
                data: form.data
            });
        },
        parseErrors(error) {
            this.forms.map(form => {
                const err_field = error[form.name];
                form.err_message = (err_field && err_field[0]) || false;
            });
        }
    }
};
