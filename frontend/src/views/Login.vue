<template>
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>Zaloguj się</small>
                        </div>
                        <form @submit.prevent="handleLoginFormSubmit" method="post" role="form">
                            <base-input class="input-group-alternative mb-3"
                                        placeholder="Email"
                                        addon-left-icon="ni ni-email-83"
                                        :error="errors.email ? errors.email : ''"
                                        v-model="model.email">
                            </base-input>

                            <base-input class="input-group-alternative"
                                        placeholder="Hasło"
                                        type="password"
                                        addon-left-icon="ni ni-lock-circle-open"
                                        :error="errors.password ? errors.password : ''"
                                        v-model="model.password">
                            </base-input>
                            <div class="text-center">
                                <base-button native-type="submit" type="primary" class="my-4">Zaloguj się</base-button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="#" class="text-light"><small>Zapomniałeś hasła?</small></a>
                    </div>
                    <div class="col-6 text-right">
                        <router-link to="/register" class="text-light"><small>Utwórz nowe konto</small></router-link>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
  import axios from 'axios'
  import localforage from 'localforage'

  export default {
    name: 'login',
    data() {
      return {
        model: {
          email: '',
          password: ''
        },
        errors: {
          email: '',
          password: ''
        }
      }
    },
    methods: {
      validate(){
        var validated = true
        this.errors.email = ''
        this.errors.password = ''

        var re = /\S+@\S+\.\S+/;

        if (!re.test(this.model.email)) {
          this.errors.email = 'Pole musi być poprawnym adresem email!'
          validated = false
        }

        if (this.model.email == '') {
          this.errors.email = 'Pole nie może być puste!'
          validated = false
        }

        if (this.model.password == '') {
          this.errors.password = 'Pole nie może być puste!'
          validated = false
        }

        return validated
      },
      handleLoginFormSubmit(){
        if (!this.validate()) {
          return;
        }
        const postData ={
          email: this.model.email,
          password: this.model.password
        }
        axios.post(process.env.VUE_APP_API+'api/login', postData, {
          'Content-Type': 'multipart/form-data'
        })
            .then(response => {
              if(response.status === 200){
                if(response.data){
                  const headers = {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + response.data
                  }
                  localforage.setItem('authUser', headers).then(() => {
                    this.$router.push({name:'dashboard'})
                  })
                }
              } else {
                this.errorNotify('Wystąpił błąd serwera. Skontaktuj się z administratorem serwisu')
              }
            })
            .catch(error => {
              if(error.response && error.response.status === 500){
                this.errorNotify('Wystąpił błąd serwera. Skontaktuj się z administratorem serwisu')
              } else {
                this.errorNotify('Nieprawidłowe dane logowania')
              }
            })
      },
    }
  }
</script>
<style>
</style>
