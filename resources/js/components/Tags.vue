<template>

  <div class="flex sm:justify-end flex-wrap sm:flex-nowrap gap-2 text-s text-gray-600 mb-6">
    <span class="py-0.5 font-bold text-gray-900">Filter:</span>
    <span v-for="tag in tags" :key="tag.id"
          class="px-2 py-0.5 rounded-full cursor-pointer "
          :class="{
              'text-gray-900 bg-gray-200 hover:text-white hover:bg-blue-700': !filters.includes(tag.id),
              'text-white bg-blue-700 hover:text-white hover:bg-blue-400': filters.includes(tag.id),
            }"
          @click="filter(tag.id)"
    >
      {{ tag.name }}
    </span>
  </div>

</template>

<script>
  export default {

    props: {
      filters: Array,
      tags: Array,
    },

    methods: {
      filter(tag) {
        this.$emit('filter', tag);
      }
    },

  }
</script>
