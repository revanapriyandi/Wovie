<template>
  <layout title="Episode" page="Episode" subpage="Report">
    <TableEpisode :episodes="episodes" />
  </layout>
</template>

<script>
import Layout from "@/Layouts/AppLayout";
import TableEpisode from "@/Pages/Admin/Anime/Episode/partials/table";

export default {
  components: {
    Layout,
    TableEpisode,
  },

  props: {
    episodes: Array,
  },
};
</script>
