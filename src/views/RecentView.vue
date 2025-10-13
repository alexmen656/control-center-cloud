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
                    <div v-for="(file, index) in filteredFiles" :key="file.path + file.drive" @click="openFile(file)"
                        class="flex items-center p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg cursor-pointer transition-colors group">
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
                        <div class="relative" @click.stop :data-dropdown="'actions-' + index">
                            <button @click="toggleDropdown(index)"
                                class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors opacity-0 group-hover:opacity-100">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                </svg>
                            </button>
                            <div v-if="openDropdownIndex === index"
                                class="absolute right-0 top-full mt-1 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50">
                                <button @click="downloadFile(file)"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-3 transition-colors">
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">Download</span>
                                </button>
                                <button @click="toggleStar(file)"
                                    class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-3 transition-colors">
                                    <svg class="w-4 h-4"
                                        :class="file.starred ? 'text-yellow-500' : 'text-gray-600 dark:text-gray-400'"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">{{ file.starred ? 'Unstar' :
                                        'Star' }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <FilePreviewModal :show="showPreview" :file-name="selectedFile?.name || ''"
            :file-path="selectedFile?.path || ''" :file-size="selectedFile?.size.toString() || ''"
            :drive="selectedFile?.drive" :owner="selectedFile?.owner" @close="closePreview" />
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { filesApi } from '@/services/api'
import formatUnit from '@/utils/formatUnit'
import axios from 'axios'
import { useRouter } from 'vue-router'
import FilePreviewModal from '@/components/FilePreviewModal.vue'

const router = useRouter()
const token = localStorage.getItem('auth_token') || ''
const showPreview = ref(false)
const selectedFile = ref<RecentFile | null>(null)

interface RecentFile {
    name: string
    path: string
    size: number
    type: string
    drive: string
    accessed_at: string
    modified: string
    starred?: boolean
    owner?: string
}

const recentFiles = ref<RecentFile[]>([])
const loading = ref(true)
const filterPeriod = ref<'today' | 'week' | 'month'>('today')
const openDropdownIndex = ref<number | null>(null)

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

const toggleDropdown = (index: number) => {
    if (openDropdownIndex.value === index) {
        openDropdownIndex.value = null
    } else {
        openDropdownIndex.value = index
    }
}

const openFile = (file: RecentFile) => {
    if (file.type === 'folder') {
        router.push({
            path: '/dashboard',
            query: { drive: file.drive, folder: file.path }
        })
    } else {
        selectedFile.value = file
        showPreview.value = true
    }
}

const closePreview = () => {
    showPreview.value = false
    selectedFile.value = null
}

const downloadFile = async (file: RecentFile) => {
    try {
        const response = await axios.get('https://alex.polan.sk/control-center/cloud/files.php', {
            params: {
                action: 'get_file_contents',
                drive: file.drive,
                file: file.path,
                owner: file.owner || localStorage.getItem('username')
            },
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })

        const { content, mime_type, filename } = response.data
        const byteCharacters = atob(content)
        const byteNumbers = new Array(byteCharacters.length)
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i)
        }
        const byteArray = new Uint8Array(byteNumbers)
        const blob = new Blob([byteArray], { type: mime_type })

        const url = window.URL.createObjectURL(blob)
        const link = document.createElement('a')
        link.href = url
        link.download = filename
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
        window.URL.revokeObjectURL(url)

        openDropdownIndex.value = null
    } catch (error) {
        console.error('Error downloading file:', error)
        alert('Failed to download file')
    }
}

const toggleStar = async (file: RecentFile) => {
    try {
        await axios.post('https://alex.polan.sk/control-center/cloud/files.php', {
            action: 'toggle_star',
            drive: file.drive,
            file_path: file.path
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })

        file.starred = !file.starred
        openDropdownIndex.value = null
    } catch (error) {
        console.error('Error toggling star:', error)
        alert('Failed to update star status')
    }
}

onMounted(() => {
    loadRecentFiles()

    const handleClickOutside = (e: MouseEvent) => {
        const target = e.target as HTMLElement
        if (!target.closest('[data-dropdown^="actions-"]')) {
            openDropdownIndex.value = null
        }
    }

    document.addEventListener('click', handleClickOutside)
})
</script>
