<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Page Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                    <p class="mt-1 text-sm text-gray-500">Configure your cloud control center</p>
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
                                ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-600'
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
                        ]">
                            {{ tab }}
                        </button>
                    </nav>
                </div>

                <!-- Settings Content -->
                <div class="lg:col-span-3">
                    <!-- General Settings -->
                    <div v-if="activeTab === 0" class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Organization Name</label>
                                <input type="text" value="My Cloud Organization"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Default Region</label>
                                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                                    <option>us-east-1</option>
                                    <option>us-west-2</option>
                                    <option>eu-west-1</option>
                                    <option>ap-southeast-1</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Time Zone</label>
                                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                                    <option>UTC</option>
                                    <option>Europe/Berlin</option>
                                    <option>America/New_York</option>
                                    <option>Asia/Tokyo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div v-if="activeTab === 1" class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Notification Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                                    <p class="text-sm text-gray-500">Receive alerts via email</p>
                                </div>
                                <input type="checkbox" checked class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">SMS Alerts</h4>
                                    <p class="text-sm text-gray-500">Critical alerts via SMS</p>
                                </div>
                                <input type="checkbox" class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">System Updates</h4>
                                    <p class="text-sm text-gray-500">Notifications about system updates</p>
                                </div>
                                <input type="checkbox" checked class="h-4 w-4 text-primary-600 border-gray-300 rounded">
                            </div>
                        </div>
                    </div>

                    <!-- Security -->
                    <div v-if="activeTab === 2" class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Security Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Two-Factor Authentication</h4>
                                <div
                                    class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-md">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                                        <span class="text-sm text-green-800">2FA is enabled</span>
                                    </div>
                                    <button class="text-sm text-green-700 hover:text-green-900">Configure</button>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-3">API Keys</h4>
                                <div class="space-y-2">
                                    <div
                                        class="flex items-center justify-between p-3 border border-gray-200 rounded-md">
                                        <div>
                                            <span class="text-sm font-medium">Production API Key</span>
                                            <p class="text-xs text-gray-500">Last used 2 hours ago</p>
                                        </div>
                                        <button class="text-sm text-red-600 hover:text-red-800">Revoke</button>
                                    </div>
                                    <button
                                        class="w-full p-3 border-2 border-dashed border-gray-300 rounded-md text-sm text-gray-600 hover:border-gray-400">
                                        + Generate New API Key
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Advanced -->
                    <div v-if="activeTab === 3" class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Advanced Settings</h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Log Retention Period</label>
                                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                                    <option>7 days</option>
                                    <option>30 days</option>
                                    <option>90 days</option>
                                    <option>1 year</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Backup Schedule</label>
                                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                                    <option>Daily</option>
                                    <option>Weekly</option>
                                    <option>Monthly</option>
                                    <option>Custom</option>
                                </select>
                            </div>
                            <div class="pt-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-red-600 mb-3">Danger Zone</h4>
                                <button
                                    class="px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 transition-colors">
                                    Reset All Settings
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="mt-6">
                        <button
                            class="bg-primary-600 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-primary-700 transition-colors">
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