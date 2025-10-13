<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Shared with Me</h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Files and folders shared by others</p>
                    </div>
                    <div class="relative sort-menu-container">
                        <button @click="showSortMenu = !showSortMenu"
                            class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center space-x-2">
                            <span>Sort by: {{ sortLabels[sortBy] }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div v-if="showSortMenu"
                            class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                            <div class="py-1">
                                <button @click="setSortBy('name')"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-between">
                                    <span>Name</span>
                                    <svg v-if="sortBy === 'name'" class="w-4 h-4 text-primary-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button @click="setSortBy('owner')"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-between">
                                    <span>Owner</span>
                                    <svg v-if="sortBy === 'owner'" class="w-4 h-4 text-primary-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button @click="setSortBy('date')"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-between">
                                    <span>Date Shared</span>
                                    <svg v-if="sortBy === 'date'" class="w-4 h-4 text-primary-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button @click="setSortBy('drive')"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center justify-between">
                                    <span>Drive</span>
                                    <svg v-if="sortBy === 'drive'" class="w-4 h-4 text-primary-600" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div v-if="sortedSharedFiles.length === 0" class="p-8 text-center">
                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">No files shared with you yet</p>
                </div>
                <div v-else class="p-3 space-y-2">
                    <div v-for="file in sortedSharedFiles" :key="file.id" @click="openFilePreview(file)"
                        class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg cursor-pointer transition-colors group">
                        <div
                            class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{
                                getFileName(file.file_path)
                            }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Shared by {{ file.owner }} • {{
                                formatDate(file.shared_at) }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-1 rounded">Drive:
                                {{ file.drive }}</span>
                            <button @click.stop="toggleStar(file)"
                                class="p-1.5 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-full opacity-0 group-hover:opacity-100 transition-opacity"
                                title="Star">
                                <svg class="w-4 h-4"
                                    :class="file.starred ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400'"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <FilePreviewModal :show="showPreview" :fileName="selectedFile?.file_path || ''"
            :filePath="selectedFile?.file_path || ''" :fileSize="''" :drive="selectedFile?.drive || ''"
            :owner="selectedFile?.owner || ''" @close="closePreview" />
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import FilePreviewModal from '../components/FilePreviewModal.vue'

interface SharedFile {
    id: number
    owner: string
    drive: string
    file_path: string
    share_with: string
    shared_at: string
    starred?: boolean
}

const sharedFiles = ref<SharedFile[]>([])
const token = localStorage.getItem('auth_token') || ''
const showSortMenu = ref(false)
const sortBy = ref<'name' | 'owner' | 'date' | 'drive'>('date')
const showPreview = ref(false)
const selectedFile = ref<SharedFile | null>(null)

const sortLabels = {
    name: 'Name',
    owner: 'Owner',
    date: 'Date Shared',
    drive: 'Drive'
}

const sortedSharedFiles = computed(() => {
    const files = [...sharedFiles.value]

    switch (sortBy.value) {
        case 'name':
            return files.sort((a, b) => getFileName(a.file_path).localeCompare(getFileName(b.file_path)))
        case 'owner':
            return files.sort((a, b) => a.owner.localeCompare(b.owner))
        case 'date':
            return files.sort((a, b) => new Date(b.shared_at).getTime() - new Date(a.shared_at).getTime())
        case 'drive':
            return files.sort((a, b) => a.drive.localeCompare(b.drive))
        default:
            return files
    }
})

const loadSharedFiles = async () => {
    try {
        const response = await axios.get('https://alex.polan.sk/control-center/cloud/files.php?action=get_shared_files', {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })

        const username = localStorage.getItem('username') || ''
        const starredFiles = await loadStarredFiles(username)

        sharedFiles.value = response.data.map((file: SharedFile) => ({
            ...file,
            starred: starredFiles.some(
                (starred: any) => starred.owner === file.owner &&
                    starred.drive === file.drive &&
                    starred.file_path === file.file_path
            )
        }))
    } catch (error) {
        console.error('Error fetching shared files:', error)
    }
}

const loadStarredFiles = async (username: string) => {
    try {
        const response = await axios.get('https://alex.polan.sk/control-center/cloud/files.php?action=get_starred_shared', {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        return response.data || []
    } catch (error) {
        console.error('Error loading starred files:', error)
        return []
    }
}

const toggleStar = async (file: SharedFile) => {
    try {
        await axios.post('https://alex.polan.sk/control-center/cloud/files.php', {
            action: 'toggle_star_shared',
            owner: file.owner,
            drive: file.drive,
            file_path: file.file_path
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })

        const fileIndex = sharedFiles.value.findIndex(f => f.id === file.id)
        if (fileIndex !== -1 && sharedFiles.value[fileIndex]) {
            sharedFiles.value[fileIndex].starred = !sharedFiles.value[fileIndex].starred
        }
    } catch (error) {
        console.error('Error toggling star:', error)
    }
}

const openFilePreview = (file: SharedFile) => {
    selectedFile.value = file
    showPreview.value = true
}

const closePreview = () => {
    showPreview.value = false
    selectedFile.value = null
}

const setSortBy = (sort: 'name' | 'owner' | 'date' | 'drive') => {
    sortBy.value = sort
    showSortMenu.value = false
}

const getFileName = (filePath: string) => {
    const parts = filePath.split('/')
    return parts[parts.length - 1] || filePath
}

const formatDate = (dateString: string) => {
    const date = new Date(dateString)
    const now = new Date()
    const diffTime = Math.abs(now.getTime() - date.getTime())
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))

    if (diffDays === 0) {
        return 'Today'
    } else if (diffDays === 1) {
        return 'Yesterday'
    } else if (diffDays < 7) {
        return `${diffDays} days ago`
    } else {
        return date.toLocaleDateString()
    }
}

onMounted(() => {
    loadSharedFiles()

    document.addEventListener('click', (e) => {
        const target = e.target as HTMLElement
        if (!target.closest('.sort-menu-container')) {
            showSortMenu.value = false
        }
    })
})
</script>
