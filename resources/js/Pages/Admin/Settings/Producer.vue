<template>
  <layout title="Producers" page="Producers">
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
                  data-bs-target="#producerModal"
                >
                  New Producer
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
              <table
                class="table align-items-center mb-0"
                aria-describedby="Table Producers"
              >
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
                      id="description"
                      class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                    >
                      Description
                    </th>
                    <th
                      id="action"
                      class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                    ></th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(producer, key) in producers.data" v-bind:key="key">
                    <tr>
                      <td>
                        <span class="text-secondary text-sm" v-text="producer.id"></span>
                      </td>
                      <td>
                        <span class="badge bg-gradient-dark me-4" v-text="producer.name">
                        </span>
                      </td>
                      <td>
                        <span
                          class="text-secondary text-sm"
                          v-text="producer.description"
                        >
                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <a
                          href="javascript::"
                          class="text-dark text-xs float-end"
                          @click.prevent="deleteProducer(producer.id)"
                          >Delete</a
                        >
                      </td>
                    </tr>
                  </template>
                  <tr v-if="producers.data == 0">
                    <td colspan="4" class="align-middle text-center text-sm">
                      <p class="text-secondary mb-0 text-sm">Tidak ada data!</p>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <Pagination :links="producers.links" />
        </div>
      </div>
    </div>
  </layout>
  <Modal id="producerModal">
    <form role="form" @submit.prevent="createProducer">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Producer</h5>
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
          <label for="name" class="col-form-label">Name:</label>
          <Input
            required
            id="name"
            type="text"
            :class="{ 'is-invalid': form.errors.name }"
            v-model="form.name"
            autocomplete="name"
            placeholder="Name"
          />
          <InputError :message="form.errors.name" class="mt-2" />
        </div>
        <div class="form-group">
          <label for="description" class="col-form-label">Description:</label>
          <textarea
            required
            id="description"
            class="form-control"
            :class="{ 'is-invalid': form.errors.description }"
            v-model="form.description"
            autocomplete="description"
            placeholder="Description"
          ></textarea>
          <InputError :message="form.errors.description" class="mt-2" />
        </div>
        <div class="form-group">
          <label for="photo" class="col-form-label">Image:</label>
          <input
            type="file"
            required
            id="photo"
            class="form-control"
            :class="{ 'is-invalid': form.errors.photo }"
            ref="photo"
            accept="image/x-png,image/gif,image/jpeg"
          />
          <InputError :message="form.errors.photo" class="mt-2" />
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
import Layout from "@/Layouts/AppLayout";
import TableGenre from "@/Pages/Admin/Genres/partials/table";
import Modal from "@/components/Modal/Modal";
import Input from "@/components/Input/Input";
import InputError from "@/components/Input/Error";
import Button from "@/components/Button/Button";
import Pagination from "@/components/Pagination/Pagination";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    Layout,
    TableGenre,
    Modal,
    Input,
    InputError,
    Button,
    Pagination,
    Link,
  },

  data() {
    return {
      term: "",

      form: this.$inertia.form({
        name: "",
        description: "",
        photo: null,
      }),
    };
  },

  methods: {
    search() {
      this.$inertia.replace(this.route("producer", { term: this.term }));
    },

    createProducer() {
      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0];
      }
      this.form.post(route("producer.store"), {
        onSuccess: () => {
          this.form.reset();
          this.clearPhotoFileInput();
        },
      });
    },

    clearPhotoFileInput() {
      if (this.$refs.photo?.value) {
        this.$refs.photo.value = null;
      }
    },
  },

  setup() {
    function deleteProducer(id) {
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
          Inertia.delete(route("producer.destroy", id));
        }
      });
    }

    return {
      deleteProducer,
    };
  },

  props: {
    producers: Array,
  },
};
</script>
