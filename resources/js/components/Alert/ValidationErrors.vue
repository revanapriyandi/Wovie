<template>
  <div v-if="hasErrors">
    <div
      class="alert alert-dark alert-dismissible fade show"
      role="alert"
      v-for="(error, key) in errors"
      :key="key"
    >
      <span class="alert-text" style="color: white">{{ error }}</span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  computed: {
    errors() {
      return this.$page.props.errors;
    },

    hasErrors() {
      return Object.keys(this.errors).length > 0;
    },
  },
});
</script>
