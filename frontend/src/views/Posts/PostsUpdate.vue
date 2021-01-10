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
            <h1 class="display-2 text-white">Edytuj wpis</h1>
          </div>
        </div>
      </div>
    </base-header>

    <posts-form :post="post" @post-submitted="handleFormSubmit"></posts-form>
  </div>
</template>
<script>
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'
import PostsForm from "@/components/Posts/PostsForm";

export default {
  name: 'posts-add',
  data() {
    return {
      errors: {
        title: '',
        content: '',
      }
    }
  },
  components: {
    'posts-form': PostsForm
  },
  computed: {
    post() {
      return this.$store.getters.getPost
    }
  },
  methods: {
    handleFormSubmit(post) {
      this.$store.dispatch('updatePost', post)
      this.$router.push({name: 'posts'})
    },
  },
  created() {
    this.$store.dispatch('fetchPost', {id: this.$route.params.id})
  }
};
</script>
<style></style>
