<template>
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-body px-lg-5 py-lg-5">
                    <div class="text-center text-muted mb-4">
                        <small>Zarejestruj się</small>
                    </div>
                    <form @submit.prevent="handleFormSubmit" role="form">

                        <base-input class="input-group-alternative mb-3"
                                    placeholder="Nazwa"
                                    :error="errors.name ? errors.name : ''"
                                    addon-left-icon="ni ni-hat-3"
                                    v-model="model.name">
                        </base-input>

                        <base-input class="input-group-alternative mb-3"
                                    placeholder="Email"
                                    :error="errors.email ? errors.email : ''"
                                    addon-left-icon="ni ni-email-83"
                                    v-model="model.email">
                        </base-input>

                        <base-input class="input-group-alternative"
                                    placeholder="Hasło"
                                    type="password"
                                    :error="errors.password ? errors.password : ''"
                                    addon-left-icon="ni ni-lock-circle-open"
                                    v-model="model.password">
                        </base-input>

                      <base-input class="input-group-alternative"
                                  placeholder="Potwierdź hasło"
                                  type="password"
                                  :error="errors.password_confirm ? errors.password_confirms : ''"
                                  addon-left-icon="ni ni-lock-circle-open"
                                  v-model="model.password_confirm">
                      </base-input>

                        <div class="text-muted font-italic">
                            <small>Siła hasła: <span class="text-success font-weight-700"></span><span :class="checkPassStrength(model.password)['class']">{{checkPassStrength(model.password)['text']}}</span></small>
                        </div>

                        <div class="text-center">
                            <base-button native-type="submit" type="primary" class="my-4">Utwórz konto</base-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-6">
                    <a href="#" class="text-light">
                        <small>Zapomniałeś hasła?</small>
                    </a>
                </div>
                <div class="col-6 text-right">
                    <router-link to="/login" class="text-light">
                        <small>Zaloguj się</small>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import axios from "axios";

  export default {
    name: 'register',
    data() {
      return {
        model: {
          name: '',
          email: '',
          password: '',
          password_confirm: ''
        },
        errors: {
          email: '',
          password: '',
          password_confirm: '',
          name: ''
        }
      }
    },
    methods: {
      validate(){
        var validated = true
        this.errors.email = ''
        this.errors.password = ''
        this.errors.password_confirm = ''
        this.errors.name = ''

        var re = /\S+@\S+\.\S+/;

        if (!re.test(this.model.email)) {
          this.errors.email = 'Pole musi być poprawnym adresem email!'
          validated = false
        }

        if (this.model.password_confirm !== this.model.password) {
          this.errors.password = 'Hasła nie zgadzają się!'
          validated = false
        }

        if (this.model.email == '') {
          this.errors.email = 'Pole nie może być puste!'
          validated = false
        }

        if (this.model.name == '') {
          this.errors.name = 'Pole nie może być puste!'
          validated = false
        }

        if (this.model.password == '') {
          this.errors.password = 'Pole nie może być puste!'
          validated = false
        }

        if (this.model.password_confirm == '') {
          this.errors.password_confirm = 'Pole nie może być puste!'
          validated = false
        }

        return validated
      },
      handleFormSubmit(){
        if (!this.validate()) {
          return;
        }
        const postData ={
          email: this.model.email,
          password: this.model.password,
          password_confirmation: this.model.password_confirm,
          name: this.model.name
        }
        axios.post(process.env.VUE_APP_API+'api/register', postData, {
          'Content-Type': 'multipart/form-data'
        })
            .then(response => {
              if(response.status === 201){
                if(response.data){
                  this.successNotify('Pomyślnie utworzono konto. Możesz się zalogować')
                  this.$router.push({name:'login'})
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
      scorePassword(pass) {
        let score = 0;
        if (!pass)
          return score;

        let letters = new Object();
        for (var i=0; i<pass.length; i++) {
          letters[pass[i]] = (letters[pass[i]] || 0) + 1;
          score += 5.0 / letters[pass[i]];
        }

        let variations = {
          digits: /\d/.test(pass),
          lower: /[a-z]/.test(pass),
          upper: /[A-Z]/.test(pass),
          nonWords: /\W/.test(pass),
        }

        let variationCount = 0;
        for (var check in variations) {
          variationCount += (variations[check] == true) ? 1 : 0;
        }
        score += (variationCount - 1) * 10;

        return parseInt(score);
      },
      checkPassStrength(pass) {
        let score = this.scorePassword(pass);
        let value = []
        value['class'] = 'text-danger'
        value['text'] = 'słabe'

        if (score > 80) {
          value['class'] = 'text-success'
          value['text'] = 'silne'
        } else if (score > 60) {
          value['class'] = 'text-warning-bright'
          value['text'] = 'średnie'
        }

        return value;
      }
    },
  }
</script>
<style>
</style>
