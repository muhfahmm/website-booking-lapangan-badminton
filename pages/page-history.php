<?php
/**
 * History Page Content
 * Halaman untuk melihat riwayat booking pengguna
 */
?>

<div class="min-h-screen bg-slate-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900 mb-4">Riwayat Booking</h1>
            <p class="text-lg text-gray-600">Kelola dan lihat semua booking Anda</p>
        </div>

        <!-- Login Prompt -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg mb-8">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-1">Silakan Login Terlebih Dahulu</h3>
                    <p class="text-blue-700">Anda harus login untuk melihat riwayat booking Anda. <a href="../admin/login.php" class="font-bold underline hover:no-underline">Login sekarang</a> atau <a href="../admin/auth/register.php" class="font-bold underline hover:no-underline">buat akun baru</a>.</p>
                </div>
            </div>
        </div>

        <!-- Booking List (Mock Data) -->
        <div class="space-y-6">
            <!-- Booking Card 1 - Upcoming -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
                    <!-- Status Badge -->
                    <div>
                        <div class="flex items-center justify-center h-full">
                            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full font-bold text-center">
                                ✓ Upcoming
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Lapangan</p>
                        <p class="text-lg font-bold text-slate-900 mb-3">Lapangan A</p>
                        <p class="text-sm text-gray-600">📍 Jl. Utama No. 1</p>
                    </div>

                    <!-- Schedule -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Jadwal</p>
                        <p class="text-lg font-bold text-slate-900 mb-1">15 Juni 2026</p>
                        <p class="text-sm text-gray-700">19:00 - 21:00 (2 jam)</p>
                    </div>

                    <!-- Price & Action -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total</p>
                            <p class="text-2xl font-bold text-emerald-600">Rp 300.000</p>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <button class="flex-1 bg-emerald-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                                Detail
                            </button>
                            <button class="flex-1 bg-red-100 text-red-700 py-2 rounded-lg text-sm font-semibold hover:bg-red-200 transition">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Card 2 - Completed -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition opacity-75">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
                    <!-- Status Badge -->
                    <div>
                        <div class="flex items-center justify-center h-full">
                            <div class="bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-bold text-center">
                                ✓ Selesai
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Lapangan</p>
                        <p class="text-lg font-bold text-slate-900 mb-3">Lapangan B</p>
                        <p class="text-sm text-gray-600">📍 Jl. Sudirman No. 45</p>
                    </div>

                    <!-- Schedule -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Jadwal</p>
                        <p class="text-lg font-bold text-slate-900 mb-1">10 Juni 2026</p>
                        <p class="text-sm text-gray-700">18:00 - 19:00 (1 jam)</p>
                    </div>

                    <!-- Price & Action -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total</p>
                            <p class="text-2xl font-bold text-gray-600">Rp 120.000</p>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <button class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                Ulang
                            </button>
                            <button class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                                Rating
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Card 3 - Cancelled -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition opacity-60">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
                    <!-- Status Badge -->
                    <div>
                        <div class="flex items-center justify-center h-full">
                            <div class="bg-red-100 text-red-800 px-4 py-2 rounded-full font-bold text-center">
                                ✕ Dibatalkan
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Lapangan</p>
                        <p class="text-lg font-bold text-slate-900 mb-3">Lapangan C</p>
                        <p class="text-sm text-gray-600">📍 Jl. Gatot Subroto No. 89</p>
                    </div>

                    <!-- Schedule -->
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Jadwal</p>
                        <p class="text-lg font-bold text-slate-900 mb-1">08 Juni 2026</p>
                        <p class="text-sm text-gray-700">20:00 - 22:00 (2 jam)</p>
                    </div>

                    <!-- Price & Action -->
                    <div class="flex flex-col justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total</p>
                            <p class="text-2xl font-bold text-gray-400">Rp 460.000</p>
                        </div>
                        <div class="flex gap-2 mt-4">
                            <button class="flex-1 bg-emerald-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700 transition">
                                Booking Ulang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (Optional) -->
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4 text-5xl">📋</div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Belum ada booking</h3>
            <p class="text-gray-600 mb-6">Anda belum memiliki riwayat booking. Mulai booking lapangan sekarang!</p>
            <a href="page.php?page=booking" class="inline-block bg-emerald-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition">
                Booking Lapangan Sekarang →
            </a>
        </div>

        <!-- Filter Section (optional) -->
        <div class="mt-12 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-slate-900 mb-6">Filter Riwayat</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-600">
                        <option>Semua</option>
                        <option>Upcoming</option>
                        <option>Selesai</option>
                        <option>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-600">
                        <option>Semua</option>
                        <option>Juni 2026</option>
                        <option>Mei 2026</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lapangan</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-600">
                        <option>Semua</option>
                        <option>Lapangan A</option>
                        <option>Lapangan B</option>
                        <option>Lapangan C</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button class="w-full bg-emerald-600 text-white py-2 rounded-lg font-semibold hover:bg-emerald-700 transition">
                        Filter
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
