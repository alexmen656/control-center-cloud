<template>
    <div class="min-h-screen bg-gray-50">
        <div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Shared with Me</h1>
                        <p class="mt-1 text-sm text-gray-500">Files and folders shared by others</p>
                    </div>
                    <button
                        class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Sort by
                    </button>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <div class="bg-white rounded-lg border border-gray-200">
                <div class="p-3 space-y-2">
                    <div v-for="i in 8" :key="i"
                        class="flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">Shared_Document_{{ i }}.xlsx</p>
                            <p class="text-xs text-gray-500">Shared by user@example.com • 1.2 MB</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Can Edit</span>
                            <button class="text-gray-400 hover:text-gray-600">
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
    </div>
</template>

<script setup lang="ts">
// Shared files view
</script>
