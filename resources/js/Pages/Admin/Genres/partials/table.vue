<template>
  <div class="row my-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <button
                type="button"
                class="btn bg-gradient-dark"
                data-bs-toggle="modal"
                data-bs-target="#genreModal"
              >
                New Genre
              </button>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <div class="input-group mb-4">
                  <span class="input-group-text"
                    ><i class="ni ni-zoom-split-in"></i
                  ></span>
                  <input
                    class="form-control"
                    placeholder="Search"
                    v-model="term"
                    type="text"
                    @keyup="search"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-items-center mb-0" aria-describedby="Table users">
              <thead>
                <tr>
                  <th
                    id="id"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    ID
                  </th>
                  <th
                    id="name"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    Name
                  </th>
                  <th
                    id="name"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    Type
                  </th>
                  <th
                    id="action"
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  ></th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(genre, key) in genres.data" v-bind:key="key">
                  <tr>
                    <td>
                      <span class="text-secondary text-sm" v-text="genre.id"></span>
                    </td>
                    <td>
                      <span class="badge bg-gradient-dark me-4" v-text="genre.name">
                      </span>
                    </td>
                    <td>
                      <span class="badge badge-dot me-4">
                        <i class="bg-dark"></i>
                        <span class="text-dark text-xs" v-text="genre.type_genre"></span>
                      </span>
                    </td>
                    <td class="align-middle text-center">
                      <a
                        href="javascript::"
                        class="text-dark text-xs float-end"
                        @click.prevent="deleteGenre(genre.id)"
                        >Delete</a
                      >
                    </td>
                  </tr>
                </template>
                <tr v-if="genres.data == 0">
                  <td colspan="4" class="align-middle text-center text-sm">
                    <p class="text-secondary mb-0 text-sm">Tidak ada data!</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <Pagination :links="genres.links" />
      </div>
    </div>
  </div>

  <Modal id="genreModal">
    <form role="form" @submit.prevent="createGenre">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Genre</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="name" class="col-form-label">Genre Name:</label>
          <Input
            required
            id="name"
            type="text"
            :class="{ 'is-invalid': form.errors.name }"
            v-model="form.name"
            autocomplete="name"
            placeholder="Genre Name"
          />
          <InputError :message="form.errors.name" class="mt-2" />
        </div>
        <div class="form-group">
          <label for="types" class="col-form-label">Type Genre:</label>
          <select
            class="form-control"
            id="types"
            name="types"
            v-model="form.type"
            :class="{ 'is-invalid': form.errors.type }"
          >
            <option value="0">Default</option>
            <option value="1">Eksplisit‎</option>
            <option value="2">Themes</option>
            <option value="3">Demographics</option>
          </select>
          <InputError :message="form.errors.type" class="mt-2" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <Button :type="form.processing" :disabled="form.processing">
          <span
            v-if="form.processing"
            class="spinner-grow spinner-grow-sm"
            role="status"
            aria-hidden="true"
          ></span>
          Save
        </Button>
      </div>
    </form>
  </Modal>
</template>

<script>
import Pagination from "@/components/Pagination/Pagination";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

import Input from "@/components/Input/Input";
import InputError from "@/components/Input/Error";
import Modal from "@/components/Modal/Modal";
import Button from "@/components/Button/Button";

export default {
  components: {
    Pagination,
    Link,
    Modal,
    Input,
    InputError,
    Button,
  },

  data() {
    return {
      term: "",

      form: this.$inertia.form({
        name: "",
        type: "0",
      }),
    };
  },

  methods: {
    search() {
      this.$inertia.replace(this.route("genres", { term: this.term }));
    },

    createGenre() {
      this.form.post(route("genres.store"), {
        onSuccess: () => this.form.reset(),
      });
    },
  },

  setup() {
    function deleteGenre(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#191C30",
        cancelButtonColor: "#7C8EAD",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(route("genres.destroy", id));
        }
      });
    }

    return {
      deleteGenre,
    };
  },

  props: {
    genres: Array,
  },
};
</script>
