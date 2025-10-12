<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Recent Files</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Your recently accessed files and
                            folders</p>
                    </div>
                    <!--<button
                        class="bg-primary-600 text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-primary-700 transition-colors">
                        Clear History
                    </button>-->
                    <div class="flex space-x-2 mb-6">
                        <button @click="filterPeriod = 'today'"
                            :class="filterPeriod === 'today' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium">Today</button>
                        <button @click="filterPeriod = 'week'"
                            :class="filterPeriod === 'week' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium">This
                            Week</button>
                        <button @click="filterPeriod = 'month'"
                            :class="filterPeriod === 'month' ? 'bg-primary-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="px-4 py-2 rounded-lg text-sm font-medium">This
                            Month</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                <div v-if="loading" class="p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">Loading recent files...</p>
                </div>
                <div v-else-if="filteredFiles.length === 0" class="p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">No recent files found</p>
                </div>
                <div v-else class="p-3 space-y-2">
                    <div v-for="file in filteredFiles" :key="file.path + file.drive"
                        class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg cursor-pointer transition-colors">
                        <div :class="getFileIconClass(file.type)"
                            class="w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5" :class="getFileIconColor(file.type)" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ file.name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ formatFileSize(file.size) }} • {{ getTimeAgo(file.accessed_at) }} • {{ file.drive }}
                            </p>
                        </div>
                        <button class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { filesApi } from '@/services/api'
import formatUnit from '@/utils/formatUnit'

interface RecentFile {
    name: string
    path: string
    size: number
    type: string
    drive: string
    accessed_at: string
    modified: string
}

const recentFiles = ref<RecentFile[]>([])
const loading = ref(true)
const filterPeriod = ref<'today' | 'week' | 'month'>('today')

const loadRecentFiles = async () => {
    try {
        loading.value = true
        const data = await filesApi.getRecentFiles()
        recentFiles.value = data
    } catch (error) {
        console.error('Error loading recent files:', error)
    } finally {
        loading.value = false
    }
}

const filteredFiles = computed(() => {
    const now = new Date()
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
    const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000)
    const monthAgo = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000)

    return recentFiles.value.filter(file => {
        const accessedDate = new Date(file.accessed_at)

        if (filterPeriod.value === 'today') {
            return accessedDate >= today
        } else if (filterPeriod.value === 'week') {
            return accessedDate >= weekAgo
        } else if (filterPeriod.value === 'month') {
            return accessedDate >= monthAgo
        }
        return true
    })
})

const formatFileSize = (bytes: any) => {
    const result = formatUnit(bytes.replace(" bytes", ""))
    return `${Math.round(result.value)} ${result.unit}`
}

const getTimeAgo = (dateString: string) => {
    const date = new Date(dateString)
    const now = new Date()
    const diff = now.getTime() - date.getTime()

    const seconds = Math.floor(diff / 1000)
    const minutes = Math.floor(seconds / 60)
    const hours = Math.floor(minutes / 60)
    const days = Math.floor(hours / 24)

    if (days > 0) return `${days} day${days > 1 ? 's' : ''} ago`
    if (hours > 0) return `${hours} hour${hours > 1 ? 's' : ''} ago`
    if (minutes > 0) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`
    return 'just now'
}

const getFileIconClass = (type: string) => {
    if (type === 'folder') return 'bg-yellow-100 dark:bg-yellow-900/30'
    if (type.includes('image')) return 'bg-green-100 dark:bg-green-900/30'
    if (type.includes('video')) return 'bg-purple-100 dark:bg-purple-900/30'
    if (type.includes('pdf')) return 'bg-red-100 dark:bg-red-900/30'
    return 'bg-blue-100 dark:bg-blue-900/30'
}

const getFileIconColor = (type: string) => {
    if (type === 'folder') return 'text-yellow-600 dark:text-yellow-400'
    if (type.includes('image')) return 'text-green-600 dark:text-green-400'
    if (type.includes('video')) return 'text-purple-600 dark:text-purple-400'
    if (type.includes('pdf')) return 'text-red-600 dark:text-red-400'
    return 'text-blue-600 dark:text-blue-400'
}

onMounted(() => {
    loadRecentFiles()
})
</script>
