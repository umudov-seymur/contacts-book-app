<template>
  <contact-list endpoint="/api/contacts" />
</template>

<script>
import ContactList from "../../components/ContactList.vue";

export default {
  components: {
    ContactList,
  },
};
</script>

