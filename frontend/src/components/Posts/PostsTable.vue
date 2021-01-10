<template>
  <div class="card">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">Wpisy</h3>
        </div>
        <div class="col text-right">
          <a href="#" @click="$router.push({name: 'posts-add'})" class="btn btn-sm btn-primary">Dodaj</a>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <base-table v-if="this.posts" thead-classes="thead-light"
                  :data="this.posts">
        <template slot="columns">
          <th>Id</th>
          <th>Tytuł</th>
          <th>Treść</th>
          <th>Publiczny</th>
          <th>Opublikowano</th>
          <th>Akcje</th>
        </template>

        <template slot-scope="{row}">
          <td>
            {{row.id}}
          </td>
          <th scope="row">
            {{row.title}}
          </th>
          <td>
            {{limitStr(row.content)}}
          </td>
          <td>
            {{row.is_published ? 'Tak' : 'Nie'}}
          </td>
          <td>
            {{row.published_at}}
          </td>
          <td>
            <a href="#" @click="$router.push({name: 'posts-update', params: {id: row.id}})">Edytuj</a> | <a href="#!" @click="remove(row)" style="color: indianred;">Usuń</a>
          </td>
        </template>

      </base-table>
    </div>

  </div>
</template>
<script>
  export default {
    name: 'posts-visits-table',
    methods: {
      remove(post) {
        this.$store.dispatch('removePost', { id: post.id })
      }
    },
    computed: {
      posts(){
        return this.$store.getters.getPosts
      },    },
    created() {
      this.$store.dispatch('fetchPosts')
    }
  }
</script>
<style>
</style>
