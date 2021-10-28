<template>
  <layout title="Episodes" page="Episodes" subpage="Add Video or Edit Episode">
    <form @submit.prevent="updateEpisode">
      <div class="row">
        <div class="col-lg-8 col-12 mx-auto">
          <div class="card card-body mt-4">
            <div class="form-group">
              <label for="episode" class="form-label">Episode</label>
              <Input
                required
                id="episode"
                type="text"
                :class="{ 'is-invalid': form.errors.episode }"
                v-model="form.episode"
                autocomplete="episode"
                placeholder="Episode"
              />
              <InputError :message="form.errors.episode" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="overview" class="form-label">Overview</label>
              <Input
                required
                id="overview"
                type="text"
                :class="{ 'is-invalid': form.errors.overview }"
                v-model="form.overview"
                autocomplete="overview"
                placeholder="Overview"
              />
              <InputError :message="form.errors.overview" class="mt-2" />
            </div>
          </div>
          <div class="card mt-4">
            <div class="card-header pb-0 px-3">
              <h6 class="mb-0">Anime Video</h6>
              <button
                type="button"
                class="btn btn-sm btn-outline-dark float-end"
                data-bs-toggle="modal"
                data-bs-target="#videoModal"
              >
                Create
              </button>
            </div>
            <div class="card-body">
              <ul class="list-group">
                <template v-for="(video, vindex) in videos" v-bind:key="vindex">
                  <li
                    class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg"
                  >
                    <div class="d-flex flex-column">
                      <h6
                        class="mb-3 text-sm"
                        v-text="
                          video.lang.name + ' (' + video.lang.lang + ') ' + video.quality
                        "
                      ></h6>
                      <span class="mb-2 text-xs"
                        >Title:
                        <span
                          class="text-dark font-weight-bold ms-sm-2"
                          v-text="video.name == null ? 'N/A' : video.name"
                        ></span
                      ></span>
                      <span class="mb-2 text-xs"
                        >Service:
                        <span
                          class="text-dark ms-sm-2 font-weight-bold"
                          v-text="video.service ? video.service.name : 'N/A'"
                        ></span
                      ></span>
                      <span class="text-xs"
                        >Quality:
                        <span
                          class="text-dark ms-sm-2 font-weight-bold"
                          v-text="video.quality"
                        ></span
                      ></span>
                    </div>
                    <div class="ms-auto text-end">
                      <a
                        class="btn btn-link text-danger text-gradient px-3 mb-0"
                        href="javascript:;"
                        @click.prevent="deleteVideo(video.id)"
                        ><i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete</a
                      >
                    </div>
                  </li>
                </template>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-12 mx-auto">
          <div class="card card-body mt-4">
            <div class="form-group">
              <div
                class="card card-background card-background-mask-dark align-items-start mt-4"
                style="height: 300px"
              >
                <img
                  class="full-background cursor-pointer"
                  :src="episode.images_url"
                  :alt="form.name"
                  v-show="!imagePreview"
                />
                <img
                  class="full-background cursor-pointer"
                  :src="imagePreview"
                  :alt="form.name"
                  v-show="imagePreview"
                />
                <div class="card-body">
                  <div class="d-flex mt-4 pt-2">
                    <input
                      type="file"
                      class="form-control"
                      :class="{ 'is-invalid': form.errors.image }"
                      ref="image"
                      @change="updateImagePreview"
                      accept="image/x-png,image/gif,image/jpeg"
                    />
                  </div>
                </div>
              </div>
              <InputError :message="form.errors.image" class="mt-2" />
            </div>
            <div class="form-group">
              <div class="form-check form-switch ms-1">
                <Checkbox
                  class="form-check-input"
                  type="checkbox"
                  id="active"
                  name="active"
                  v-model:checked="form.active"
                />
                <label class="form-check-label" for="active">Active</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check form-switch ms-1">
                <Checkbox
                  class="form-check-input"
                  type="checkbox"
                  id="featured"
                  name="featured"
                  v-model:checked="form.featured"
                />
                <label class="form-check-label" for="featured">Featured</label>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="reset" name="button" class="btn btn-light m-0">Cancel</button>
              <Button
                class="m-0 ms-2"
                :type="form.processing"
                :disabled="form.processing"
              >
                <span
                  v-if="form.processing"
                  class="spinner-grow spinner-grow-sm"
                  role="status"
                  aria-hidden="true"
                ></span>
                Save Changes
              </Button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </layout>

  <Modal id="videoModal">
    <form role="form" @submit.prevent="saveVideo">
      <div class="modal-header">
        <h5 class="modal-title" id="videoModal">New Video</h5>
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
          <label for="title" class="form-label">Title</label>
          <Input
            id="title"
            type="text"
            :class="{ 'is-invalid': modal.errors.title }"
            v-model="modal.title"
            autocomplete="title"
            placeholder="Title"
          />
          <InputError :message="modal.errors.title" class="mt-2" />
        </div>

        <div class="form-group">
          <label for="quality" class="form-label">Quality</label>
          <select
            name="quality"
            id="quality"
            class="form-control"
            v-model="modal.quality"
            :class="{ 'is-invalid': modal.errors.quality }"
          >
            <option value="" disabled>Quality</option>
            <option value="240p">240p</option>
            <option value="360p">360p</option>
            <option value="480p">480p</option>
            <option value="720p">720p</option>
            <option value="1080p">1080p</option>
            <option value="1440p">1440p</option>
          </select>
          <InputError :message="modal.errors.quality" class="mt-2" />
        </div>
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="form-group">
              <label for="language_id" class="form-label">Language</label>
              <select
                required
                name="language_id"
                id="language_id"
                v-model="modal.language_id"
                class="form-control"
                :class="{ 'is-invalid': modal.errors.language_id }"
              >
                <option value="" disabled>Language</option>
                <template v-for="(language_id, index) in langs" v-bind:key="index">
                  <option
                    :value="language_id.id"
                    v-text="language_id.name + ' (' + language_id.lang + ')'"
                  ></option>
                </template>
              </select>
              <InputError :message="modal.errors.language_id" class="mt-2" />
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="form-group">
              <label for="service_id" class="form-label">Service</label>
              <select
                name="service_id"
                id="service_id"
                class="form-control"
                v-model="modal.service_id"
                :class="{ 'is-invalid': modal.errors.service_id }"
              >
                <option value="" disabled>Service</option>
                <template v-for="(service, index) in services" v-bind:key="index">
                  <option :value="service.id" v-text="service.name"></option>
                </template>
              </select>
              <InputError :message="modal.errors.service_id" class="mt-2" />
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="video" class="form-label">Embed or Mp4</label>
          <Input
            required
            id="video"
            type="url"
            :class="{ 'is-invalid': modal.errors.video }"
            v-model="modal.video"
            autocomplete="video"
            placeholder="Embed or Mp4"
          />
          <InputError :message="modal.errors.video" class="mt-2" />
        </div>

        <div class="form-group">
          <p class="form-text text-muted text-xs ms-1">
            Video Player only works when mp4 file is entered into the embed code
          </p>
          <div class="form-check form-switch ms-1">
            <Checkbox
              class="form-check-input"
              type="checkbox"
              id="vp"
              name="vp"
              v-model:checked="modal.vp"
            />
            <label class="form-check-label" for="vp">use Video Player</label>
          </div>
        </div>

        <hr />

        <div class="form-group">
          <label for="download" class="form-label">Download Link</label>
          <Input
            required
            id="download"
            type="url"
            :class="{ 'is-invalid': modal.errors.download }"
            v-model="modal.download"
            autocomplete="download"
            placeholder="Download Link"
          />
          <InputError :message="modal.errors.download" class="mt-2" />
        </div>

        <div class="form-group">
          <label for="service_id2" class="form-label">Service Download</label>
          <select
            name="service_id2"
            id="service_id2"
            class="form-control"
            v-model="modal.service_id2"
            :class="{ 'is-invalid': modal.errors.service_id2 }"
          >
            <option value="" disabled>Service</option>
            <template v-for="(service, index) in services" v-bind:key="index">
              <option :value="service.id" v-text="service.name"></option>
            </template>
          </select>
          <InputError :message="modal.errors.service_id2" class="mt-2" />
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
import Input from "@/components/Input/Input";
import InputError from "@/components/Input/Error";
import Button from "@/components/Button/Button";
import Checkbox from "@/components/Checkbox/Checkbox";
import Modal from "@/components/Modal/Modal";

