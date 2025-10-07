<template>
    <div class="min-h-screen bg-white">
        <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800">
            <div class="absolute inset-0">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 mix-blend-multiply">
                </div>
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-32">
                <div class="flex items-center justify-between mb-20">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z" />
                                <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z" />
                                <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">Control Center</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <router-link to="/login"
                            class="text-white hover:text-primary-100 px-4 py-2 text-sm font-medium transition-colors">
                            Sign in
                        </router-link>
                        <router-link to="/signup"
                            class="bg-white text-primary-700 hover:bg-primary-50 px-6 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg">
                            Get Started
                        </router-link>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight">
                        Your Files, Anywhere,
                        <span class="block text-primary-200">Anytime</span>
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-xl text-primary-100">
                        Secure cloud storage with seamless sync across all your devices. Store, share, and collaborate
                        with ease.
                    </p>
                    <div class="mt-10 flex justify-center gap-4">
                        <router-link to="/signup"
                            class="bg-white text-primary-700 hover:bg-primary-50 px-8 py-4 rounded-xl text-lg font-semibold transition-all shadow-xl hover:shadow-2xl hover:scale-105">
                            Start Free Trial
                        </router-link>
                        <button
                            class="bg-primary-500/30 text-white hover:bg-primary-500/40 px-8 py-4 rounded-xl text-lg font-semibold transition-all backdrop-blur-sm border border-white/20">
                            Watch Demo
                        </button>
                    </div>
                    <p class="mt-4 text-sm text-primary-200">
                        14-day free trial • No credit card required
                    </p>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Everything you need</h2>
                <p class="mt-4 text-xl text-gray-600">Powerful features to manage your digital life</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z" />
                            <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z" />
                            <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Secure Storage</h3>
                    <p class="text-gray-600">Your files are encrypted and stored securely with enterprise-grade
                        security.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Easy Sharing</h3>
                    <p class="text-gray-600">Share files and folders with anyone, with customizable permissions and
                        access control.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Fast Sync</h3>
                    <p class="text-gray-600">Automatic sync across all your devices keeps your files up to date
                        everywhere.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">File Versioning</h3>
                    <p class="text-gray-600">Never lose work with automatic version history and easy file recovery.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Advanced Security</h3>
                    <p class="text-gray-600">Two-factor authentication and end-to-end encryption protect your data.</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-200 p-8 hover:shadow-xl transition-shadow">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">API Access</h3>
                    <p class="text-gray-600">Integrate with your workflow using our powerful REST API.</p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Simple, transparent pricing</h2>
                    <p class="mt-4 text-xl text-gray-600">Choose the plan that's right for you</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl border border-gray-200 p-8">
                        <h3 class="text-2xl font-bold text-gray-900">Free</h3>
                        <p class="mt-4 text-gray-600">Perfect for personal use</p>
                        <p class="mt-8">
                            <span class="text-4xl font-bold text-gray-900">$0</span>
                            <span class="text-gray-600">/month</span>
                        </p>
                        <ul class="mt-8 space-y-4">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-600">10 GB storage</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-600">Basic sharing</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-600">30-day version history</span>
                            </li>
                        </ul>
                        <router-link to="/signup"
                            class="mt-8 block w-full bg-gray-100 text-gray-900 hover:bg-gray-200 text-center px-6 py-3 rounded-lg font-semibold transition-colors">
                            Get Started
                        </router-link>
                    </div>
                    <div
                        class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl border-2 border-primary-600 p-8 text-white transform scale-105 shadow-2xl">
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 mb-4">
                            Most Popular
                        </div>
                        <h3 class="text-2xl font-bold">Pro</h3>
                        <p class="mt-4 text-primary-100">For professionals and teams</p>
                        <p class="mt-8">
                            <span class="text-4xl font-bold">$9.99</span>
                            <span class="text-primary-100">/month</span>
                        </p>
                        <ul class="mt-8 space-y-4">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-white mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>2 TB storage</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-white mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Advanced sharing</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-white mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Unlimited version history</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-white mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Priority support</span>
                            </li>
                        </ul>
                        <router-link to="/signup"
                            class="mt-8 block w-full bg-white text-primary-700 hover:bg-primary-50 text-center px-6 py-3 rounded-lg font-semibold transition-colors">
                            Start Free Trial
                        </router-link>
                    </div>
                    <div class="bg-white rounded-2xl border border-gray-200 p-8">
                        <h3 class="text-2xl font-bold text-gray-900">Business</h3>
                        <p class="mt-4 text-gray-600">For larger organizations</p>
                        <p class="mt-8">
                            <span class="text-4xl font-bold text-gray-900">$19.99</span>
                            <span class="text-gray-600">/user/month</span>
                        </p>
                        <ul class="mt-8 space-y-4">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-600">Unlimited storage</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-600">Team collaboration</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-600">Admin controls</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-600">24/7 support</span>
                            </li>
                        </ul>
                        <router-link to="/signup"
                            class="mt-8 block w-full bg-gray-100 text-gray-900 hover:bg-gray-200 text-center px-6 py-3 rounded-lg font-semibold transition-colors">
                            Contact Sales
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-white">Ready to get started?</h2>
                <p class="mt-4 text-xl text-primary-100">Join thousands of users who trust Control Center Cloud</p>
                <div class="mt-8">
                    <router-link to="/signup"
                        class="inline-block bg-white text-primary-700 hover:bg-primary-50 px-8 py-4 rounded-xl text-lg font-semibold transition-all shadow-xl hover:shadow-2xl hover:scale-105">
                        Start Your Free Trial
                    </router-link>
                </div>
            </div>
        </div>
        <footer class="bg-gray-900 text-gray-300 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-white font-semibold mb-4">Product</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-4">Company</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-4">Resources</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Support</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-4">Legal</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Cookie Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-gray-800 text-center">
                    <p>&copy; 2025 Control Center Cloud. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
</script>
