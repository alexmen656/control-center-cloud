<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show" class="fixed inset-0 z-50 overflow-hidden" @click.self="closeModal">
                <div class="absolute inset-0 bg-black bg-opacity-75 transition-opacity"></div>
                <div class="relative h-full flex flex-col">
                    <div class="bg-gray-900 text-white px-6 py-4 flex items-center justify-between relative z-10">
                        <div class="flex items-center space-x-4 flex-1 min-w-0">
                            <component :is="getFileIcon(fileType)" :color="'#fff'" class="flex-shrink-0" />
                            <div class="min-w-0 flex-1">
                                <h2 class="text-lg font-medium truncate">{{ fileName }}</h2>
                                <p class="text-sm text-gray-400">{{ fileSize }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button @click="downloadFile" class="p-2 hover:bg-gray-800 rounded-full transition-colors"
                                title="Download">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button @click="closeModal" class="p-2 hover:bg-gray-800 rounded-full transition-colors"
                                title="Close">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 overflow-auto bg-gray-100 flex items-center justify-center p-8">
                        <div v-if="loading" class="text-center">
                            <div
                                class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-primary-600">
                            </div>
                            <p class="mt-4 text-gray-600">Loading preview...</p>
                        </div>
                        <div v-else-if="error" class="text-center">
                            <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-red-600 font-medium">{{ error }}</p>
                        </div>
                        <div v-else class="w-full h-full flex items-center justify-center">
                            <div v-if="isImage" class="max-w-full max-h-full">
                                <img :src="contentUrl" :alt="fileName"
                                    class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                            </div>
                            <iframe v-else-if="isPdf" :src="contentUrl"
                                class="w-full h-full rounded-lg shadow-2xl bg-white"></iframe>
                            <video v-else-if="isVideo" controls class="max-w-full max-h-full rounded-lg shadow-2xl">
                                <source :src="contentUrl" :type="getVideoMimeType()">
                                Your browser does not support the video tag.
                            </video>
                            <div v-else-if="isAudio" class="bg-white rounded-lg shadow-2xl p-8 max-w-2xl w-full">
                                <div class="flex items-center justify-center mb-6">
                                    <svg class="w-24 h-24 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" />
                                    </svg>
                                </div>
                                <audio controls class="w-full">
                                    <source :src="contentUrl" :type="getAudioMimeType()">
                                    Your browser does not support the audio tag.
                                </audio>
                            </div>
                            <div v-else-if="isText"
                                class="bg-white rounded-lg shadow-2xl w-full max-w-4xl h-full max-h-[80vh] overflow-auto">
                                <pre
                                    class="p-6 text-sm font-mono whitespace-pre-wrap break-words">{{ textContent }}</pre>
                            </div>
                            <div v-else-if="isCode"
                                class="bg-gray-900 rounded-lg shadow-2xl w-full max-w-4xl h-full max-h-[80vh] overflow-auto">
                                <div class="bg-gray-800 px-4 py-2 border-b border-gray-700">
                                    <span class="text-gray-300 text-sm font-medium">{{ fileName }}</span>
                                </div>
                                <pre
                                    class="p-6 text-sm font-mono text-green-400 whitespace-pre-wrap break-words">{{ textContent }}</pre>
                            </div>
                            <div v-else-if="isJson"
                                class="bg-white rounded-lg shadow-2xl w-full max-w-4xl h-full max-h-[80vh] overflow-auto">
                                <div class="bg-gray-100 px-4 py-2 border-b border-gray-200">
                                    <span class="text-gray-700 text-sm font-medium">JSON Preview</span>
                                </div>
                                <pre class="p-6 text-sm font-mono">{{ formattedJson }}</pre>
                            </div>
                            <div v-else-if="isMarkdown"
                                class="bg-white rounded-lg shadow-2xl w-full max-w-4xl h-full max-h-[80vh] overflow-auto p-8 prose prose-sm max-w-none"
                                v-html="renderedMarkdown">
                            </div>
                            <div v-else class="text-center bg-white rounded-lg shadow-2xl p-12 max-w-md">
                                <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Preview not available</h3>
                                <p class="text-gray-600 mb-6">This file type ({{ fileExtension }}) cannot be previewed.
                                </p>
                                <button @click="downloadFile"
                                    class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                                    Download File
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup lang="ts">
import { ref, computed, watch, defineComponent, h } from 'vue'
import { filesApi } from '../services/api'

interface Props {
    show: boolean
    fileName: string
    filePath: string
    fileSize: string
    drive?: string
    owner?: string
}

const props = withDefaults(defineProps<Props>(), {
    drive: 'default',
    owner: ''
})

const emit = defineEmits<{
    close: []
}>()

const loading = ref(false)
const error = ref<string | null>(null)
const textContent = ref('')
const contentUrl = ref('')

const fileExtension = computed(() => {
    const ext = props.fileName.split('.').pop()?.toLowerCase()
    return ext || ''
})

const fileType = computed(() => {
    const ext = fileExtension.value

    if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'].includes(ext)) return 'image'
    if (['pdf'].includes(ext)) return 'pdf'
    if (['mp4', 'webm', 'ogg', 'mov', 'avi'].includes(ext)) return 'video'
    if (['mp3', 'wav', 'ogg', 'flac', 'm4a'].includes(ext)) return 'audio'
    if (['txt', 'log', 'md', 'readme'].includes(ext)) return 'text'
    if (['js', 'ts', 'jsx', 'tsx', 'vue', 'py', 'java', 'cpp', 'c', 'h', 'css', 'scss', 'html', 'php', 'rb', 'go', 'rs', 'swift'].includes(ext)) return 'code'
    if (['json'].includes(ext)) return 'json'
    if (['md', 'markdown'].includes(ext)) return 'markdown'
    if (['zip', 'rar', '7z', 'tar', 'gz'].includes(ext)) return 'archive'
    if (['doc', 'docx'].includes(ext)) return 'doc'
    if (['xls', 'xlsx'].includes(ext)) return 'sheet'

    return 'unknown'
})

const isImage = computed(() => fileType.value === 'image')
const isPdf = computed(() => fileType.value === 'pdf')
const isVideo = computed(() => fileType.value === 'video')
const isAudio = computed(() => fileType.value === 'audio')
const isText = computed(() => fileType.value === 'text')
const isCode = computed(() => fileType.value === 'code')
const isJson = computed(() => fileType.value === 'json')
const isMarkdown = computed(() => fileType.value === 'markdown')

const formattedJson = computed(() => {
    try {
        return JSON.stringify(JSON.parse(textContent.value), null, 2)
    } catch {
        return textContent.value
    }
})

const renderedMarkdown = computed(() => {
    return textContent.value
        .replace(/^### (.*$)/gim, '<h3>$1</h3>')
        .replace(/^## (.*$)/gim, '<h2>$1</h2>')
        .replace(/^# (.*$)/gim, '<h1>$1</h1>')
        .replace(/\*\*(.*)\*\*/gim, '<strong>$1</strong>')
        .replace(/\*(.*)\*/gim, '<em>$1</em>')
        .replace(/\n/gim, '<br>')
})

const getVideoMimeType = () => {
    const ext = fileExtension.value
    const mimeTypes: Record<string, string> = {
        'mp4': 'video/mp4',
        'webm': 'video/webm',
        'ogg': 'video/ogg',
        'mov': 'video/quicktime',
        'avi': 'video/x-msvideo'
    }
    return mimeTypes[ext] || 'video/mp4'
}

const getAudioMimeType = () => {
    const ext = fileExtension.value
    const mimeTypes: Record<string, string> = {
        'mp3': 'audio/mpeg',
        'wav': 'audio/wav',
        'ogg': 'audio/ogg',
        'flac': 'audio/flac',
        'm4a': 'audio/mp4'
    }
    return mimeTypes[ext] || 'audio/mpeg'
}

const loadFileContent = async () => {
    if (!props.show || !props.filePath) return

    loading.value = true
    error.value = null
    textContent.value = ''
    contentUrl.value = ''

    try {
        const response = await filesApi.getFileContents(props.drive, props.filePath, props.owner)

        if (response.error) {
            error.value = response.error
            return
        }

        if (isImage.value || isPdf.value || isVideo.value || isAudio.value) {
            contentUrl.value = `data:${response.mime_type || 'application/octet-stream'};base64,${response.content}`
        } else if (isText.value || isCode.value || isJson.value || isMarkdown.value) {
            textContent.value = atob(response.content)
        } else {
            error.value = 'Unsupported file type'
        }
    } catch (err: any) {
        error.value = err.response?.data?.message || 'Failed to load file content'
    } finally {
        loading.value = false
    }
}

const closeModal = () => {
    emit('close')
}

const downloadFile = () => {
    const link = document.createElement('a')
    link.href = contentUrl.value || `data:application/octet-stream;base64,${textContent.value}`
    link.download = props.fileName
    link.click()
}

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

const getFileIcon = (type: string) => {
    switch (type) {
        case 'folder': return FolderIcon
        case 'pdf': return PDFIcon
        case 'image': return ImageIcon
        default: return PDFIcon
    }
}

watch(() => props.show, (newVal) => {
    if (newVal) {
        loadFileContent()
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = ''
    }
})
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.prose h1 {
    font-size: 1.875rem;
    font-weight: 700;
    margin-bottom: 1rem;
    margin-top: 1.5rem;
}

.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    margin-top: 1.25rem;
}

.prose h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    margin-top: 1rem;
}

.prose p {
    margin-bottom: 1rem;
}

.prose strong {
    font-weight: 600;
}

.prose em {
    font-style: italic;
}
</style>
