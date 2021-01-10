<template>
  <div>
    <base-header class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
                 style="min-height: 600px; background-image: url(../../img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-success opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-12">
            <h1 class="display-2 text-white">Dodaj wpis</h1>
          </div>
        </div>
      </div>
    </base-header>

    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <card shadow type="secondary">
            <div slot="header" class="bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Wpis</h3>
                </div>
              </div>
            </div>
            <template>
              <form @submit.prevent="handleFormSubmit">
                <h6 class="heading-small text-muted mb-4">Podstawowe dane</h6>
                <div v-if="post" class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-12">
                      <base-input alternative=""
                                  label="Tytuł"
                                  placeholder="Tytuł"
                                  :error="errors.title ? errors.title : ''"
                                  input-classes="form-control-alternative"
                                  v-model="post.title"
                      />
                    </div>

                    <div class="col-lg-12">
                          <label class="form-control-label">
                            Treść
                          </label>
                      <quill-editor
                          ref="myQuillEditor"
                          v-model="post.content"
                          style="height: 200px; margin-bottom: 70px;"
                      />
                      <div class="text-danger invalid-feedback" style="display: block;" v-if="errors.content">
                        {{ errors.content }}
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <base-checkbox alternative=""
                                  input-classes="form-control-alternative"
                                  v-model="post.is_published"
                      >Publiczny</base-checkbox>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <h6 class="heading-small text-muted mb-4">Pliki</h6>
                <div class="col-lg-12">
                  <b-form-file
                      v-model="post.files"
                      multiple
                      :state="Boolean(post.files)"
                      placeholder="Wybierz pliki lub upuśc je tutaj..."
                      drop-placeholder="Upuść pliki tutaj..."
                  ></b-form-file>
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
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import { quillEditor } from 'vue-quill-editor'

export default {
  name: 'posts-add',
  data() {
    return {
      errors: {
        title: '',
        content: '',
      },
      post: {
        title: '',
        content: '',
        is_published: false,
        files: []
      }
    }
  },
  components: {
    quillEditor
  },
  methods: {
    validate(){
      console.log(this.post.files[0])
      var validated = true
      this.errors.title = ''
      this.errors.content = ''

      if (this.post.title == '') {
        this.errors.title = 'Pole nie może być puste!'
        validated = false
      }

      if (this.post.content == '') {
        this.errors.content = 'Pole nie może być puste!'
        validated = false
      }

      return validated
    },
    handleFormSubmit() {
      if (!this.validate()) {
        return;
      }

      this.$store.dispatch('createPost', this.post)
      this.$router.push({name: 'posts'})
    }
  }
};
</script>
<style></style>
