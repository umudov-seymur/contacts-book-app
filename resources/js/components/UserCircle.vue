<template>
  <div>
    <a
      class="w-10 h-10 rounded-full bg-blue-400 border border-gray-400 text-white flex justify-center items-center p-3"
      href="#"
      >{{ userCircle }}</a
    >
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: "",
      required: true,
    },
  },
  computed: {
    userCircle() {
      return this.name.match(/[A-Z]/g).slice(0, 2).join("");
    },
  },
};
</script>

