<template>
<div id="app">

  <!-- edit new Modal -->
  <div class="modal fade" id="editNew" tabindex="-1" aria-labelledby="editNew" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="addNew">
              Edit user
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="updateUser()">
            <div class="form-group mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Firstname:</label>
              <input v-model="form.name" type="text" name="name" placeholder="Enter name" class="form-control" />
            </div>

            <div class="form-group mr-2" style="display: flex">
                <label class="mt-2 mr-2 col-sm-3">Lastname:</label>
              <input v-model="form.lastname" type="text" name="lastname" placeholder="Enter lastname" class="form-control" />
            </div>

            <div class="form-group mr-2" style="display: flex">
                <label class="mt-2 mr-2 col-sm-3">Password:</label>
                <input v-model="form.password" type="text" name="password" placeholder="Enter password" class="form-control" />
            </div>

            <div class="form-group" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Email:</label>
              <input v-model="form.email" name="email" id="email" placeholder="email" class="form-control" />
            </div>

            <div class="form-group mr-2" style="display: flex">
                <label class="mt-2 mr-2 col-sm-3">Phone number:</label>
              <input v-model="form.phone" type="text" name="phone" placeholder="Enter mobile number" class="form-control" />
            </div>

            <div class="form-group mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">User Type:</label>

              <select class="form-control" name="user_type" v-model="form.user_type">
                <option disabled>Select User Type</option>
                <option value="Super Admin">Super Admin</option>
                <option value="Admin">Admin</option>
                <option value="Client">Client</option>
                <option value="Content Creator">Content Creator</option>
              </select>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">
                Close
              </button>

              <button type="submit" class="btn btn-primary">
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- profile section -->
  <div class="row pt-5">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-body text-center">
          <img src="/images/user.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
          <h5 class="my-3">{{ user.name }} {{ user.lastname }}</h5>
          <p class="text-muted mb-3">{{ user.email }}</p>
          <div class="d-flex justify-content-center mb-2 mt-2">
            <button data-toggle="modal" data-target="#editNew" type="button" class="btn text-white user-btn mr-2 bg-secondary"  @click="editModal(user)">
              Edit Profile
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="text-center">
              <h3 class="mb-3"><strong>Personal Information:</strong></h3>
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

  props: ["user"],
  data() {
    return {
      users: {},
      editmode: false,
      form: new Form({
        id: "",
        name: "",
        email: "",
        lastname: "",
        phone: "",
        user_type: "",
        password: ""
      }),

    };
  },
  methods: {
    loadUsers() {
      axios.get("api/fetch-users").then((data) => {
        this.users = data.data;
      });
    },
    updateUser() {
      Swal.fire({
        title: "Are you sure?",
        text: "You want to update user !",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update user!",
        },
        1000
      ).then((result) => {
        if (result.isConfirmed) {
          axios.post(`api/update-users/${this.form.id}`, this.form);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "User created successfully ",
            showConfirmButton: false,
            timer: 1500,
          });
          window.location.reload();
          this.loadUsers();
          $("#editNew").modal("hide");
          self.close();
        }
      });
    },

    // add new modal
    newModal(user) {
      this.form.reset();
      $("#addNew").modal("show");
    },
    //edit user modal
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      this.form.fill(user);
    },
    viewModal(user) {
      this.form.reset();
      $("#view").modal("show");
      this.form.fill(user);
    },
  },
};
</script>

<style>

</style>
