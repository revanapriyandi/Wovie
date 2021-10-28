<template>
  <AuthCard
    title="Sign In"
    headText="Welcome back!"
    desc="Enter your email and password to sign in"
  >
    <ValidationErrors />
    <form role="form text-left" @submit.prevent="submit">
      <div class="mb-3">
        <Input
          id="email"
          type="email"
          v-model="form.email"
          required
          placeholder="Email"
          aria-label="Email"
          aria-describedby="email-addon"
        />
      </div>
      <div class="mb-3">
        <Input
          id="password"
          type="password"
          v-model="form.password"
          required
          autocomplete="current-password"
          placeholder="Password"
          aria-label="Password"
          aria-describedby="password-addon"
        />
      </div>
      <div class="form-check form-check-info text-left">
        <Checkbox
          class="form-check-input"
          type="checkbox"
          id="loginCheck"
          name="remember"
          v-model:checked="form.remember"
        />
        <label class="form-check-label" for="loginCheck"> Remember me </label>
      </div>
      <div class="text-center">
        <Button
          class="w-100 my-4 mb-2"
          :type="form.processing"
          :disabled="form.processing"
        >
          <span
            v-if="form.processing"
            class="spinner-grow spinner-grow-sm"
            role="status"
            aria-hidden="true"
          ></span>
          Sign in
        </Button>
      </div>
    </form>
  </AuthCard>
</template>

<script>
import AuthCard from "@/components/Auth/AuthCard";
import Input from "@/components/Input/Input";
import Checkbox from "@/components/Checkbox/Checkbox";
import Button from "@/components/Button/Button";
import ValidationErrors from "@/components/Alert/ValidationErrors";

export default {
  components: {
    AuthCard,
    Input,
    Checkbox,
    Button,
    ValidationErrors,
  },

  props: {
    canResetPassword: Boolean,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
        password: "",
        remember: false,
      }),
    };
  },

  methods: {
    submit() {
      this.form
        .transform((data) => ({
          ...data,
          remember: this.form.remember ? "on" : "",
        }))
        .post(this.route("login"), {
          onFinish: () => this.form.reset("password"),
        });
    },
  },
};
</script>
