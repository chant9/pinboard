<template>

  <div v-for="article in articlesFiltered" :key="article.id"
       class="relative p-4 flex flex-col gap-2 border rounded-lg shadow-md bg-white hover:bg-gray-100"
      :class="{'hover:bg-red-100' : !article.available}">
    <a class="text-xl font-semibold text-blue-700 hover:underline two-lines
              after:content-[''] after:absolute after:top-0 after:bottom-0 after:left-0 after:right-0"
      :href="article.url"
       target="_blank"
      :title="!article.available ? 'Sorry this link is no longer available' : ''">
      {{ article.title }}
    </a>

    <p class="text-gray-800 two-lines">{{ article.description }}</p>

    <div class="flex flex-wrap gap-2 text-xs text-gray-600">
      <span v-for="tag in article.tags" :key="article.tags.id" class="px-2 py-0.5 rounded-full bg-gray-200">
          {{ tag.name }}
      </span>
    </div>

    <LinkIcon v-show="article.available" class="size-5 text-grey-100 absolute bottom-4 right-4 zindex-1" />
    <LinkSlashIcon v-show="!article.available" class="size-5 text-red-600 absolute bottom-4 right-4 zindex-1" />
  </div>

  <div v-show="!articlesFiltered.length" class="p-4 flex items-center text-center flex-col col-span-2 gap-2 bg-white">
    Sorry no articles have been found.
  </div>

</template>

<script>
import { LinkIcon, LinkSlashIcon } from '@heroicons/vue/24/solid';

export default {

  components: { LinkIcon, LinkSlashIcon },

  props: {
    articlesFiltered: Array,
  },

}
</script>