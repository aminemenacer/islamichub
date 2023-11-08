<template>
<div id="app">
  <h2 class="text-center mt-4 mb-4">Profile Page</h2>

  <!-- edit user -->
  <div class="modal fade" id="editNew" tabindex="-1" aria-labelledby="editNew" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="addNew">
            Edit user
          </h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="updateUser()">
            <div class="form-group mr-3" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Firstname:</label>
              <input v-model="form.name" type="text" name="name" placeholder="Enter firstname" class="form-control" />
            </div>

            <div class="form-group mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">lastname:</label>
              <input v-model="form.lastname" type="text" name="lastname" placeholder="Enter lastname" class="form-control" />
            </div>

            <div class="form-group" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Email:</label>
              <input v-model="form.email" name="email" id="email" placeholder="Enter email" class="form-control" />
            </div>

            <div class="form-group mr-2" style="display: flex">
              <label class="mt-2 mr-2 col-sm-3">Phone number:</label>
              <input v-model="form.phone" type="text" name="phone" placeholder="Enter phone number" class="form-control" />
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
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

  <div class="row">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-body text-center">
          <img src="/images/women_avatar.jpg" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
          <h5 class="my-3">{{ user.name }} {{ user.lastname }}</h5>
          <p class="text-muted mb-1">{{ user.email }}</p>
          <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#editNew" type="button" class="btn text-white user-btn mr-2" style="background-color: #43a047" @click="editModal(slotProps.data)">
              <i class="pi pi-user-edit"></i>
              Edit Profile
            </button>
            <button data-bs-toggle="modal" data-bs-target="#editNew" type="button" class="btn text-white user-btn mr-2" style="background-color: purple" >
              <i class="pi pi-user-edit"></i>
              Homepage
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
      users: [],
      editmode: false,
      form: new Form({
        id: "",
        name: "",
        lastname: "",
        email: "",
        phone: "",
        status: "",
        user_type: "",
      }),

    };
  },
  methods: {
    updateUser() {
      Swal.fire({
          title: "Are you sure you want to update?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, update user!",
        },
        1000
      ).then((result) => {
        if (result.isConfirmed) {
          axios.post(`api/update-users/${this.form.id}`, this.form);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "User updated successfully ",
            showConfirmButton: false,
            timer: 1500,
          });

          this.loadUsers();

          $("#editNew").modal("hide");

          self.close();
        }
      });
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
