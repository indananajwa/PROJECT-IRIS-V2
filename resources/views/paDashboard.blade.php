@extends('header')

@section('title', 'Dashboard Kaprodi')

@section('page')

<div class="flex h-screen">
    {{-- Sidebar --}}
    <x-side-bar :active="request()->route()->getName()"></x-side-bar>
    {{-- End Sidebar --}}

    {{-- Main Content --}}
    <div id="main-content" class="flex-1 p-8 bg-gray-200 min-h-screen ml-[350px]">
        <div class="flex justify-between items-start mb-8">
            <!-- Bagian Kiri: Dashboard Kaprodi -->
            <div>
                <h1 class="text-3xl font-bold ">Dashboard Kaprodi</h1>
                <div class="mt-4 bg-white p-6 rounded-2xl shadow-md border border-gray-300 w-[650px] relative">
                    <!-- Profil Information -->
                    <div class="flex items-center">
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-blue-600">PROFIL</h2>
                            <p>Akbar</p>
                            <p>akbar@gmail.com</p>
                        </div>
                    </div>
                    <!-- Informasi Fakultas -->
                    <div class="mt-4 bg-gray-300 text-center rounded-2xl p-4">
                        <h3 class="text-lg font-bold">Fakultas Teknologi Informasi</h3>
                    </div>
                    <!-- Foto Besar Lingkaran -->
                    <div class="absolute right-[-50px] bottom-[-50px] rounded-full w-[150px] h-[150px] bg-black overflow-hidden">
                        <img src="{{ asset('alip.jpg') }}" alt="Profile Image" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Tombol Logout -->
            <div class="flex flex-col items-end">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 font-bold bg-white py-2 px-4 rounded-full shadow hover:bg-red-100">
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>

        <!-- Informasi Mahasiswa -->
        <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-300">
            <h2 class="text-2xl font-bold mb-4">Informasi Mahasiswa</h2>
            <div class="flex justify-between mb-8 px-4">
                <div class="bg-[#38A6D6] p-6 rounded-2xl text-center w-[30%]">
                    <h1 class="text-2xl font-bold">632</h1>
                    <p>Total Mahasiswa</p>
                </div>
                <div class="bg-[#2ACD7F] p-6 rounded-2xl text-center w-[30%]">
                    <h1 class="text-2xl font-bold">610</h1>
                    <p>Mahasiswa Aktif</p>
                </div>
                <div class="bg-[#C34444] p-6 rounded-2xl text-center w-[30%]">
                    <h1 class="text-2xl font-bold">22</h1>
                    <p>Mahasiswa Cuti</p>
                </div>
            </div>

            <!-- Tabel Informasi Mahasiswa -->
            <div class="overflow-x-auto">
                <table class="w-full text-center bg-white rounded-2xl shadow-md border border-gray-300">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 font-semibold text-gray-700">No</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Angkatan</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Jumlah Mahasiswa</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Aktif</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Cuti</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Rata-rata IPK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">2024</td>
                            <td class="py-3 px-4">215</td>
                            <td class="py-3 px-4">215</td>
                            <td class="py-3 px-4">0</td>
                            <td class="py-3 px-4">3.9</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4">2</td>
                            <td class="py-3 px-4">2023</td>
                            <td class="py-3 px-4">198</td>
                            <td class="py-3 px-4">195</td>
                            <td class="py-3 px-4">3</td>
                            <td class="py-3 px-4">3.1</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4">3</td>
                            <td class="py-3 px-4">2022</td>
                            <td class="py-3 px-4">165</td>
                            <td class="py-3 px-4">150</td>
                            <td class="py-3 px-4">15</td>
                            <td class="py-3 px-4">3.3</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4">4</td>
                            <td class="py-3 px-4">2021</td>
                            <td class="py-3 px-4">40</td>
                            <td class="py-3 px-4">36</td>
                            <td class="py-3 px-4">4</td>
                            <td class="py-3 px-4">3.8</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

