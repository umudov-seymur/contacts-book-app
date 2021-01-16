<template>
  <div></div>
</template>

<script>
export default {
  created() {
    axios.post("/logout").finally((err) => (window.location = "/login"));
  },
};
</script>

<style lang="scss" scoped>
</style>
