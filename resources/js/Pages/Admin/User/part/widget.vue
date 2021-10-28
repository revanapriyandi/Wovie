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
                      class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5
                    class="text-white font-weight-bolder mb-0 mt-3"
                    v-text="userActive"
                  ></h5>
                  <span class="text-white text-sm">Users Active</span>
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
                      class="ni ni-user-run text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5
                    class="text-white font-weight-bolder mb-0 mt-3"
                    v-text="premiumUser"
                  ></h5>
                  <span class="text-white text-sm">Premium Users</span>
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
                      class="ni ni-check-bold text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5
                    class="text-white font-weight-bolder mb-0 mt-3"
                    v-text="verifiedUser"
                  ></h5>
                  <span class="text-white text-sm">Verified Users</span>
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
                      class="ni ni-ungroup text-dark text-gradient text-lg opacity-10"
                      aria-hidden="true"
                    ></i>
                  </div>
                  <h5
                    class="text-white font-weight-bolder mb-0 mt-3"
                    v-text="userInActive"
                  ></h5>
                  <span class="text-white text-sm">InActive Users</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-12 mt-4 mt-lg-0 chart">
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
    userActive: Number,
    premiumUser: Number,
    userInActive: Number,
    verifiedUser: Number,
    chart: Object,
  },
};
</script>
