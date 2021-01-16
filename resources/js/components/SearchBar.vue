<template>
  <div>
    <div
      v-if="query"
      aria-hidden="true"
      @click="reset"
      class="fixed inset-0 transition-opacity"
    >
      <div class="absolute inset-0 bg-gray-500 opacity-20"></div>
    </div>

    <div class="search-box relative z-10">
      <div class="absolute inset-y-0 left-0 flex items-center">
        <svg viewBox="0 0 24 24" class="w-5 h-5 ml-3 mt-1">
          <path
            fill-rule="evenodd"
            d="M20.2 18.1l-1.4 1.3-5.5-5.2 1.4-1.3 5.5 5.2zM7.5 12c-2.7 0-4.9-2.1-4.9-4.6s2.2-4.6 4.9-4.6 4.9 2.1 4.9 4.6S10.2 12 7.5 12zM7.5.8C3.7.8.7 3.7.7 7.3s3.1 6.5 6.8 6.5c3.8 0 6.8-2.9 6.8-6.5S11.3.8 7.5.8z"
            clip-rule="evenodd"
          />
        </svg>
      </div>

      <input
        type="text"
        v-model.trim="query"
        @keyup.esc="reset"
        class="rounded-full w-64 border border-gray-400 pl-8 pr-3 py-2 text-sm focus:border-blue-500 focus:shadow focus:bg-gray-100"
        placeholder="Search ..."
      />

      <transition mode="out-in" name="fade">
        <div
          v-if="query.length > 2"
          class="absolute bg-blue-600 text-white rounded-lg py-1 px-4 w-96 right-0 mt-1"
        >
          <p v-if="contacts.length == 0">No search result {{ query }}</p>
          <contact-item
            v-else
            v-for="contact in contacts"
            @click="reset"
            :contact="contact"
            :key="contact.contact_id"
          />
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import ContactItem from "./ContactItem.vue";
import _ from "lodash";

export default {
  data() {
    return {
      query: "",
      contacts: [],
    };
  },
  methods: {
    search: _.debounce(function (e) {
      if (this.query.length > 2) {
        axios
          .get(`/api/search?query=${this.query}`)
          .then((res) => {
            this.contacts = res.data.data;
          })
          .catch((error) => {
            alert("Unable to fetch contacts.");
          });
      }
    }, 1000),

    reset() {
      this.query = "";
      this.contacts = [];
    },
  },
  watch: {
    query(query) {
      this.search(query);
    },
  },
  components: {
    ContactItem,
  },
};
</script>

<style lang="scss" scoped>
</style>
