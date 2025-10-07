<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Page Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Services</h1>
                        <p class="mt-1 text-sm text-gray-500">Manage your cloud services and applications</p>
                    </div>
                    <div class="flex space-x-3">
                        <button
                            class="bg-white border border-gray-300 rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Filter
                        </button>
                        <button
                            class="bg-primary-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-primary-700 transition-colors">
                            Deploy Service
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <ServiceCard name="Web Server" type="nginx" status="running" version="1.21.6" cpu="12%"
                    memory="256 MB" />
                <ServiceCard name="Database" type="postgresql" status="running" version="14.2" cpu="8%"
                    memory="512 MB" />
                <ServiceCard name="Cache Server" type="redis" status="warning" version="6.2.7" cpu="3%"
                    memory="128 MB" />
                <ServiceCard name="Load Balancer" type="traefik" status="running" version="2.8.1" cpu="5%"
                    memory="64 MB" />
                <ServiceCard name="API Gateway" type="kong" status="running" version="2.8.1" cpu="15%"
                    memory="320 MB" />
                <ServiceCard name="File Storage" type="minio" status="stopped" version="2022.6.20" cpu="0%"
                    memory="0 MB" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
// Service Card Component
const ServiceCard = {
    props: {
        name: String,
        type: String,
        status: String,
        version: String,
        cpu: String,
        memory: String
    },
    template: `
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
          <div :class="[
            'w-3 h-3 rounded-full mr-3',
            {
              'bg-green-400': status === 'running',
              'bg-yellow-400': status === 'warning',
              'bg-red-400': status === 'stopped'
            }
          ]"></div>
          <h3 class="text-lg font-medium text-gray-900">{{ name }}</h3>
        </div>
        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ type }}</span>
      </div>
      
      <div class="space-y-2 mb-4">
        <div class="flex justify-between text-sm">
          <span class="text-gray-500">Version:</span>
          <span class="text-gray-900">{{ version }}</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-500">CPU:</span>
          <span class="text-gray-900">{{ cpu }}</span>
        </div>
        <div class="flex justify-between text-sm">
          <span class="text-gray-500">Memory:</span>
          <span class="text-gray-900">{{ memory }}</span>
        </div>
      </div>
      
      <div class="flex space-x-2">
        <button v-if="status === 'stopped'" class="flex-1 bg-green-600 text-white text-sm py-2 px-3 rounded hover:bg-green-700 transition-colors">
          Start
        </button>
        <button v-else class="flex-1 bg-red-600 text-white text-sm py-2 px-3 rounded hover:bg-red-700 transition-colors">
          Stop
        </button>
        <button class="flex-1 bg-gray-600 text-white text-sm py-2 px-3 rounded hover:bg-gray-700 transition-colors">
          Logs
        </button>
      </div>
    </div>
  `
}
</script>