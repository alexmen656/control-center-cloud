<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Page Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Settings</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Configure your cloud control center</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Settings Navigation -->
                <div class="lg:col-span-1">
                    <nav class="space-y-1">
                        <button v-for="(tab, index) in tabs" :key="index" @click="activeTab = index" :class="[
                            'w-full text-left px-3 py-2 rounded-md text-sm font-medium transition-colors',
                            activeTab === index
                                ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 border-l-4 border-primary-600 dark:border-primary-400'
                                : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-200'
                        ]">
                            {{ tab }}
                        </button>
                    </nav>
                </div>

                <!-- Settings Content -->
                <div class="lg:col-span-3">
                    <!-- General Settings -->
                    <div v-if="activeTab === 0"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">General Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Organization
                                    Name</label>
                                <input type="text" value="My Cloud Organization"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Default
                                    Region</label>
                                <select
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option>us-east-1</option>
                                    <option>us-west-2</option>
                                    <option>eu-west-1</option>
                                    <option>ap-southeast-1</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Time
                                    Zone</label>
                                <select
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option>UTC</option>
                                    <option>Europe/Berlin</option>
                                    <option>America/New_York</option>
                                    <option>Asia/Tokyo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div v-if="activeTab === 1"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Notification Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Email Notifications
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Receive alerts via email</p>
                                </div>
                                <input type="checkbox" checked
                                    class="h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 focus:ring-primary-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">SMS Alerts</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Critical alerts via SMS</p>
                                </div>
                                <input type="checkbox"
                                    class="h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 focus:ring-primary-500">
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">System Updates</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Notifications about system
                                        updates</p>
                                </div>
                                <input type="checkbox" checked
                                    class="h-4 w-4 text-primary-600 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 focus:ring-primary-500">
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div v-if="activeTab === 2"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Security Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Two-Factor
                                    Authentication</h4>
                                <div
                                    class="flex items-center justify-between p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-green-400 dark:bg-green-500 rounded-full mr-3"></div>
                                        <span class="text-sm text-green-800 dark:text-green-300">2FA is enabled</span>
                                    </div>
                                    <button
                                        class="text-sm text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100">Configure</button>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">API Keys</h4>
                                <div class="space-y-2">
                                    <div
                                        class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-md">
                                        <div>
                                            <span
                                                class="text-sm font-medium text-gray-900 dark:text-gray-100">Production
                                                API Key</span>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Last used 2 hours ago
                                            </p>
                                        </div>
                                        <button
                                            class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">Revoke</button>
                                    </div>
                                    <button
                                        class="w-full p-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md text-sm text-gray-600 dark:text-gray-400 hover:border-gray-400 dark:hover:border-gray-500">
                                        + Generate New API Key
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced -->
                    <div v-if="activeTab === 3"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Advanced Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Log
                                    Retention Period</label>
                                <select
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option>7 days</option>
                                    <option>30 days</option>
                                    <option>90 days</option>
                                    <option>1 year</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Backup
                                    Schedule</label>
                                <select
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    <option>Daily</option>
                                    <option>Weekly</option>
                                    <option>Monthly</option>
                                    <option>Custom</option>
                                </select>
                            </div>
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <h4 class="text-sm font-medium text-red-600 dark:text-red-400 mb-3">Danger Zone</h4>
                                <button
                                    class="px-4 py-2 bg-red-600 dark:bg-red-700 text-white text-sm rounded-md hover:bg-red-700 dark:hover:bg-red-800 transition-colors">
                                    Reset All Settings
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-6">
                        <button
                            class="bg-primary-600 dark:bg-primary-700 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-primary-700 dark:hover:bg-primary-800 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const activeTab = ref(0)
const tabs = ['General', 'Notifications', 'Security', 'Advanced']
</script>