<script setup lang="ts">
import { RouterView } from 'vue-router'
import AppHeader from './components/AppHeader.vue'
</script>

<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <AppHeader />
    <main>
      <RouterView />
    </main>
  </div>
</template>

<style>
/* Global styles are handled by Tailwind CSS */
</style>
