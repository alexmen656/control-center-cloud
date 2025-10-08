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
  <div id="app" class="min-h-screen" :class="showSidebar ? 'app-with-sidebar' : 'bg-gray-50'">
    <AppHeader v-if="showHeader" />
    <div class="flex h-full">
      <AppSidebar v-if="showSidebar" />
      <main :class="showSidebar ? 'ml-64 w-full main-content' : 'w-full'">
        <RouterView /><!--pt-15-->
      </main>
    </div>
  </div>
</template>

<style scoped>
.app-with-sidebar {
  background: #eff3f6;
}

.main-content {
  border-top-left-radius: 16px;
  /*24*/
  background: white;
  overflow: hidden;
  margin-top: 60px;
  min-height: calc(100vh - 60px);
}
</style>