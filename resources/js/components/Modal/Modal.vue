<template>
  <div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    :id="id"
    :aria-labelledby="id"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: {
    id: {
      type: String,
      required: true,
    },
  },
});
</script>
