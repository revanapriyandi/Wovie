<template>
  <layout title="Users" page="Users" subpage="Report">
    <Widget
      :userActive="userActive"
      :premiumUser="premiumUser"
      :verifiedUser="verifiedUser"
      :userInActive="userInActive"
      :chart="chart"
    />
    <TableUser :users="users" />
  </layout>
</template>

<script>
import Layout from "@/Layouts/AppLayout";
import Widget from "@/Pages/Admin/User/part/widget";
import TableUser from "@/Pages/Admin/User/part/table";

export default {
  components: {
    Layout,
    Widget,
    TableUser,
  },

  props: {
    users: Array,
    userActive: Number,
    premiumUser: Number,
    userInActive: Number,
    verifiedUser: Number,
    chart: Object,
  },
};
</script>
