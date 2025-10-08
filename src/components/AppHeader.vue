<template>
    <header class="bg-white fixed top-0 left-0 right-0 z-50">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-15">
                <div class="flex items-center">
                    <div @click="router.push('/dashboard')" class="flex-shrink-0 flex items-center logo-container">
                        <img data-v-c970699f="" class="logo-image" src="../assets/logo.png" alt="Logo">
                        <span class="ml-3 text-xl font-semibold text-gray-900"><span class="logo-text">
                                Control Cloud</span></span>
                    </div>
                </div>
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <div class="relative w-full">
                        <input type="text" placeholder="Search files and folders..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent" />
                        <SearchIcon class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" />
                    </div>
                </div>
                <!---
                <nav class="hidden md:flex space-x-6">
                    <RouterLink to="/dashboard"
                        class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                        active-class="text-primary-600 bg-primary-50">
                        Files
                    </RouterLink>
                    <RouterLink to="/recent"
                        class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                        active-class="text-primary-600 bg-primary-50">
                        Recent
                    </RouterLink>
                    <RouterLink to="/shared"
                        class="text-gray-600 hover:text-primary-600 px-3 py-2 rounded-md text-sm font-medium transition-colors"
                        active-class="text-primary-600 bg-primary-50">
                        Shared
                    </RouterLink>
                </nav>--->
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <BellIcon class="w-5 h-5" />
                    </button>
                    <div class="relative">
                        <button @click="toggleUserMenu"
                            class="flex items-center space-x-3 hover:bg-gray-50 rounded-lg px-3 py-2 transition-colors">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                {{ userInitial }}
                            </div>
                            <span class="hidden sm:block text-sm font-medium text-gray-700">{{ username }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div v-if="userMenuOpen"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-900">{{ username }}</p>
                                <p class="text-xs text-gray-500">{{ role }}</p>
                            </div>
                            <button @click="handleLogout"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Sign out</span>
                            </button>
                        </div>
                    </div>
                    <button @click="toggleMobileMenu" class="md:hidden p-2 text-gray-400 hover:text-gray-600">
                        <MenuIcon v-if="!mobileMenuOpen" class="w-6 h-6" />
                        <XIcon v-else class="w-6 h-6" />
                    </button>
                </div>
            </div>
            <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-200 pt-4 pb-4">
                <div class="space-y-1">
                    <RouterLink to="/dashboard"
                        class="block px-3 py-2 text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-md text-base font-medium"
                        @click="closeMobileMenu">
                        Files
                    </RouterLink>
                    <RouterLink to="/recent"
                        class="block px-3 py-2 text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-md text-base font-medium"
                        @click="closeMobileMenu">
                        Recent
                    </RouterLink>
                    <RouterLink to="/shared"
                        class="block px-3 py-2 text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-md text-base font-medium"
                        @click="closeMobileMenu">
                        Shared
                    </RouterLink>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const mobileMenuOpen = ref(false)
const userMenuOpen = ref(false)

const username = computed(() => authStore.username || 'User')
const role = computed(() => authStore.role || 'user')
const userInitial = computed(() => username.value.charAt(0).toUpperCase())

const toggleMobileMenu = () => {
    mobileMenuOpen.value = !mobileMenuOpen.value
}

const closeMobileMenu = () => {
    mobileMenuOpen.value = false
}

const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value
}

const handleLogout = () => {
    authStore.logout()
    userMenuOpen.value = false
    router.push('/login')
}

const SearchIcon = {
    template: `
    <svg viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
    </svg>
  `
}

const BellIcon = {
    template: `
    <svg viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 00.515 1.076 32.91 32.91 0 003.256.508 3.5 3.5 0 006.972 0 32.903 32.903 0 003.256-.508.75.75 0 00.515-1.076A11.448 11.448 0 0116 8a6 6 0 00-6-6zM8.05 14.943a33.54 33.54 0 003.9 0 2 2 0 01-3.9 0z" clip-rule="evenodd" />
    </svg>
  `
}

const UserIcon = {
    template: `
    <svg viewBox="0 0 20 20" fill="currentColor">
      <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
    </svg>
  `
}

const MenuIcon = {
    template: `
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <line x1="3" y1="6" x2="21" y2="6"></line>
      <line x1="3" y1="12" x2="21" y2="12"></line>
      <line x1="3" y1="18" x2="21" y2="18"></line>
    </svg>
  `
}

const XIcon = {
    template: `
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <line x1="18" y1="6" x2="6" y2="18"></line>
      <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
  `
}
</script>

<style scoped>
.logo-text {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -0.8px;
    line-height: 1;
    transition: color 0.2s ease;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #ea0e2b;
    cursor: pointer;
}

.logo-image {
    height: 32px;
    width: auto;
    transition: transform 0.2s ease;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 14px;
    height: 100%;
    justify-content: flex-start;
    padding: 4px 0;
}

header {
    background: #eff3f6;
}
</style>