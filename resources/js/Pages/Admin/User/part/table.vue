<template>
  <div class="row my-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <Link class="btn bg-gradient-dark" :href="route('user.create')"
                >New User
              </Link>
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
                    id="name"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    Name
                  </th>
                  <th
                    id="role"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                  >
                    Role
                  </th>
                  <th
                    id="email"
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    Email
                  </th>
                  <th
                    id="status"
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    Status
                  </th>
                  <th
                    id="join"
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    Join
                  </th>
                  <th
                    id="action"
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  ></th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(user, key) in users.data" v-bind:key="key">
                  <tr>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img
                            :src="user.profile_photo_url"
                            class="avatar avatar-sm me-3"
                            :alt="user.name"
                          />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <Link :href="route('user.edit', user.id)">
                            <h6 class="mb-0 text-sm" v-text="user.name"></h6
                          ></Link>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge badge-dot me-4">
                        <i class="bg-info"></i>
                        <span
                          class="text-xs"
                          :class="user.role == '1' ? 'text-primary' : 'text-dark'"
                          v-text="user.role_user"
                        ></span>
                      </span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <p class="text-secondary mb-0 text-sm">
                        <a
                          :href="'mailto:' + user.email"
                          class="__cf_email__"
                          data-cfemail="167c797e7856636573643875797b"
                          >[email&#160;protected]</a
                        >
                      </p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <Link
                        class="badge badge-sm"
                        :class="user.status ? ' bg-gradient-dark' : 'bg-gradient-danger'"
                        :href="route('user.status', user.id)"
                        method="post"
                        v-text="user.status ? 'Active' : 'Suspend'"
                      ></Link>
                    </td>
                    <td class="align-middle text-center">
                      <span
                        class="text-secondary text-sm"
                        v-text="user.joined_date"
                      ></span>
                    </td>
                    <td class="align-middle text-center">
                      <Link
                        :href="route('user.edit', user.id)"
                        class="text-dark text-xs float-start"
                        >Edit</Link
                      >
                      <a
                        href="javascript::"
                        class="text-dark text-xs float-end"
                        @click.prevent="deleteUser(user.id)"
                        >Delete</a
                      >
                    </td>
                  </tr>
                </template>
                <tr v-if="users.data == 0">
                  <td colspan="6" class="align-middle text-center text-sm">
                    <p class="text-secondary mb-0 text-sm">Tidak ada data!</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <Pagination :links="users.links" />
      </div>
    </div>
  </div>
</template>

<script>
import Pagination from "@/components/Pagination/Pagination";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    Pagination,
    Link,
  },

  data() {
    return {
      term: "",
    };
  },

  methods: {
    search() {
      this.$inertia.replace(this.route("user.index", { term: this.term }));
    },
  },

  setup() {
    function deleteUser(id) {
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
          Inertia.delete(route("user.destroy", id));
        }
      });
    }

    return {
      deleteUser,
    };
  },

  props: {
    users: Array,
  },
};
</script>
