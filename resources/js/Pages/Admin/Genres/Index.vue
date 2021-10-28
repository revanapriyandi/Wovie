<template>
  <layout title="Genres" page="Genres"> <TableGenre :genres="genres" /> </layout>


</template>

<script>
import Layout from "@/Layouts/AppLayout";
import TableGenre from "@/Pages/Admin/Genres/partials/table";
import Modal from "@/components/Modal/Modal";
import Input from "@/components/Input/Input";
import InputError from "@/components/Input/Error";
import Button from "@/components/Button/Button";

export default {
  components: {
    Layout,
    TableGenre,
    Modal,
    Input,
    InputError,
    Button,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: "",
        type: "0",
      }),
    };
  },

  methods: {
    createGenre() {
      this.form.post(route("genres.store"), {
        onSuccess: () => this.form.reset(),
      });
    },

    edit(data) {
      this.form = Object.assign({}, data);
    },
    update(data) {
      data._method = "PATCH";
      this.$inertia.post("/article/edit/" + data.id, data);
      this.reset();
      this.closeModal();
    },
  },

  props: {
    genres: Array,
  },
};
</script>
