<template>
  <div class="row">
    <div class="col-lg-6 col-12">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
          <div
            class="card"
            style="
              background-image: url('../../../assets/img/curved-images/white-curved.jpg');
            "
          >
            <span class="mask bg-gradient-dark opacity-9 border-radius-xl"></span>
            <div class="card-body p-3 position-relative">
              <div class="row">
                <div class="col-8 text-start">
                  <div
                    class="icon icon-shape bg-white shadow text-center border-radius-md"
                  >
                    <i
                      class="fa fa-photo-video text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5
                    class="text-white font-weight-bolder mb-0 mt-3"
                    v-text="allAnimes"
                  ></h5>
                  <span class="text-white text-sm">All Anime & Movie</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
          <div
            class="card"
            style="
              background-image: url('../../../assets/img/curved-images/white-curved.jpg');
            "
          >
            <span class="mask bg-gradient-dark opacity-9 border-radius-xl"></span>
            <div class="card-body p-3 position-relative">
              <div class="row">
                <div class="col-8 text-start">
                  <div
                    class="icon icon-shape bg-white shadow text-center border-radius-md"
                  >
                    <i
                      class="fa fa-tv text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5 class="text-white font-weight-bolder mb-0 mt-3" v-text="tv"></h5>
                  <span class="text-white text-sm">Type TV</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-6 col-md-6 col-12">
          <div
            class="card"
            style="
              background-image: url('../../../assets/img/curved-images/white-curved.jpg');
            "
          >
            <span class="mask bg-gradient-dark opacity-9 border-radius-xl"></span>
            <div class="card-body p-3 position-relative">
              <div class="row">
                <div class="col-8 text-start">
                  <div
                    class="icon icon-shape bg-white shadow text-center border-radius-md"
                  >
                    <i
                      class="fa fa-video text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5 class="text-white font-weight-bolder mb-0 mt-3" v-text="movie"></h5>
                  <span class="text-white text-sm">Anime Movie</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
          <div
            class="card"
            style="
              background-image: url('../../../assets/img/curved-images/white-curved.jpg');
            "
          >
            <span class="mask bg-gradient-dark opacity-9 border-radius-xl"></span>
            <div class="card-body p-3 position-relative">
              <div class="row">
                <div class="col-8 text-start">
                  <div
                    class="icon icon-shape bg-white shadow text-center border-radius-md"
                  >
                    <i
                      class="fa fa-user-tag text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5
                    class="text-white font-weight-bolder mb-0 mt-3"
                    v-text="member_only"
                  ></h5>
                  <span class="text-white text-sm">Member Only</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-12 mt-4 mt-lg-0">
      <div class="card h-100 fixed">
        <div class="card-body">
          <apexchart
            height="100%"
            :type="chart.type"
            :options="chart.options"
            :series="chart.series"
          ></apexchart>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    allAnimes: Number,
    member_only: Number,
    tv: Number,
    movie: Number,
    chart: Object,
  },
};
</script>
