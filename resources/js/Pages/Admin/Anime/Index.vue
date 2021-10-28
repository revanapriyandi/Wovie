<template>
  <layout title="Anime" page="Anime" subpage="Report">
    <Widget
      :allAnimes="allAnimes"
      :member_only="member_only"
      :tv="tv"
      :movie="movie"
      :chart="chart"
    />
    <TableAnime :animes="animes" />
  </layout>
</template>

<script>
import Layout from "@/Layouts/AppLayout";
import TableAnime from "@/Pages/Admin/Anime/partials/table";
import Widget from "@/Pages/Admin/Anime/partials/widget";

export default {
  components: {
    Layout,
    TableAnime,
    Widget,
  },

  props: {
    animes: Array,
    allAnimes: Number,
    member_only: Number,
    tv: Number,
    movie: Number,
    chart: Object,
  },
};
</script>
