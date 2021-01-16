<template>
  <form @submit.prevent="saveContacts">
    <div class="grid grid-cols-1 gap-6">
      <input-field v-for="(form, index) in forms" :form="form" :key="index" />
    </div>
    <div class="flex justify-end items-center space-x-3 mt-6">
      <router-link
        :to="{ name: 'contacts.index' }"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-400 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest hover:bg-red-700 hover:border-red-800 hover:text-white focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
      >
        Cancel
      </router-link>
      <loading-btn text="Add New Contact" :isLoading="loading" />
    </div>
  </form>
</template>

<script>
import InputField from "../../components/InputField.vue";
import LoadingBtn from "../../components/LoadingBtn.vue";
import { form_mixin } from "../../mixins/form_mixin";

export default {
  components: { InputField, LoadingBtn },
  mixins: [form_mixin],
  data() {
    return {
      loading: false,
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
  methods: {
    saveContacts() {
      this.loading = true;
      axios
        .post("/api/contacts", this.form_data)
        .then((res) => {
          // clear fields
          this.forms.map((form) => (form.data = ""));

          this.$router.push({
            name: "contacts.show",
            params: { id: res.data.data.contact_id },
          });
        })
        .catch((errors) => {
          this.parseErrors(errors.response.data.errors);
        })
        .finally((err) => (this.loading = false));
    },
  },
  beforeRouteLeave(to, from, next) {
    if (Object.values(this.form_data).some((field) => field.trim() !== "")) {
      const answer = window.confirm(
        "Do you really want to leave? you have unsaved changes!"
      );

      if (answer) {
        next();
      } else {
        next(false);
      }
    } else {
      next();
    }
  },
};
</script>

<style lang="scss" scoped></style>
