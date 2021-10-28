<template>
  <layout title="New Users" page="Users" subpage="New User">
    <div class="row">
      <div class="col-lg-9 col-12 mx-auto">
        <div class="card card-body mt-4">
          <ValidationErrors />
          <h6 class="mb-0">New User</h6>
          <p class="text-sm mb-0">Create new user</p>
          <hr class="horizontal dark my-3" />
          <form role="form" @submit.prevent="newUser">
            <label for="name" class="form-label">Name</label>
            <Input
              id="name"
              type="text"
              required
              v-model="form.name"
              placeholder="Name"
              aria-label="Name"
              aria-describedby="Name"
            />
            <label for="email" class="form-label">Email</label>
            <Input
              id="email"
              type="email"
              required
              v-model="form.email"
              placeholder="Email"
              aria-label="Email"
              aria-describedby="Email"
            />
            <div class="row">
              <div class="col-6">
                <label for="phone" class="form-label">Phone Number</label>
                <Input
                  id="phone"
                  type="text"
                  required
                  v-model="form.phone_no"
                  placeholder="Phone Number"
                  aria-label="Phone"
                  aria-describedby="Phone"
                />
              </div>
              <div class="col-6">
                <label for="password" class="form-label">Password</label>
                <Input
                  id="password"
                  type="text"
                  required
                  v-model="form.password"
                  placeholder="Password"
                  aria-label="Password"
                  aria-describedby="Password"
                />
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
                Create User
              </Button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layouts/AppLayout";
import Input from "@/components/Input/Input";
import ValidationErrors from "@/components/Alert/ValidationErrors";
import Button from "@/components/Button/Button";

export default {
  components: {
    Layout,
    Input,
    ValidationErrors,
    Button,
  },

  data() {
    return {
      form: this.$inertia.form({
        name: "",
        email: "",
        password: "",
        phone_no: "",
      }),
    };
  },

  methods: {
    newUser() {
      this.form.post(route("user.store"), {
        onSuccess: () => this.form.reset(),
      });
    },
  },
};
</script>
