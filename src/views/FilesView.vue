<template>
    <div class="min-h-screen bg-white">
        <div class="border-b border-gray-200 bg-white px-6 py-3 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button class="flex items-center space-x-2 text-gray-700 hover:bg-gray-100 px-3 py-2 rounded-lg">
                        <span class="text-lg font-medium">My Drive</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="flex items-center space-x-2">
                        <button
                            class="flex items-center space-x-1 text-sm text-gray-700 hover:bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-300">
                            <span>Type</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="flex items-center space-x-1 text-sm text-gray-700 hover:bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-300">
                            <span>People</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="flex items-center space-x-1 text-sm text-gray-700 hover:bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-300">
                            <span>Modified</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="flex items-center space-x-1 text-sm text-gray-700 hover:bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-300">
                            <span>Source</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
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
                    <button class="p-2 hover:bg-gray-100 rounded-full">
                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="px-6 py-4">
            <div v-if="viewMode === 'list'" class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 pr-4 text-xs font-medium text-gray-600 w-8">
                                <input type="checkbox" class="rounded border-gray-300">
                            </th>
                            <th class="text-left py-3 pr-4 text-xs font-medium text-gray-600">
                                <button class="flex items-center space-x-1 hover:text-gray-900">
                                    <span>Name</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" />
                                    </svg>
                                </button>
                            </th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600">Owner</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600">Date modified</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600">File size</th>
                            <th class="text-right py-3 pl-4 text-xs font-medium text-gray-600 w-16">
                                <button class="flex items-center space-x-1 hover:text-gray-900 ml-auto">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z" />
                                    </svg>
                                    <span>Sort</span>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="file in files" :key="file.id" @click="openFilePreview(file)"
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
                                    <button class="p-1.5 hover:bg-gray-200 rounded-full" title="Share">
                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 hover:bg-gray-200 rounded-full" title="Download">
                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 hover:bg-gray-200 rounded-full" title="Delete">
                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 hover:bg-gray-200 rounded-full" title="Star">
                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </button>
                                    <button class="p-1.5 hover:bg-gray-200 rounded-full" title="More">
                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                <div v-for="file in files" :key="file.id" @click="openFilePreview(file)"
                    class="group border border-gray-200 rounded-lg hover:shadow-lg hover:border-primary-300 transition-all cursor-pointer p-3">
                    <div
                        class="aspect-square bg-gray-100 rounded-lg mb-3 flex items-center justify-center relative overflow-hidden">
                        <component :is="getFileIcon(file.type)" :color="getFileColor(file.type)" class="w-16 h-16" />
                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                            @click.stop>
                            <input type="checkbox" class="rounded border-gray-300 bg-white">
                        </div>
                    </div>
                    <div class="text-sm font-medium text-gray-900 truncate mb-1">{{ file.name }}</div>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>{{ file.modified }}</span>
                        <button class="opacity-0 group-hover:opacity-100 p-1 hover:bg-gray-200 rounded">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                            </svg>
                        </button>
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
import { ref, defineComponent, h } from 'vue'
import axios from 'axios'
import FilePreviewModal from '../components/FilePreviewModal.vue'

const viewMode = ref<'list' | 'grid'>('list')
const showPreview = ref(false)
const selectedFile = ref<File | null>(null)

interface File {
    id: number
    name: string
    path?: string
    type: 'folder' | 'pdf' | 'image' | 'video' | 'sheet' | 'doc' | 'zip' | 'form'
    owner: string
    modified: string
    size: string
}

const files = ref<File[]>([])

const token = localStorage.getItem('auth_token') || ''

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

axios.get('https://alex.polan.sk/control-center/cloud/files.php?action=get_drive&drive=default', {
    headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
    }
}).then(response => {
    files.value = response.data
}).catch(error => {
    console.error('Error fetching files:', error)
})


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
/* Custom scrollbar */
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
