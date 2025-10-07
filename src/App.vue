<script setup lang="ts">
import { RouterView, useRoute } from 'vue-router'
import { computed } from 'vue'
import AppHeader from './components/AppHeader.vue'
import AppSidebar from './components/AppSidebar.vue'

const route = useRoute()

const showHeader = computed(() => {
  return !['landing', 'login', 'signup'].includes(route.name as string)
})

const showSidebar = computed(() => {
  return !['landing', 'login', 'signup'].includes(route.name as string)
})
</script>

<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <AppHeader v-if="showHeader" />
    <div class="flex">
      <AppSidebar v-if="showSidebar" />
      <main :class="showSidebar ? 'ml-64 pt-16 w-full' : 'w-full'">
        <RouterView />
      </main>
    </div>
  </div>
</template>

<style>
/* Global styles are handled by Tailwind CSS */
</style>
