<template>
  <button
    :disabled="isLoading"
    :class="{ 'disabled:opacity-50': isLoading }"
    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150"
  >
    <Loading v-if="isLoading" />
    <span>{{ text }}</span>
  </button>
</template>

<script>
import Loading from "./Loading.vue";

export default {
  components: { Loading },
  props: {
    isLoading: {
      type: Boolean,
      default: false,
    },
    text: {
      type: String,
      required: true,
    },
  },
};
</script>
