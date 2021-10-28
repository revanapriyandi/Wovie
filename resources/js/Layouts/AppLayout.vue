<template>
  <div>
    <Head :title="title" />
    <Aside />
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      <Navbar :page="page" :subpage="subpage" />
      <div class="container-fluid py-4">
        <slot></slot>
      </div>
    </main>
  </div>
</template>

<script>
import Aside from "@/components/Aside";
import Navbar from "@/components/Navbar";

import { Head } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Aside,
    Navbar,
    Head,
  },

  watch: {
    "$page.props.flash": {
      handler() {
        if (this.$page.props.flash.success) {
          this.$toast.show(this.$page.props.flash.success);
        } else if (this.$page.props.flash.error) {
          this.$toast.show(this.$page.props.flash.error, {
            type: "error",
          });
        } else if (this.$page.props.flash.warning) {
          this.$toast.show(this.$page.props.flash.warning, {
            type: "warning",
          });
        } else if (this.$page.props.flash.info) {
          this.$toast.show(this.$page.props.flash.info, {
            type: "info",
          });
        }
      },
      deep: true,
    },
  },

  mounted() {
    // Toggle Sidenav
    const iconNavbarSidenav = document.getElementById("iconNavbarSidenav");
    const iconSidenav = document.getElementById("iconSidenav");
    const sidenav = document.getElementById("sidenav-main");
    let body = document.getElementsByTagName("body")[0];
    let className = "g-sidenav-pinned";

    if (iconNavbarSidenav) {
      iconNavbarSidenav.addEventListener("click", toggleSidenav);
    }

    if (iconSidenav) {
      iconSidenav.addEventListener("click", toggleSidenav);
    }

    function toggleSidenav() {
      if (body.classList.contains(className)) {
        body.classList.remove(className);
        setTimeout(function () {
          sidenav.classList.remove("bg-white");
        }, 100);
        sidenav.classList.remove("bg-transparent");
      } else {
        body.classList.add(className);
        sidenav.classList.add("bg-white");
        sidenav.classList.remove("bg-transparent");
        iconSidenav.classList.remove("d-none");
      }
    }
  },

  props: {
    title: String,
    page: String,
    subpage: String,
  },
};
</script>
