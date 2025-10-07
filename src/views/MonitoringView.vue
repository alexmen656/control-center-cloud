<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Page Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Monitoring</h1>
                        <p class="mt-1 text-sm text-gray-500">Real-time system monitoring and analytics</p>
                    </div>
                    <div class="flex space-x-3">
                        <select class="border border-gray-300 rounded-md px-3 py-2 text-sm bg-white">
                            <option>Last 1 hour</option>
                            <option>Last 6 hours</option>
                            <option>Last 24 hours</option>
                            <option>Last 7 days</option>
                        </select>
                        <button
                            class="bg-primary-600 text-white rounded-md px-4 py-2 text-sm font-medium hover:bg-primary-700 transition-colors">
                            Create Alert
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Metrics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <MetricCard title="CPU Usage" value="68.5%" status="normal" change="+2.1%" />
                <MetricCard title="Memory Usage" value="45.2%" status="normal" change="-1.3%" />
                <MetricCard title="Disk I/O" value="125 MB/s" status="warning" change="+15.7%" />
                <MetricCard title="Network" value="2.3 GB/s" status="normal" change="+0.8%" />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- CPU Chart -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">CPU Usage Over Time</h3>
                    <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">Chart Placeholder</span>
                    </div>
                </div>

                <!-- Memory Chart -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Memory Usage Over Time</h3>
                    <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                        <span class="text-gray-500">Chart Placeholder</span>
                    </div>
                </div>
            </div>

            <!-- Alerts and Logs -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Active Alerts -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Active Alerts</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <AlertItem severity="warning" message="High memory usage on web-server-01"
                                time="5 minutes ago" />
                            <AlertItem severity="info" message="Scheduled backup completed successfully"
                                time="1 hour ago" />
                            <AlertItem severity="error" message="Service timeout on cache-server-02"
                                time="2 hours ago" />
                        </div>
                    </div>
                </div>

                <!-- System Logs -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">System Logs</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-2 text-sm font-mono">
                            <div class="text-gray-600">
                                <span class="text-gray-400">[14:23:15]</span> INFO: Service started successfully
                            </div>
                            <div class="text-gray-600">
                                <span class="text-gray-400">[14:22:48]</span> WARN: Memory usage above 80%
                            </div>
                            <div class="text-gray-600">
                                <span class="text-gray-400">[14:20:12]</span> INFO: User authentication successful
                            </div>
                            <div class="text-gray-600">
                                <span class="text-gray-400">[14:18:30]</span> ERROR: Connection timeout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
// Metric Card Component
const MetricCard = {
    props: {
        title: String,
        value: String,
        status: String,
        change: String
    },
    template: `
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-sm font-medium text-gray-600">{{ title }}</h4>
        <div :class="[
          'w-3 h-3 rounded-full',
          {
            'bg-green-400': status === 'normal',
            'bg-yellow-400': status === 'warning',
            'bg-red-400': status === 'error'
          }
        ]"></div>
      </div>
      <div class="text-2xl font-semibold text-gray-900 mb-1">{{ value }}</div>
      <div :class="[
        'text-sm',
        change.startsWith('+') ? 'text-red-600' : 'text-green-600'
      ]">
        {{ change }} from last hour
      </div>
    </div>
  `
}

// Alert Item Component
const AlertItem = {
    props: {
        severity: String,
        message: String,
        time: String
    },
    template: `
    <div class="flex items-start space-x-3">
      <div :class="[
        'w-2 h-2 rounded-full mt-2 flex-shrink-0',
        {
          'bg-green-400': severity === 'info',
          'bg-yellow-400': severity === 'warning',
          'bg-red-400': severity === 'error'
        }
      ]"></div>
      <div class="flex-1 min-w-0">
        <p class="text-sm text-gray-900">{{ message }}</p>
        <p class="text-xs text-gray-500 mt-1">{{ time }}</p>
      </div>
    </div>
  `
}
</script>