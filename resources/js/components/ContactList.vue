<template>
  <loading
    v-if="isLoading"
    class="m-auto"
    spin-class="text-blue-600 w-20 h-20"
  />
  <div v-else>
    <p v-if="contacts.length === 0">
      No contacts yet.
      <router-link :to="{ name: 'contacts.create' }" class="text-blue-500"
        >Get Started >
      </router-link>
    </p>
    <div v-for="contact in contacts" :key="contact.contact_id">
      <contact-item :contact="contact" />
    </div>
  </div>
</template>

<script>
import ContactItem from "./ContactItem.vue";
import Loading from "./Loading";

export default {
  data() {
    return {
      isLoading: true,
      contacts: [],
    };
  },
  components: {
    Loading,
    ContactItem,
  },
  props: {
    endpoint: {
      type: "",
      required: true,
    },
  },
  mounted() {
    axios
      .get(this.endpoint)
      .then((res) => {
        this.contacts = res.data.data;
        this.isLoading = false;
      })
      .catch((error) => {
        this.loading = false;
        alert("Unable to fetch contacts.");
      });
  },
};
</script>
