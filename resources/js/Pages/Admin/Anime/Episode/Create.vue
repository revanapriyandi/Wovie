<template>
  <layout title="Episodes" page="Episodes" subpage="New Episode">
    <form @submit.prevent="saveEpisode">
      <div class="row">
        <div class="col-lg-8 col-12 mx-auto">
          <div class="card card-body mt-4">
            <div class="form-group">
              <label for="episode" class="form-label">Episode</label>
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
                  :src="imagePreview ? imagePreview : ''"
                  alt="..."
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
</template>

<script>
import Layout from "@/Layouts/AppLayout";
import Input from "@/components/Input/Input";
import InputError from "@/components/Input/Error";
import Button from "@/components/Button/Button";
import Checkbox from "@/components/Checkbox/Checkbox";

export default {
  components: {
    Layout,
    Input,
    InputError,
    Button,
    Checkbox,
  },

  data() {
    return {
      form: this.$inertia.form({
        episode: "",
        overview: "",
        active: true,
        featured: false,
        image: null,
      }),
      imagePreview: null,
    };
  },

  methods: {
    saveEpisode() {
      if (this.$refs.image) {
        this.form.image = this.$refs.image.files[0];
      }

      this.form.post(route("episode.store", this.$page.props.animeId), {
        onSuccess: () => this.form.reset(),
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
  },
};
</script>
