<template>
  <nav aria-label="Page navigation" v-if="showPagination">
    <ul class="pagination pagination-dark justify-content-center">
      <li
        class="page-item"
        v-for="(link, key) in links"
        :key="key"
        v-bind:class="isActive(link)"
      >
        <Link
          class="page-link"
          :href="link.url"
          v-if="link.url"
          v-html="link.label"
        ></Link>
        <a
          class="page-link"
          href="#"
          v-else
          @click.prevent="handleNoLink"
          v-html="link.label"
        ></a>
      </li>
    </ul>
  </nav>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    links: Array,
  },
  components: {
    Link,
  },
  computed: {
    showPagination() {
      return this.links.length > 3;
    },
  },
  methods: {
    isActive(link) {
      return link.active === true ? "active" : "normal";
    },
    handleNoLink() {
      return false;
    },
  },
};
</script>
