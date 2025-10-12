<template>
    <div class="min-h-screen bg-white dark:bg-gray-900">
        <div
            class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-6 py-3 sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Trash</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Files in trash will be automatically deleted
                        after 30 days</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button v-if="trashedFiles.length > 0" @click="emptyTrash"
                        class="px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg border border-red-300 dark:border-red-700 transition-colors">
                        Empty trash
                    </button>
                    <div class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-lg p-0.5">
                        <button @click="viewMode = 'list'"
                            :class="viewMode === 'list' ? 'bg-white dark:bg-gray-700 shadow-sm' : 'hover:bg-gray-200 dark:hover:bg-gray-700'"
                            class="p-1.5 rounded transition-all">
                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button @click="viewMode = 'grid'"
                            :class="viewMode === 'grid' ? 'bg-white dark:bg-gray-700 shadow-sm' : 'hover:bg-gray-200 dark:hover:bg-gray-700'"
                            class="p-1.5 rounded transition-all">
                            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM13 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-4">
            <div v-if="trashedFiles.length === 0" class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Trash is empty</p>
                <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">Items moved to trash will appear here</p>
            </div>
            <div v-else>
                <div v-if="viewMode === 'list'" class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th
                                    class="text-left py-3 pr-4 text-xs font-medium text-gray-600 dark:text-gray-400 w-8">
                                    <input type="checkbox"
                                        class="rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700">
                                </th>
                                <th class="text-left py-3 pr-4 text-xs font-medium text-gray-600 dark:text-gray-400">
                                    Name</th>
                                <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 dark:text-gray-400">
                                    Original location</th>
                                <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 dark:text-gray-400">
                                    Deleted</th>
                                <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 dark:text-gray-400">
                                    File size</th>
                                <th
                                    class="text-right py-3 pl-4 text-xs font-medium text-gray-600 dark:text-gray-400 w-16">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="file in trashedFiles" :key="file.id"
                                class="hover:bg-gray-50 dark:hover:bg-gray-800 border-b border-gray-100 dark:border-gray-700 group">
                                <td class="py-3 pr-4" @click.stop>
                                    <input type="checkbox"
                                        class="rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700">
                                </td>
                                <td class="py-3 pr-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <component :is="getFileIcon(file.type)" :color="getFileColor(file.type)" />
                                        </div>
                                        <span class="text-sm text-gray-900 dark:text-gray-100 font-medium truncate">{{
                                            file.name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ file.drive }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ file.deleted }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ file.size }}</span>
                                </td>
                                <td class="py-3 pl-4 text-right">
                                    <div
                                        class="flex items-center justify-end space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click.stop="restoreFile(file)"
                                            class="p-1.5 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full"
                                            title="Restore">
                                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button @click.stop="deleteFilePermanently(file)"
                                            class="p-1.5 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-full"
                                            title="Delete forever">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    <div v-for="file in trashedFiles" :key="file.id"
                        class="group border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-lg hover:border-primary-300 dark:hover:border-primary-600 transition-all p-3">
                        <div
                            class="aspect-square bg-gray-100 dark:bg-gray-800 rounded-lg mb-3 flex items-center justify-center relative overflow-hidden">
                            <component :is="getFileIcon(file.type)" :color="getFileColor(file.type)"
                                class="w-16 h-16" />
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                @click.stop>
                                <input type="checkbox"
                                    class="rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700">
                            </div>
                        </div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate mb-1">{{ file.name }}
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <span>{{ file.deleted }}</span>
                            <div class="flex space-x-1">
                                <button @click.stop="restoreFile(file)"
                                    class="p-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded opacity-0 group-hover:opacity-100"
                                    title="Restore">
                                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button @click.stop="deleteFilePermanently(file)"
                                    class="p-1 hover:bg-red-100 dark:hover:bg-red-900/20 rounded opacity-0 group-hover:opacity-100"
                                    title="Delete forever">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, defineComponent, h, onMounted } from 'vue'
import axios from 'axios'

const viewMode = ref<'list' | 'grid'>('list')
const trashedFiles = ref<File[]>([])

interface File {
    id: number
    name: string
    path?: string
    type: 'folder' | 'pdf' | 'image' | 'video' | 'sheet' | 'doc' | 'zip' | 'form'
    drive: string
    deleted: string
    size: string
}

const token = localStorage.getItem('auth_token') || ''

onMounted(() => {
    loadTrashedFiles()
})

const loadTrashedFiles = async () => {
    try {
        const response = await axios.get('https://alex.polan.sk/control-center/cloud/files.php?action=get_trash', {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        trashedFiles.value = response.data
    } catch (error) {
        console.error('Error fetching trashed files:', error)
    }
}

const restoreFile = async (file: File) => {
    if (!confirm(`Restore "${file.name}"?`)) return

    try {
        await axios.post('https://alex.polan.sk/control-center/cloud/files.php', {
            action: 'restore_file',
            file_id: file.id,
            drive: file.drive,
            file_path: file.path || file.name
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        loadTrashedFiles()
    } catch (error) {
        console.error('Error restoring file:', error)
        alert('Failed to restore file')
    }
}

const deleteFilePermanently = async (file: File) => {
    if (!confirm(`Permanently delete "${file.name}"? This cannot be undone.`)) return

    try {
        await axios.post('https://alex.polan.sk/control-center/cloud/files.php', {
            action: 'delete_permanently',
            file_id: file.id,
            drive: file.drive,
            file_path: file.path || file.name
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        loadTrashedFiles()
    } catch (error) {
        console.error('Error deleting file:', error)
        alert('Failed to delete file')
    }
}

const emptyTrash = async () => {
    if (!confirm('Empty trash? All items will be permanently deleted. This cannot be undone.')) return

    try {
        await axios.post('https://alex.polan.sk/control-center/cloud/files.php', {
            action: 'empty_trash'
        }, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        loadTrashedFiles()
    } catch (error) {
        console.error('Error emptying trash:', error)
        alert('Failed to empty trash')
    }
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
