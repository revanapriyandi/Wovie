<template>
  <div class="row my-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <Link class="btn bg-gradient-dark" :href="route('anime.create')"
                >New Anime
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
                    id="id"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  ></th>
                  <th
                    id="anime"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                  >
                    Anime
                  </th>
                  <th
                    id="score"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                  >
                    Score
                  </th>
                  <th
                    id="producer"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                  >
                    Status
                  </th>
                  <th
                    id="date"
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  >
                    Release Date
                  </th>
                  <th
                    id="action"
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  ></th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(anime, key) in animes.data" v-bind:key="key">
                  <tr>
                    <td class="align-middle text-center text-sm">
                      <p class="text-secondary mb-0 text-sm" v-text="'#' + anime.id"></p>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img
                            :src="anime.images_url"
                            class="avatar avatar-lg me-3"
                            :alt="anime.title"
                          />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <Link :href="route('anime.edit', anime.id)">
                            <h6 class="mb-0 mt-2 text-sm" v-text="anime.title"></h6
                          ></Link>
                          <p class="form-text text-muted text-xs ms-1">
                            <template
                              v-for="(genre, index) in anime.genre"
                              v-bind:key="index"
                            >
                              {{ index === anime.genre.length ? "" : genre.name + ", " }}
                            </template>
                          </p>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-sm">
                      <p class="text-secondary mb-0 text-sm" v-text="anime.score"></p>
                    </td>
                    <td class="align-middle text-sm">
                      <span
                        class="badge bg-gradient-dark"
                        v-text="anime.anime_status"
                      ></span>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <p
                        class="text-secondary mb-0 text-sm"
                        v-text="anime.release_date"
                      ></p>
                    </td>
                    <td class="align-middle text-center">
                      <Link
                        :href="route('anime.edit', anime.id)"
                        class="text-dark text-xs float-start"
                        >Edit</Link
                      >
                      <a
                        href="javascript::"
                        class="text-dark text-xs float-end"
                        @click.prevent="deleteAnime(anime.id)"
                        >Delete</a
                      >
                    </td>
                  </tr>
                </template>
                <tr v-if="animes.data == 0">
                  <td colspan="6" class="align-middle text-center text-sm">
                    <p class="text-secondary mb-0 text-sm">Tidak ada data!</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <Pagination :links="animes.links" />
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
      this.$inertia.replace(this.route("anime", { term: this.term }));
    },
  },

  setup() {
    function deleteAnime(id) {
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
          Inertia.delete(route("anime.destroy", id));
        }
      });
    }

    return {
      deleteAnime,
    };
  },

  props: {
    animes: Array,
  },
};
</script>
