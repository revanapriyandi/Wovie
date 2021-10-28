<template>
  <div class="row my-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-6">
              <Link
                class="btn bg-gradient-dark"
                :href="route('episode.create', $page.props.animeId)"
                >New Episode
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
            <table class="table align-items-center mb-0" aria-describedby="Table Episode">
              <thead>
                <tr>
                  <th
                    id="id"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                  ></th>
                  <th
                    id="episode"
                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                  >
                    Episode
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
                <template v-for="(episode, key) in episodes.data" v-bind:key="key">
                  <tr>
                    <td class="align-middle text-center text-sm">
                      <p
                        class="text-secondary mb-0 text-sm"
                        v-text="'#' + episode.id"
                      ></p>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img
                            :src="episode.anime.images_url"
                            class="avatar avatar-lg me-3"
                            :alt="episode.name"
                          />
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <Link :href="route('episode.edit', episode.id)">
                            <h6
                              class="mb-0 mt-2 text-sm"
                              v-text="'Episode ' + episode.name"
                            ></h6
                          ></Link>
                          <p
                            class="form-text text-muted text-xs ms-1"
                            v-text="episode.anime.title"
                          ></p>
                        </div>
                      </div>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <p
                        class="text-secondary mb-0 text-sm"
                        v-text="episode.release_date"
                      ></p>
                    </td>
                    <td class="align-middle text-center">
                      <Link
                        :href="route('episode.edit', episode.id)"
                        class="text-dark text-xs float-start"
                        >Edit</Link
                      >
                      <a
                        href="javascript::"
                        class="text-dark text-xs float-end"
                        @click.prevent="deleteEpisode(episode.id)"
                        >Delete</a
                      >
                    </td>
                  </tr>
                </template>
                <tr v-if="episodes.data == 0">
                  <td colspan="4" class="align-middle text-center text-sm">
                    <p class="text-secondary mb-0 text-sm">Tidak ada data!</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <Pagination :links="episodes.links" />
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
      if (this.route().current("episodes")) {
        this.$inertia.replace(
          this.route("episodes", { id: this.$page.props.animeId, term: this.term })
        );
      } else if (this.route().current("anime.edit")) {
        this.$inertia.replace(
          this.route("anime.edit", { id: this.$page.props.animeId, term: this.term })
        );
      }
    },
  },

  setup() {
    function deleteEpisode(id) {
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
          Inertia.delete(route("episode.destroy", id));
        }
      });
    }

    return {
      deleteEpisode,
    };
  },

  props: {
    episodes: Array,
    eps: Array,
  },
};
</script>
