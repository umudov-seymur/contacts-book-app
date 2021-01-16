<template>
  <label class="block">
    <span
      class="text-sm font-bold uppercase"
      :class="{
        'text-red-500': form.err_message,
        'text-blue-500': !form.err_message,
      }"
    >
      {{ form.label }}
    </span>
    <input
      @input="updateField"
      v-model.trim="form.data"
      :type="form.type"
      class="mt-0 block w-full px-0.5 border-0 border-b-2 text-gray-900 border-gray-200 focus:ring-0 focus:border-blue-400"
      :class="{ 'error-field': form.err_message }"
      :placeholder="form.placeholder"
    />
    <span
      class="text-sm block font-medium text-red-600 mt-2"
      v-if="form.err_message"
    >
      {{ form.err_message }}
    </span>
  </label>
</template>

<script>
export default {
  props: {
    form: {
      type: Object,
      required: true,
    },
  },
  methods: {
    updateField() {
      this.form.err_message = false;
    },
  },
};
</script>

<style scoped>
.error-field {
  @apply border-red-500;
}
</style>
