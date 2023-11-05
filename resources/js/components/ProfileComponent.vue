<template>
<div id="app">
  <div class="row">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-body text-center">
          <img src="/images/women_avatar.jpg" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
          <h5 class="my-3">{{ user.name }} {{ user.lastname }}</h5>
          <p class="text-muted mb-1">{{ user.email }}</p>
          <p class="text-muted mb-4">{{ user.phone }}</p>
          <div class="d-flex justify-content-center mb-2">
            <button type="button" class="btn btn-outline-success text-white ms-1"><a href="/conversations">Edit Profile</a></button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="text-center">
              <h3 class="mb-0"><strong>Personal Information:</strong></h3>
            </div><br><br>
            <hr>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">Full Name:</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0 text-black">{{ user.name }} {{ user.lastname }}</p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">Email:</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ user.email }}</p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">Phone:</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ user.phone }}</p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">User Type:</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ user.user_type }}</p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">Joined in:</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ user.created_at }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import axios from "axios";
export default {
  mounted() {
    this.loadUsers();
  },
  props: ["user"],
  data() {
    return {
      users: {},
      editmode: false,
      
    };
  },
  methods: {
    loadUsers() {
      axios.get("api/users").then(({
        data
      }) => (this.users = data));
    }
  },
};
</script>

<style>

</style>
