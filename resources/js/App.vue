<template>

  <div class="h-screen w-full">
    <section class="flex flex-col justify-center max-w-7xl px-4 py-10 mx-auto sm:px-6">

      <div class="grid grid-cols-1 sm:grid-cols-2 px-1 flex items-center">
        <h2 class="mb-6 text-2xl font-bold text-gray-900 md:text-3xl">
          Articles
        </h2>

        <Tags v-show="!!tags.length" :tags="tags" :filters="filters" @filter="filter"></Tags>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-1">

        <Articles :articlesFiltered="articlesFiltered"></Articles>

      </div>

    </section>
  </div>

</template>

<script>
  import axios from "axios";
  import Articles from './components/Articles.vue';
  import Tags from './components/Tags.vue';

  export default {

    components: { Articles, Tags },

    data() {
      return {
        articles: [],
        tags: [],
        filters: [],
      }
    },

    mounted() {
      axios
          .get('/api/tags')
          .catch((error) => console.log(error))
          .then((response) => {
            this.tags = response.data
          }),
          axios
              .get('/api/articles')
              .catch((error) => console.log(error))
              .then((response) => {
                this.articles = response.data
              })
    },

    computed: {
      articlesFiltered() {
        return (!this.filters.length) ?
            this.articles :
            this.articles.filter(a => this.filters.every(f => a.tags.map(t => t.id).includes(f)))
      }
    },

    methods: {
      filter(tag) {
        if (!this.filters.includes(tag)) {
          this.filters.push(tag);
        }
        else
        {
          this.filters = this.filters.filter(function(t) { return t !== tag });
        }
      }
    }
  }
</script>