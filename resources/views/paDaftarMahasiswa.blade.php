@extends('header')

@section('title', 'Daftar Mahasiswa')

@section('page')
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    /* Hilangkan outline pada elemen teks dan cegah pemilihan teks */
    p, span, h1, h2, h3, h4, h5, h6, a {
        outline: none;
        user-select: none;
    }
    .no-outline {
        outline: none;
        pointer-events: none;
    }
</style>

<div class="flex h-screen">
    {{-- Sidebar --}}
    <x-side-bar :active="request()->route()->getName()"></x-side-bar>
    {{-- End Sidebar --}}

    {{-- Main Content --}}
    <div id="main-content" class="flex-1 p-8 bg-white min-h-screen ml-[340px]">
        <div class="flex flex-col items-start space-y-8">
            <!-- Header Daftar Mahasiswa -->
            <h1 class="text-3xl font-bold text-[#264A5D] mb-4">Daftar Mahasiswa</h1>
        </div>
        <div class="flex justify-between items-center mb-6">
            <input id="searchMahasiswa" type="text" placeholder="Search..." class="sans border rounded p-2 w-1/2 mb-4 shadow-lg rounded-lg text-sm px-5 py-2.5">
            <button id="tandaTangan" data-modal-target="uploadModal" data-modal-toggle="uploadModal" 
                class="btn btn-primary text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 shadow-lg font-medium rounded-lg text-sm px-5 py-2.5">
                Tanda Tangani IRS +
            </button>
        </div>
        <!-- Filter Buttons -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex space-x-4">
                <button id="showAll" class="btn flex items-center space-x-2 px-5 py-2.5 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
                    <span>All</span>
                    <span id="totalCount" class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">0</span>
                </button>
                
                <button id="showApproved" class="btn flex items-center space-x-2 px-5 py-2.5 rounded-lg text-sm font-medium bg-green-600 text-white hover:bg-green-700">
                    <span>Disetujui</span>
                    <span id="approvedCount" class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">0</span>
                </button>
                
                <button id="showNotApproved" class="btn flex items-center space-x-2 px-5 py-2.5 rounded-lg text-sm font-medium bg-red-600 text-white hover:bg-red-700">
                    <span>Belum Disetujui</span>
                    <span id="notApprovedCount" class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">0</span>
                </button>
            </div>

            <!-- Date Picker -->  
            <div id="date-range-picker" date-rangepicker class="flex items-center">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-range-start" name="start" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date start">
                </div>
                <span class="mx-4 text-gray-500">to</span>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-range-end" name="end" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Select date end">
                </div>
            </div>
        </div>

        {{-- Main Content --}}
                <!-- Tabel Daftar Mahasiswa -->
                <div class="my-5 bg-white shadow-md rounded-lg overflow-hidden">
                    <table id="Mahasiswa" class="sans w-full border-collapse" id="mahasiswa" class="w-full bg-white rounded-lg shadow-md border-collapse">
                        <thead>
                            <tr class="text-color: #264A5D; text-center" style="background-color: #ECEFF6;">
                                <th class="py-3 px-4 text-left text-sm font-semibold border">No</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold border">NIM</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold border">Nama</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold border">Prodi</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold border">Angkatan</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold border">Email</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold border">Status</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $mahasiswa)
                                <tr tr class="border-b {{ $loop->iteration % 2 == 0 ? 'bg-[#ECEFF6]' : '' }}">
                                    <td class="py-3 px-4 text-center border">{{ $loop->iteration }}</td>
                                    <td class="py-3 px-4 border">{{ $mahasiswa->nim }}</td>
                                    <td class="py-3 px-4 border">
                                        <a href="{{ route('paHalamanIRS', ['id' => $mahasiswa->id]) }}" class="hover:underline">
                                            {{ $mahasiswa->nama }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-4 text-center border">{{ $mahasiswa->prodi }}</td>
                                    <td class="py-3 px-4 text-center border">{{ $mahasiswa->angkatan }}</td>
                                    <td class="py-3 px-4 text-center border">{{ $mahasiswa->email}}</td>
                                    <td class="py-3 px-4 text-center border">
                                        @if ($mahasiswa->irs_status == 'Disetujui')
                                            <span class="bg-green-100 text-green-700 text-sm font-medium px-3 py-1 rounded-full">
                                                {{ $mahasiswa->irs_status }}
                                            </span>
                                        @elseif ($mahasiswa->irs_status == 'Pending')
                                            <span class="bg-yellow-100 text-yellow-700 text-sm font-medium px-3 py-1 rounded-full">
                                                {{ $mahasiswa->irs_status }}
                                            </span>
                                        @elseif ($mahasiswa->irs_status == 'Ditolak')
                                            <span class="bg-red-100 text-red-700 text-sm font-medium px-3 py-1 rounded-full">
                                                {{ $mahasiswa->irs_status }}
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-700 text-sm font-medium px-3 py-1 rounded-full">
                                                {{ $mahasiswa->irs_status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-center border">
                                        <a href="/view-irs/${nama_mahasiswa}.pdf" target="_blank" class="text-blue-500">Lihat IRS</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Cek Status --}}
<script>
    function checkStatuses() {
    const rows = document.querySelectorAll('table tbody tr'); // Ambil semua baris tabel
    let allApproved = true; // Awalnya anggap semua status disetujui

    rows.forEach(row => {
        const $mahasiswa->irs->status = row.cells[5].innerText.trim(){ // Ambil teks kolom Status
            if ($mahasiswa->irs->status !== "Disetujui") {
                allApproved = false; // Kalau ada yang belum disetujui, ubah ke false
            }
        }
    });

    const button = document.getElementById('tandaTanganiButton'); // Tombolnya
    if (allApproved) {
        button.disabled = false; // Kalau semua disetujui, aktifkan tombol
    } else {
        button.disabled = true; // Kalau tidak, nonaktifkan tombol
        button.onclick = () => alert("IRS mahasiswa harus disetujui terlebih dahulu");
    }
}

// Panggil fungsi ini saat halaman pertama kali dimuat
window.onload = checkStatuses;

</script>

<script>
    document.getElementById('tandaTangan').addEventListener('click', function() {
        const allApproved = this.getAttribute('data-all-approved') === 'true';

        // Gantikan dengan URL ke halaman daftar mahasiswa
        var routePaDaftarMahasiswa = "{{ route('daftarmahasiswa') }}";  // Ganti dengan nama route daftar mahasiswa

        if (!allApproved) {
            // Jika ada mahasiswa yang belum disetujui, tampilkan SweetAlert
            Swal.fire({
                icon: "error",
                title: "Gagal Menandatangani",
                text: "Mohon periksa dan setujui seluruh IRS sebelum menandatangani secara digital",
                footer: '<a href="' + routePaDaftarMahasiswa + '">Setujui IRS</a>'
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () ){
        const buttons = document.querySelectorAll('.open-modal');
        const emailList = document.getElementById('emailList');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const email = this.getAttribute('data-email');
                // Masukkan email ke dalam modal
                emailList.innerHTML = `
                    <div class="mb-3">
                        <label for="staticEmail" class="form-label">Email</label>
                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="${email}">
                    </div>`;
            });
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.open-modal');
        const hiddenEmail = document.getElementById('hiddenEmail');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const email = this.getAttribute('data-email');
                hiddenEmail.value = email; // Set value hidden input
            });
        });
    });

</script>


{{-- datatable  --}}
            <script>
                $(document).ready( function () {
                    var tableMahasiswa = $('#Mahasiswa').DataTable({
                        layout :{
                            topStart: null,
                            topEnd: null,
                            bottomStart: 'pageLength',
                            bottomEnd: 'paging'
                        }
                    });

                    $('#searchMahasiswa').keyup(function() {
                        tableMahasiswa.search($(this).val()).draw();
                    });
                } );
            </script>
        {{-- datatble_end --}}

@endsection
