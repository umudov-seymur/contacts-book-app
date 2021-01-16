<template>
  <contact-list endpoint="/api/birthdays" />
</template>

<script>
import ContactList from "../components/ContactList.vue";

export default {
  components: {
    ContactList,
  },
};
</script>

