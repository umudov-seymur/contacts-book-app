<template>
  <loading v-if="loading" spin-class="text-blue-600 w-20 h-20" class="m-auto" />
  <div v-else>
    <span class="font-bold text-red-500 text-sm border-b block pb-2">
      Last Updated:
      <span class="text-black font-semibold">{{ contact.last_updated }}</span>
    </span>
    <form @submit.prevent="updateContacts" class="mt-5">
      <div class="grid grid-cols-1 gap-6">
        <input-field v-for="(form, index) in forms" :form="form" :key="index" />
      </div>
      <div class="flex justify-end items-center space-x-3 mt-6">
        <router-link
          :to="{ name: 'contacts.show', params: { id: contact.contact_id } }"
          class="inline-flex items-center px-4 py-2 bg-white border border-gray-400 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-700 hover:border-red-800 hover:text-white focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
        >
          Cancel
        </router-link>
        <loading-btn text="Save Changes" :isLoading="loading" />
      </div>
    </form>
  </div>
</template>

<script>
import InputField from "../../components/InputField.vue";
import Loading from "../../components/Loading.vue";
import LoadingBtn from "../../components/LoadingBtn.vue";
import { form_mixin } from "../../mixins/form_mixin";

export default {
  components: { InputField, LoadingBtn, Loading },
  mixins: [form_mixin],
  data() {
    return {
      loading: true,
      contact: {},
      error: "",
      forms: [
        {
          label: "Name",
          placeholder: "Contact Name",
          name: "name",
          type: "text",
          data: "",
          err_message: false,
        },
        {
          label: "Email",
          placeholder: "Contact Email",
          name: "email",
          type: "email",
          data: "",
          err_message: false,
        },
        {
          label: "Company",
          placeholder: "Contact Company",
          name: "company",
          type: "text",
          data: "",
          err_message: false,
        },
        {
          label: "Birthday",
          placeholder: "MM/DD/YYYY",
          name: "birthday",
          type: "date",
          data: "",
          err_message: false,
        },
      ],
    };
  },
  mounted() {
    axios
      .get(`/api/contacts/${this.$route.params.id}`)
      .then((res) => {
        this.contact = res.data.data;

        this.forms.forEach((form) => {
          form.data = this.contact[form.name];
        });

        this.loading = false;
      })
      .catch((error) => {
        this.loading = false;

        if (error.response.status === 404) {
          this.$router.push({
            name: "contacts.index",
          });
        }
      });
  },
  methods: {
    setFieldData(f) {
      let field = this.forms.find((form) => form.name == f);
      if (field !== undefined) {
        field.data = data[field.name];
      }
    },
    updateContacts() {
      this.loading = true;
      const { contact_id } = this.contact;

      axios
        .put(`/api/contacts/${contact_id}`, this.form_data)
        .then((res) => {
          this.$router.push({
            name: "contacts.show",
            params: { id: contact_id },
          });
        })
        .catch((errors) => {
          this.parseErrors(errors.response.data.errors);
        })
        .finally((err) => (this.loading = false));
    },
  },
};
</script>

<style lang="scss" scoped></style>
