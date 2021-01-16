<template>
  <div>
    <router-link
      :to="{ name: `contacts.show`, params: { id: contact.contact_id } }"
      class="flex items-center border-b border-gray-400 py-4"
    >
      <user-circle :name="contact.name" />
        <div class="contact-details flex flex-col ml-3">
            <h3 class="font-semibold text-blue-500">{{ contact.name }}</h3>
            <p class="text-gray-500">{{ contact.company }}</p>
        </div>
    </router-link>
  </div>
</template>

<script>
import UserCircle from "./UserCircle.vue";
export default {
  components: { UserCircle },
  props: {
    contact: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
