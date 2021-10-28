<template>
  <layout title="Anime" page="Anime" subpage="Edit">
    <form @submit.prevent="updateAnime">
      <div class="row">
        <div class="col-lg-8 col-12 mx-auto">
          <div class="card card-body mt-4">
            <div class="form-group">
              <label for="title" class="form-label">Anime Title</label>
              <Input
                required
                id="title"
                type="text"
                :class="{ 'is-invalid': form.errors.title }"
                v-model="form.title"
                autocomplete="title"
                placeholder="Anime Title"
              />
              <InputError :message="form.errors.title" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="title_sub" class="form-label">Second Title</label>
              <p class="form-text text-muted text-xs ms-1">
                Second Title is used for the translation of the content into your
                language.
              </p>
              <Input
                required
                id="title_sub"
                type="text"
                :class="{ 'is-invalid': form.errors.title_sub }"
                v-model="form.title_sub"
                autocomplete="title_sub"
                placeholder="Second Title"
              />
              <InputError :message="form.errors.title_sub" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="genre" class="form-label">Genre</label>
              <select
                class="form-control"
                name="genre"
                v-model="form.genres"
                :class="{ 'is-invalid': form.errors.genres }"
                id="genre"
                required
                multiple
              >
                <option value="">Anime Genre</option>
                <template v-for="(genre, key) in genres" v-bind:key="key">
                  <option :value="genre.id" v-text="genre.name"></option>
                </template>
              </select>
              <InputError :message="form.errors.genres" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="editor" class="form-label">Anime Description</label>
              <textarea
                class="form-control"
                id="editor"
                v-model="form.description"
                :class="{ 'is-invalid': form.errors.description }"
                required
                placeholder="Anime Description"
              >
              </textarea>
              <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div class="row">
              <div class="col-lg-4 col-12 mx-auto">
                <div class="form-group">
                  <label for="country_id" class="form-label">Country</label>
                  <select
                    class="form-control"
                    name="country_id"
                    v-model="form.country_id"
                    :class="{ 'is-invalid': form.errors.country_id }"
                    id="country_id"
                    required
                  >
                    <option value="">Anime Country</option>
                    <template v-for="(country, key) in countrys" v-bind:key="key">
                      <option :value="country.id" v-text="country.name"></option>
                    </template>
                  </select>
                  <InputError :message="form.errors.country_id" class="mt-2" />
                </div>
              </div>
              <div class="col-lg-4 col-12 mx-auto">
                <div class="form-group">
                  <label for="release_date" class="form-label">Release Date</label>
                  <Input
                    required
                    id="release_date"
                    type="text"
                    class="datetimepicker"
                    :class="{ 'is-invalid': form.errors.release_date }"
                    v-model="form.release_date"
                    autocomplete="release_date"
                    placeholder="Release Date"
                  />
                  <InputError :message="form.errors.release_date" class="mt-2" />
                </div>
              </div>
              <div class="col-lg-4 col-12 mx-auto">
                <div class="form-group">
                  <label for="duration" class="form-label">Duration /episode</label>
                  <Input
                    required
                    id="duration"
                    type="text"
                    :class="{ 'is-invalid': form.errors.duration }"
                    v-model="form.duration"
                    autocomplete="duration"
                    placeholder="Duration"
                  />
                  <InputError :message="form.errors.duration" class="mt-2" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-12 mx-auto">
                <div class="form-group">
                  <label for="musim" class="form-label">Musim Rilis</label>
                  <select
                    id="musim"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.musim }"
                    v-model="form.musim"
                  >
                    <option value="" disabled>Musim Rilis</option>
                    <option value="1">Spring</option>
                    <option value="2">Summer</option>
                    <option value="3">Fall</option>
                    <option value="4">Winter</option>
                  </select>
                  <InputError :message="form.errors.musim" class="mt-2" />
                </div>
              </div>
              <div class="col-lg-4 col-12 mx-auto">
                <div class="form-group">
                  <label for="episode" class="form-label">Total Episode</label>
                  <Input
                    required
                    id="episode"
                    type="number"
                    :class="{ 'is-invalid': form.errors.episode }"
                    v-model="form.episode"
                    autocomplete="episode"
                    placeholder="Episode"
                  />
                  <InputError :message="form.errors.episode" class="mt-2" />
                </div>
              </div>
              <div class="col-lg-4 col-12 mx-auto">
                <div class="form-group">
                  <label for="status" class="form-label">Status</label>
                  <select
                    id="status"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.status }"
                    v-model="form.status"
                  >
                    <option value="" disabled>Anime Status</option>
                    <option value="1">Ongoing</option>
                    <option value="2">Completed</option>
                    <option value="3">Canceled</option>
                  </select>
                  <InputError :message="form.errors.status" class="mt-2" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-12 mx-auto">
                <div class="form-group">
                  <label for="score" class="form-label">Score MAL</label>
                  <Input
                    required
                    id="score"
                    type="text"
                    :class="{ 'is-invalid': form.errors.score }"
                    v-model="form.score"
                    autocomplete="score"
                    placeholder="Score MAL"
                  />
                  <InputError :message="form.errors.score" class="mt-2" />
                </div>
              </div>
              <div class="col-lg-6 col-12 mx-auto">
                <div class="form-group">
                  <label for="producer_id" class="form-label">Producer</label>
                  <select
                    class="form-control"
                    name="producer_id"
                    v-model="form.producer_id"
                    :class="{ 'is-invalid': form.errors.producer_id }"
                    id="producer_id"
                    required
                  >
                    <option value="">Anime Producer</option>
                    <template v-for="(producer, key) in producers" v-bind:key="key">
                      <option :value="producer.id" v-text="producer.name"></option>
                    </template>
                  </select>
                  <InputError :message="form.errors.producer_id" class="mt-2" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="trailer" class="form-label">Trailer</label>
              <Input
                required
                id="trailer"
                type="url"
                :class="{ 'is-invalid': form.errors.trailer }"
                v-model="form.trailer"
                autocomplete="trailer"
                placeholder="Trailer"
              />
              <InputError :message="form.errors.trailer" class="mt-2" />
            </div>
            <div class="form-group">
              <label for="tags" class="form-label">Tags</label>
              <p class="form-text text-muted text-xs ms-1">Pisahkan dengan koma (,)</p>
              <textarea
                class="form-control"
                id="tags"
                :class="{ 'is-invalid': form.errors.tags }"
                v-model="form.tags"
                autocomplete="tags"
                placeholder="Tags"
              >
              </textarea>
              <InputError :message="form.errors.tags" class="mt-2" />
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
                  :src="anime.images_url"
                  :alt="form.title"
                  v-show="!imagePreview"
                />
                <img
                  class="full-background cursor-pointer"
                  :src="imagePreview"
                  :alt="form.title"
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
            <div class="form-group">
              <div class="form-check form-switch ms-1">
                <Checkbox
                  class="form-check-input"
                  type="checkbox"
                  id="movie"
                  name="movie"
                  v-model:checked="form.isMovie"
                />
                <label class="form-check-label" for="movie">Movie</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-check form-switch ms-1">
                <Checkbox
                  class="form-check-input"
                  type="checkbox"
                  id="memberOnly"
                  name="memberOnly"
                  v-model:checked="form.memberOnly"
                />
                <label class="form-check-label" for="memberOnly">Member Only</label>
              </div>
            </div>

            <div class="row">
              <div class="d-flex justify-content-end mt-4">
                <Link
                  :href="route('episodes', anime.id)"
                  class="btn bg-gradient-dark m-0 ms-2"
                >
                  Episodes
                </Link>
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
                Save Anime
              </Button>
            </div>
          </div>
        </div>
      </div>
    </form>
    <TableEpisode :episodes="episodes" />
  </layout>
