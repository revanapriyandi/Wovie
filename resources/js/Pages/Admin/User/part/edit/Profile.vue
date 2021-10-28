<template>
  <div class="card card-body" id="profile">
    <div class="row justify-content-center align-items-center">
      <div class="col-sm-auto col-4">
        <div class="avatar avatar-xl position-relative">
          <img
            :src="user.profile_photo_url"
            :alt="user.name"
            v-show="!photoPreview"
            class="w-100 h-100 border-radius-lg shadow-sm"
          />
          <img
            :src="photoPreview"
            :alt="user.name"
            v-show="photoPreview"
            class="w-100 h-100 border-radius-lg shadow-sm"
          />
        </div>
      </div>
      <div class="col-sm-auto col-8 my-auto">
        <div class="h-100">
          <h5 class="mb-1 font-weight-bolder" v-text="user.name"></h5>
          <p class="mb-0 font-weight-bold text-sm" v-text="user.role_user"></p>
        </div>
      </div>
      <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
        <div class="row">
          <div class="col-md-6 col-sm-auto" v-if="user.profile_photo_path">
            <button
              type="button"
              class="btn btn-outline-dark btn-sm mb-0"
              @click.prevent="deletePhoto"
            >
              Remove
            </button>
          </div>
          <div class="col-md-6 col-sm-auto">
            <input type="file" hidden ref="photo" @change="updatePhotoPreview" />
            <Button
              class="btn-sm mb-0"
              :type="form.processing"
              :disabled="form.processing"
              @click.prevent="selectNewPhoto"
            >
              <span
                v-if="form.processing"
                class="spinner-grow spinner-grow-sm"
                role="status"
                aria-hidden="true"
              ></span>
              Upload
            </Button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Button from "@/components/Button/Button";

export default {
  components: {
    Button,
  },

  data() {
    return {
      form: this.$inertia.form({
        _method: "PUT",
        name: this.user.name,
        email: this.user.email,
        phone_no: this.user.phone_no,
        photo: null,
      }),
      photoPreview: null,
    };
  },

  methods: {
    updateProfile() {
      if (this.$refs.photo) {
        this.form.photo = this.$refs.photo.files[0];
      }

      this.form.post(route("user.update", this.user.id), {
        onSuccess: () => this.clearPhotoFileInput(),
      });
    },

    updatePhotoPreview() {
      const photo = this.$refs.photo.files[0];

      if (!photo) return;

      const reader = new FileReader();

      reader.onload = (e) => {
        this.photoPreview = e.target.result;
      };

      reader.readAsDataURL(photo);
      this.updateProfile();
    },

    selectNewPhoto() {
      this.$refs.photo.click();
    },

    deletePhoto() {
      this.$inertia.delete(route("current-user-photo.destroy", this.user.id), {
        preserveScroll: true,
        onSuccess: () => {
          this.photoPreview = null;
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

  props: {
    user: Array,
  },
};
</script>
