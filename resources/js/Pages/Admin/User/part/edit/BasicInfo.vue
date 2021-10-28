<template>
  <form role="form" @submit.prevent="updateBasicInfo">
    <div class="card mt-4" id="basic-info">
      <div class="card-header">
        <h5>Basic Info</h5>
      </div>
      <div class="card-body pt-0">
        <div class="row">
          <label class="form-label">Name</label>
          <div class="input-group">
            <Input
              id="name"
              type="text"
              required
              :placeholder="user.name"
              v-model="form.name"
              aria-label="Name"
              :class="{ 'is-invalid': form.errors.name }"
              aria-describedby="Name"
            />
            <InputError :message="form.errors.name" class="mt-2" />
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <label class="form-label mt-4">Email</label>
            <div class="input-group">
              <Input
                id="email"
                type="email"
                required
                v-model="form.email"
                :placeholder="user.email"
                :class="{ 'is-invalid': form.errors.email }"
                aria-label="Email"
                aria-describedby="Email"
              />
              <InputError :message="form.errors.email" class="mt-2" />
            </div>
          </div>
          <div class="col-6">
            <label class="form-label mt-4">Phone Number</label>
            <div class="input-group">
              <Input
                id="phone"
                name="phone"
                class="form-control"
                type="text"
                :class="{ 'is-invalid': form.errors.phone_no }"
                v-model="form.phone_no"
                placeholder="+62 812 6186 5875"
              />
              <InputError :message="form.errors.phone_no" class="mt-2" />
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer float-right">
        <Button
          class="btn-sm float-end mb-0"
          :type="form.processing"
          :disabled="form.processing"
        >
          <span
            v-if="form.processing"
            class="spinner-grow spinner-grow-sm"
            role="status"
            aria-hidden="true"
          ></span>
          Update
        </Button>
      </div>
    </div>
  </form>
</template>

<script>
import Input from "@/components/Input/Input";
import Button from "@/components/Button/Button";
import ValidationErrors from "@/components/Alert/ValidationErrors";
import InputError from "@/components/Input/Error";

export default {
  components: {
    Input,
    Button,
    ValidationErrors,
    InputError,
  },

  props: {
    user: Array,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: this.user.name,
        email: this.user.email,
        phone_no: this.user.phone_no,
      }),
    };
  },

  methods: {
    updateBasicInfo() {
      this.form.put(route("user.update", this.user.id));
    },
  },
};
</script>
