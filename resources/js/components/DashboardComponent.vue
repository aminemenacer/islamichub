<template>
<div id="app">
  <h1>Dashboard</h1>
</div>
</template>

<style>

</style>

<script>
export default {

  data() {
    return {
      id: ''
    }
  },
  methods: {
    loadDashboards() {
      axios.get("api/fetch-dashboards").then((data) => {
        this.dashboards = data.data;
      });
    },
  }
}
</script>
