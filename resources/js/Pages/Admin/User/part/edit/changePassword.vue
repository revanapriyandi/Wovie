<template>
  <form role="form" @submit.prevent="updatePassword">
    <div class="card mt-4" id="password">
      <div class="card-header">
        <h5>Change Password</h5>
      </div>
      <div class="card-body pt-0">
        <label class="form-label">Current password</label>
        <div class="form-group">
          <Input
            required
            id="current_password"
            type="password"
            :class="{ 'is-invalid': form.errors.current_password }"
            v-model="form.current_password"
            ref="current_password"
            autocomplete="current-password"
            placeholder="Current password"
          />
          <InputError :message="form.errors.current_password" class="mt-2" />
        </div>
        <label class="form-label">New password</label>
        <div class="form-group">
          <Input
            required
            id="password"
            type="password"
            :class="{ 'is-invalid': form.errors.password }"
            v-model="form.password"
            ref="password"
            autocomplete="new-password"
            placeholder="New password"
          />
          <InputError :message="form.errors.password" class="mt-2" />
        </div>
        <label class="form-label">Confirm new password</label>
        <div class="form-group">
          <Input
            required
            id="password_confirmation"
            type="password"
            :class="{ 'is-invalid': form.errors.password_confirmation }"
            v-model="form.password_confirmation"
            autocomplete="new-password"
            placeholder="Confirm password"
          />
          <InputError :message="form.errors.password_confirmation" class="mt-2" />
        </div>
        <h5 class="mt-5">Password requirements</h5>
        <p class="text-muted mb-2">Please follow this guide for a strong password:</p>
        <ul class="text-muted ps-4 mb-0 float-start">
          <li>
            <span class="text-sm">One special characters</span>
          </li>
          <li>
            <span class="text-sm">Min 6 characters</span>
          </li>
          <li>
            <span class="text-sm">One number (2 are recommended)</span>
          </li>
          <li>
            <span class="text-sm">Change it often</span>
          </li>
        </ul>
        <Button
          class="btn-sm float-end mt-6 mb-0"
          :type="form.processing"
          :disabled="form.processing"
        >
          <span
            v-if="form.processing"
            class="spinner-grow spinner-grow-sm"
            role="status"
            aria-hidden="true"
          ></span>
          Update password
        </Button>
      </div>
    </div>
  </form>
</template>

<script>
import Input from "@/components/Input/Input";
import InputError from "@/components/Input/Error";
import Button from "@/components/Button/Button";

export default {
  components: {
    Input,
    InputError,
    Button,
  },

  props: {
    user: Array,
  },

  data() {
    return {
      form: this.$inertia.form({
        current_password: "",
        password: "",
        password_confirmation: "",
      }),
    };
  },

  methods: {
    updatePassword() {
      this.form.put(route("user.password.update", this.user.id), {
        onSuccess: () => this.form.reset(),
        onError: () => {
          if (this.form.errors.password) {
            this.form.reset("password", "password_confirmation");
            this.$refs.password.focus();
          }

          if (this.form.errors.current_password) {
            this.form.reset("current_password");
            this.$refs.current_password.focus();
          }
        },
      });
    },
  },
};
</script>
