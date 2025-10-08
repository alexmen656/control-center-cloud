<template>
    <div class="min-h-screen bg-white">
        <div class="border-b border-gray-200 bg-white px-6 py-3 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-semibold text-gray-900">Starred</h1>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center bg-gray-100 rounded-lg p-0.5">
                        <button @click="viewMode = 'list'"
                            :class="viewMode === 'list' ? 'bg-white shadow-sm' : 'hover:bg-gray-200'"
                            class="p-1.5 rounded transition-all">
                            <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button @click="viewMode = 'grid'"
                            :class="viewMode === 'grid' ? 'bg-white shadow-sm' : 'hover:bg-gray-200'"
                            class="p-1.5 rounded transition-all">
                            <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM13 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-4">
            <div v-if="starredFiles.length === 0" class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <p class="text-gray-600 text-lg">No starred files yet</p>
                <p class="text-gray-500 text-sm mt-2">Star files to easily find them later</p>
            </div>
            <div v-else>
                <div v-if="viewMode === 'list'" class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 pr-4 text-xs font-medium text-gray-600 w-8">
                                    <input type="checkbox" class="rounded border-gray-300">
                                </th>
                                <th class="text-left py-3 pr-4 text-xs font-medium text-gray-600">Name</th>
                                <th class="text-left py-3 px-4 text-xs font-medium text-gray-600">Owner</th>
                                <th class="text-left py-3 px-4 text-xs font-medium text-gray-600">Date modified</th>
                                <th class="text-left py-3 px-4 text-xs font-medium text-gray-600">File size</th>
                                <th class="text-right py-3 pl-4 text-xs font-medium text-gray-600 w-16"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="file in starredFiles" :key="file.id" @click="openFilePreview(file)"
                                class="hover:bg-gray-50 border-b border-gray-100 cursor-pointer group">
                                <td class="py-3 pr-4" @click.stop>
                                    <input type="checkbox" class="rounded border-gray-300">
                                </td>
                                <td class="py-3 pr-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <component :is="getFileIcon(file.type)" :color="getFileColor(file.type)" />
                                        </div>
                                        <span class="text-sm text-gray-900 font-medium truncate">{{ file.name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center text-white text-xs">
                                            {{ file.owner.charAt(0).toUpperCase() }}
                                        </div>
                                        <span class="text-sm text-gray-600">{{ file.owner }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600">{{ file.modified }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600">{{ file.size }}</span>
                                </td>
                                <td class="py-3 pl-4 text-right">
                                    <div
                                        class="flex items-center justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click.stop="downloadFile(file)" class="p-1.5 hover:bg-gray-200 rounded-full"
                                            title="Download">
                                            <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button @click.stop="toggleStar(file)"
                                            class="p-1.5 hover:bg-gray-200 rounded-full" title="Unstar">
                                            <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    <div v-for="file in starredFiles" :key="file.id" @click="openFilePreview(file)"
                        class="group border border-gray-200 rounded-lg hover:shadow-lg hover:border-primary-300 transition-all cursor-pointer p-3">
                        <div
                            class="aspect-square bg-gray-100 rounded-lg mb-3 flex items-center justify-center relative overflow-hidden">
                            <component :is="getFileIcon(file.type)" :color="getFileColor(file.type)" class="w-16 h-16" />
                            <div class="absolute top-2 right-2">
                                <button @click.stop="toggleStar(file)" class="p-1 hover:bg-gray-200 rounded">
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="text-sm font-medium text-gray-900 truncate mb-1">{{ file.name }}</div>
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ file.modified }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <FilePreviewModal :show="showPreview" :fileName="selectedFile?.name || ''"
            :filePath="selectedFile?.path || selectedFile?.name || ''" :fileSize="selectedFile?.size || ''"
            @close="closePreview" />
    </div>
</template>

<script setup lang="ts">
import { ref, defineComponent, h, onMounted } from 'vue'
import axios from 'axios'
import FilePreviewModal from '../components/FilePreviewModal.vue'

const viewMode = ref<'list' | 'grid'>('list')
const showPreview = ref(false)
const selectedFile = ref<File | null>(null)
const starredFiles = ref<File[]>([])

interface File {
    id: number
    name: string
    path?: string
    type: 'folder' | 'pdf' | 'image' | 'video' | 'sheet' | 'doc' | 'zip' | 'form'
    owner: string
    modified: string
    size: string
    drive: string
}

const token = localStorage.getItem('auth_token') || ''

onMounted(() => {
    loadStarredFiles()
})

const loadStarredFiles = async () => {
    try {
        const response = await axios.get('https://alex.polan.sk/control-center/cloud/files.php?action=get_starred', {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        starredFiles.value = response.data
    } catch (error) {
        console.error('Error fetching starred files:', error)
    }
}

const toggleStar = async (file: File) => {
    try {
        await axios.post('https://alex.polan.sk/control-center/cloud/files.php', {
            action: 'toggle_star',
            file_id: file.id,
            drive: file.drive,
            file_path: file.path || file.name
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        loadStarredFiles()
    } catch (error) {
        console.error('Error toggling star:', error)
    }
}

const downloadFile = async (file: File) => {
    try {
        const response = await axios.get(
            `https://alex.polan.sk/control-center/cloud/files.php?action=get_file_contents&drive=${file.drive}&file=${encodeURIComponent(file.path || file.name)}`,
            {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            }
        )

        const blob = await fetch(`data:${response.data.mime_type};base64,${response.data.content}`).then(res => res.blob())
        const url = window.URL.createObjectURL(blob)
        const a = document.createElement('a')
        a.href = url
        a.download = file.name
        document.body.appendChild(a)
        a.click()
        window.URL.revokeObjectURL(url)
        document.body.removeChild(a)
    } catch (error) {
        console.error('Error downloading file:', error)
    }
}

const openFilePreview = (file: File) => {
    if (file.type === 'folder') {
        return
    }
    selectedFile.value = file
    showPreview.value = true
}

const closePreview = () => {
    showPreview.value = false
    selectedFile.value = null
}

// Icon components
const FolderIcon = defineComponent({
    props: ['color'],
    setup(props) {
        return () => h('svg', {
            class: 'w-10 h-10',
            fill: props.color || '#5F6368',
            viewBox: '0 0 20 20'
        }, [
            h('path', {
                d: 'M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z'
            })
        ])
    }
})

const PDFIcon = defineComponent({
    props: ['color'],
    setup(props) {
        return () => h('svg', {
            class: 'w-10 h-10',
            fill: props.color || '#EA4335',
            viewBox: '0 0 20 20'
        }, [
            h('path', {
                fillRule: 'evenodd',
                d: 'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z',
                clipRule: 'evenodd'
            })
        ])
    }
})

const ImageIcon = defineComponent({
    props: ['color'],
    setup(props) {
        return () => h('svg', {
            class: 'w-10 h-10',
            fill: props.color || '#EA4335',
            viewBox: '0 0 20 20'
        }, [
            h('path', {
                fillRule: 'evenodd',
                d: 'M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z',
                clipRule: 'evenodd'
            })
        ])
    }
})

const SheetIcon = defineComponent({
    props: ['color'],
    setup(props) {
        return () => h('svg', {
            class: 'w-10 h-10',
            fill: props.color || '#0F9D58',
            viewBox: '0 0 20 20'
        }, [
            h('path', {
                fillRule: 'evenodd',
                d: 'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z',
                clipRule: 'evenodd'
            })
        ])
    }
})

const DocIcon = defineComponent({
    props: ['color'],
    setup(props) {
        return () => h('svg', {
            class: 'w-10 h-10',
            fill: props.color || '#4285F4',
            viewBox: '0 0 20 20'
        }, [
            h('path', {
                fillRule: 'evenodd',
                d: 'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z',
                clipRule: 'evenodd'
            })
        ])
    }
})

const ZipIcon = defineComponent({
    props: ['color'],
    setup(props) {
        return () => h('svg', {
            class: 'w-10 h-10',
            fill: props.color || '#5F6368',
            viewBox: '0 0 20 20'
        }, [
            h('path', {
                fillRule: 'evenodd',
                d: 'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z',
                clipRule: 'evenodd'
            })
        ])
    }
})

const FormIcon = defineComponent({
    props: ['color'],
    setup(props) {
        return () => h('svg', {
            class: 'w-10 h-10',
            fill: props.color || '#7B1FA2',
            viewBox: '0 0 20 20'
        }, [
            h('path', {
                fillRule: 'evenodd',
                d: 'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z',
                clipRule: 'evenodd'
            })
        ])
    }
})

const getFileIcon = (type: string) => {
    switch (type) {
        case 'folder': return FolderIcon
        case 'pdf': return PDFIcon
        case 'image': return ImageIcon
        case 'sheet': return SheetIcon
        case 'doc': return DocIcon
        case 'zip': return ZipIcon
        case 'form': return FormIcon
        default: return PDFIcon
    }
}

const getFileColor = (type: string) => {
    switch (type) {
        case 'folder': return '#5F6368'
        case 'pdf': return '#EA4335'
        case 'image': return '#EA4335'
        case 'sheet': return '#0F9D58'
        case 'doc': return '#4285F4'
        case 'zip': return '#5F6368'
        case 'form': return '#7B1FA2'
        default: return '#5F6368'
    }
}
</script>

<style scoped>
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
