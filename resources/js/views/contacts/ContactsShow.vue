<template>
  <loading
    v-if="isLoading"
    class="m-auto"
    spin-class="text-blue-600 w-20 h-20"
  />
  <div v-else @keydown="modal = false">
    <div class="detail-header flex items-center justify-between mb-5">
      <router-link
        :to="{ name: 'contacts.index' }"
        class="text-sm text-blue-500 font-semibold"
      >
        < Back
      </router-link>
      <div class="action-buttons flex relative">
        <router-link
          :to="{ name: 'contacts.update', params: { id: contact.contact_id } }"
          class="px-4 py-2 rounded text-green-500 border border-green-500 text-sm font-bold mr-2"
        >
          Edit
        </router-link>
        <a
          class="px-4 py-2 rounded text-red-500 border border-red-500 text-sm font-bold"
          href="#"
          @click="modal = !modal"
        >
          Delete
        </a>

        <div
          v-if="modal"
          aria-hidden="true"
          class="fixed inset-0 transition-opacity"
        >
          <div class="absolute inset-0 bg-gray-500 opacity-20"></div>
        </div>

        <transition mode="out-in" name="fade">
          <div
            v-if="modal"
            class="absolute bg-blue-900 text-white rounded-lg z-10 p-8 w-64 right-0 mt-12"
          >
            <div class="relative">
              <p>Are you sure you want to delete this record?</p>

              <div class="flex items-center mt-6 justify-end">
                <button class="text-white pr-4" @click="modal = !modal">
                  Cancel
                </button>
                <button
                  class="px-4 py-2 bg-red-500 rounded text-sm font-bold text-white"
                  @click="destroy"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </div>

    <div class="flex items-center">
      <UserCircle :name="contact.name" class="mr-3" />
      <h3 class="font-bold text-lg mr-3 text-blue-500">
        {{ contact.name }}
      </h3>
    </div>

    <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Contact</p>
    <p class="pt-2 text-blue-400">{{ contact.email }}</p>

    <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Company</p>
    <p class="pt-2 text-blue-400">{{ contact.company }}</p>

    <p class="pt-6 text-gray-600 font-bold uppercase text-sm">Birthday</p>
    <p class="pt-2 text-blue-400">{{ contact.birthday }}</p>
  </div>
</template>

<script>
import Loading from "../../components/Loading.vue";
import UserCircle from "../../components/UserCircle.vue";

export default {
  components: { UserCircle, Loading },
  data() {
    return {
      isLoading: true,
      modal: false,
      contact: {},
    };
  },
  created() {
    axios
      .get(`/api/contacts/${this.$route.params.id}`)
      .then((res) => {
        this.contact = res.data.data;
        this.isLoading = false;
      })
      .catch((error) => {
        if (error.response.status === 404) {
          this.$router.push({
            name: "contacts.index",
          });
        }
      });
  },
  methods: {
    destroy() {
      axios.delete(`/api/contacts/${this.contact.contact_id}`).then(() => {
        this.$router.push({
          name: "contacts.index",
        });
      });
    },
  },
};
</script>