</template>

<script>
import Layout from "@/Layouts/AppLayout";
import Input from "@/components/Input/Input";
import InputError from "@/components/Input/Error";
import Checkbox from "@/components/Checkbox/Checkbox";
import Button from "@/components/Button/Button";
import TableEpisode from "@/Pages/Admin/Anime/Episode/partials/table";

import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Layout,
    Input,
    InputError,
    Checkbox,
    Button,
    Link,
    TableEpisode,
  },

  props: {
    anime: Array,
    genres: Array,
    countrys: Array,
    producers: Array,
    anime_genre: Array,
    animeData: Array,
    episodes: Array,
  },

  data() {
    return {
      form: this.$inertia.form({
        _method: "PUT",
        title: this.anime.title,
        title_sub: this.anime.title_sub,
        genres: this.anime_genre,
        description: this.anime.description,
        country_id: this.anime.country_id,
        release_date: this.anime.release_date,
        duration: this.anime.duration,
        status: this.anime.status,
        trailer: this.anime.trailer,
        tags: "",
        episode: this.anime.episode,
        musim: this.anime.musim,
        score: this.anime.score,
        studio: this.anime.studio,
        producer_id: this.anime.producer_id,
        image: null,
        active: this.anime.private ? true : false,
        featured: this.anime.featured ? true : false,
        isMovie: this.anime.type == "2" ? true : false,
        memberOnly: this.anime.member_only ? true : false,
      }),
      imagePreview: null,
    };
  },

  methods: {
    updateAnime() {
      if (this.$refs.image) {
        this.form.image = this.$refs.image.files[0];
      }

      this.form.post(route("anime.update", this.anime.id), {
        onSuccess: () => {
          this.imagePreview = null;
          this.clearPhotoFileInput();
        },
      });
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

  mounted() {
    if (document.getElementById("genre")) {
      var element = document.getElementById("genre");
      const example = new Choices(element, {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: null,
      });
    }
    if (document.getElementById("country_id")) {
      var country = document.getElementById("country_id");
      const el = new Choices(country, {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: null,
      });
    }
    if (document.getElementById("producer_id")) {
      var producer = document.getElementById("producer_id");
      const el = new Choices(producer, {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: null,
      });
    }

    if (document.querySelector(".datetimepicker")) {
      flatpickr(".datetimepicker", {
        allowInput: true,
      });
    }
  },
};
</script>