import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    Layout,
    Input,
    InputError,
    Button,
    Checkbox,
    Modal,
  },

  data() {
    return {
      form: this.$inertia.form({
        _method: "PUT",
        episode: this.episode.name,
        overview: this.episode.description,
        active: this.episode.published ? true : false,
        featured: this.episode.featured ? true : false,
        image: null,
      }),

      modal: this.$inertia.form({
        title: "",
        language_id: "",
        service_id: "",
        quality: "",
        video: "",
        download: "",
        service_id2: "",
        vp: false,
      }),
      imagePreview: null,
    };
  },

  props: {
    episode: Array,
    langs: Array,
    services: Array,
    videos: Array,
  },

  methods: {
    updateEpisode() {
      if (this.$refs.image) {
        this.form.image = this.$refs.image.files[0];
      }

      this.form.post(route("episode.update", this.episode.id), {
        onSuccess: () => this.clearPhotoFileInput(),
      });
    },

    saveVideo() {
      this.modal.post(
        route("episode.video.store", {
          animeId: this.episode.anime.id,
          eps: this.episode.id,
        }),
        {
          onSuccess: () => this.modal.reset(),
        }
      );
    },

    updateImagePreview() {
      const image = this.$refs.image.files[0];

      if (!image) return;

      const reader = new FileReader();

      reader.onload = (e) => {
        this.imagePreview = e.target.result;
      };

      reader.readAsDataURL(image);
    },

    clearPhotoFileInput() {
      if (this.$refs.image?.value) {
        this.$refs.image.value = null;
      }
    },
  },

  setup() {
    function deleteVideo(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(route("video.destroy", id));
        }
      });
    }

    return {
      deleteVideo,
    };
  },

  mounted() {
    if (document.getElementById("language_id")) {
      var element = document.getElementById("language_id");
      const example = new Choices(element, {
        removeItemButton: true,
        placeholder: true,
      });
    }

    if (document.getElementById("service_id")) {
      var service = document.getElementById("service_id");
      const el = new Choices(service, {
        removeItemButton: true,
        placeholder: true,
      });
    }
  },
};
</script>
