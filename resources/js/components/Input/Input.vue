<template>
  <input
    class="form-control"
    @input="$emit('update:modelValue', $event.target.value)"
    :value="modelValue"
    ref="input"
  />
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ["modelValue"],

  emits: ["update:modelValue"],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
});
</script>
