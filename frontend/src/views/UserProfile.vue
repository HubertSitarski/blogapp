<template>
    <div>
        <base-header class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
                     style="min-height: 600px; background-image: url(img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
            <!-- Mask -->
            <span class="mask bg-gradient-success opacity-8"></span>
            <!-- Header container -->
            <div class="container-fluid d-flex align-items-center">
                <div class="row">
                    <div class="col-lg-7 col-md-10">
                        <h1 class="display-2 text-white" v-if="loggedUser">Cześć {{ loggedUser.name }}</h1>
                        <p class="text-white mt-0 mb-5">To strona Twojego profilu. Możesz tutaj edytować swoje dane lub podejrzeć zapisane informacje o swoim profilu.</p>
                    </div>
                </div>
            </div>
        </base-header>

        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">

                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="/img/default-avatar.png" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                            <div class="d-flex justify-content-between">
                            </div>
                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                        <div>
                                            <span class="description" v-if="loggedUser">{{ loggedUser.email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h3 v-if="loggedUser">
                                  {{ loggedUser.name }}<span class="font-weight-light"></span>
                                </h3>
                                <div class="h5 font-weight-300" v-if="loggedUser">
                                    <i class="ni location_pin mr-2"></i>{{ loggedUser.role }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 order-xl-1">
                    <card shadow type="secondary">
                        <div slot="header" class="bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Profil</h3>
                                </div>
                            </div>
                        </div>
                        <template>
                            <form @submit.prevent="handleFormSubmit">
                                <h6 class="heading-small text-muted mb-4">Informacje o użytkowniku</h6>
                                <div v-if="user" class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <base-input alternative=""
                                                        label="Nazwa"
                                                        placeholder="Nazwa"
                                                        :error="errors.name ? errors.name : ''"
                                                        input-classes="form-control-alternative"
                                                        v-model="user.name"
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <base-input alternative=""
                                                        label="Email"
                                                        placeholder="test@example.com"
                                                        :error="errors.email ? errors.email : ''"
                                                        input-classes="form-control-alternative"
                                                        v-model="user.email"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4" />
                              <div class="offset-10 col-2">
                                <base-button native-type="submit" type="primary">Zapisz</base-button>
                              </div>
                            </form>
                        </template>
                    </card>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import localforage from "localforage";

  export default {
    name: 'user-profile',
    data() {
      return {
        loggedUser: '',
        errors: {
          email: '',
          name: '',
        }
      }
    },
    methods: {
      validate(){
        var validated = true
        this.errors.email = ''
        this.errors.name = ''

        var re = /\S+@\S+\.\S+/;

        if (!re.test(this.user.email)) {
          this.errors.email = 'Pole musi być poprawnym adresem email!'
          validated = false
        }

        if (this.user.email == '') {
          this.errors.email = 'Pole nie może być puste!'
          validated = false
        }

        if (this.user.name == '') {
          this.errors.name = 'Pole nie może być puste!'
          validated = false
        }

        return validated
      },
      handleFormSubmit() {
        if (!this.validate()) {
          return;
        }

        this.$store.dispatch('updateUser', this.user)
        this.successNotify('Pomyślnie zaktualizowano konto')
      }
    },
    computed: {
      user(){
        return this.$store.getters.getUser
      },
    },
    created() {
      localforage.getItem('user').then((data) => {
        if (data) {
          this.loggedUser = data
          this.$store.dispatch('fetchUser', { id: data.id })
        }
      })
    }
  };
</script>
<style></style>
