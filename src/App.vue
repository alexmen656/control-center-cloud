<script setup lang="ts">
import { RouterView, useRoute } from 'vue-router'
import { computed } from 'vue'
import AppHeader from './components/AppHeader.vue'

const route = useRoute()

const showHeader = computed(() => {
  return !['landing', 'login', 'signup'].includes(route.name as string)
})
</script>

<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <AppHeader v-if="showHeader" />
    <main>
      <RouterView />
    </main>
  </div>
</template>

<style>
/* Global styles are handled by Tailwind CSS */
</style>
