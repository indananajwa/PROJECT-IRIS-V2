<!-- resources/views/irs.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>IRS Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Include Bootstrap JS for modal functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="font-sans bg-gray-50">
    <header class="flex items-center p-4">
        <img src="{{ asset('iris.png') }}" alt="Logo" class="w-12 h-12 mr-1">
        <h1 class="text-xl font-bold">IRIS</h1>
    </header>

    <!-- Sidebar -->
    <div class="flex justify-between items-center px-8">
        <!-- Tombol Kembali dengan Gambar Sebelum Teks -->
        <div class="flex items-center space-x-2">
            <a href="{{ route('daftarmahasiswa') }}">
                <img src="{{ asset('Back.png') }}" alt="Kembali" class="w-8 h-8 mr-1">
            </a>
            <h1 class="text-2xl font-bold font-sans">Isian Rencana Studi (IRS) Mahasiswa</h1>
        </div>    
    </div>
    <div class="flex items-start p-8">
        <aside class="w-1/3">
            <div class="text-center mb-6 bg-gray-100 p-4 rounded-lg shadow">
                <div class="flex justify-center items-center">    
                    <img src="{{ asset('alip.jpg') }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover mb-2">
                </div>
                <h2 class="font-sans text-lg font-bold">{{ $mahasiswa->nama }}</h2>
                <p class="mb-2">NIM. {{ $mahasiswa->nim }}</p>
                <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-sm">Semester {{ $mahasiswa->semester_berjalan }}</span>
                <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-sm">{{ $mahasiswa->status }}</span>
            </div>
            <div class="bg-green-50 p-4 rounded-lg shadow">
                <h3 class="text-center text-lg font-semibold text-white py-2" style="background-color: #83B5C0;">IRS</h3>
                <div class="flex justify-between border-b py-2">
                    <label class="text-gray-700">SKS Maksimal</label>
                    <div class="text-gray-700 w-2/3 p-1 border rounded-md focus:outline-none focus:ring focus:ring-blue-300 bg-gray-100">
                        {{ $mahasiswa->sks }}
                    </div>
                </div>
                <div class="flex justify-between border-b py-2">
                    <label class="text-gray-700">IPS</label>
                    <div class="text-gray-700 w-2/3 p-1 border rounded-md focus:outline-none focus:ring focus:ring-blue-300 bg-gray-100">
                        {{ $mahasiswa->ips }}
                    </div>
                </div>
                <div class="flex justify-between border-b py-2">
                    <label class="text-gray-700">IPK</label>
                    <div class="text-gray-700 w-2/3 p-1 border rounded-md focus:outline-none focus:ring focus:ring-blue-300 bg-gray-100">
                        {{ $mahasiswa->ipk }}
                    </div>
                </div>
                <form id="irs-form" method="POST" action="{{ route('irs.save') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $mahasiswa->id }}">
                    <div class="flex justify-between border-b py-2">
                        <label for="status" class="text-gray-700 text-bold">Status IRS</label>
                        <select class="form-control w-2/3 p-1 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" id="status" name="status" required {{ $mahasiswa->irs_status != 'Pending' ? 'disabled' : '' }}>
                            <option value="Pending" {{ $mahasiswa->irs_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ $mahasiswa->irs_status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ $mahasiswa->irs_status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="flex justify-between border-b py-2">
                        <label class="text-gray-700" id="komentar" name="komentar">Komentar</label>
                        <textarea class="w-2/3 p-1 border rounded-md focus:outline-none focus:ring focus:ring-blue-300 shadow-sm" id="komentarText" placeholder="Komentar"></textarea>
                    </div>
                    <div class="flex justify-end items-center space-x-2 border-b py-2">
                        <button type="button" class="btn btn-primary mt-4 bg-yellow-500 text-white py-1 px-4 rounded-lg" id="resetButton">Reset</button>
                        <button type="button" class="btn btn-primary mt-4 bg-blue-500 text-white py-1 px-4 rounded-lg" id="saveIRS">Save</button>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="w-full px-8">
            <!-- Tab Navigation -->
            <div class="flex space-x-5 mb-4 px-8">
                <button class="w-1/3 bg-blue-500 text-white py-2 px-4 rounded-lg focus:outline-none" style="background-color: #4D8CC4;">Mata Kuliah</button>
                <button class="w-1/3 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg focus:outline-none" style="background-color: #DEE9FF;">Jadwal</button>
                <button class="w-1/3 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg focus:outline-none" style="background-color: #DEE9FF;">Kelas</button>
            </div>

            <!-- Table -->
            <div class="flex items-center justify-between mb-1 px-8">
                <h1 class="font-bold text-gray-400 text-center text-lg">Mata Kuliah yang Dipilih</h1>
                <img src="{{ asset('unduhPdf.png') }}" alt="unduh" class="w-12 h-12 mr-1" style="fill: #000000;">
                <button id="exportPdf" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Export</button>
            </div>
            <hr class="border-gray-400 mb-4 px-4">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-[#264A5D] text-center" style="background-color: #ECEFF6;">
                            <th class="py-3 px-4 border">No</th>
                            <th class="py-3 px-4 border">Kode MK</th>
                            <th class="py-3 px-4 border">Nama MK</th>
                            <th class="py-3 px-4 border">SKS</th>
                            <th class="py-3 px-4 border">Semester</th>
                            <th class="py-3 px-4 border">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $matakuliah)
                            <tr tr class="border-b {{ $loop->iteration % 2 == 0 ? 'bg-[#ECEFF6]' : '' }}">
                                <td class="py-3 px-4 text-center border">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 border">{{ $matakuliah->kodemk }}</td>
                                <td class="py-3 px-4 border">{{ $matakuliah->nama }}</td>
                                <td class="py-3 px-4 text-center border">{{ $matakuliah->sks }}</td>
                                <td class="py-3 px-4 text-center border">{{ $matakuliah->plotsemester }}</td>
                                <td class="py-3 px-4 text-center border"></td>
                            </tr>
                        @endforeach
                        </div>
                    </tbody>
                    <tfoot>
                        @php
                            $totalSKS = $data->sum('sks');
                        @endphp
                        <tr style="background-color: #ECEFF6;">
                            <td colspan="6" class="py-3 px-4 text-center font-semibold border">Total SKS: {{ $totalSKS }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="font-bold font-#4D8CC4 py-3 text-center">
        <a href="{{ route('daftarmahasiswa', ['id' => $mahasiswa->id]) }}" class="hover:underline">
            Status Perubahan
        </a>
    </div>

    <!-- Modal -->
    <!-- <div class="modal fade" id="irs-popup" tabindex="-1" aria-labelledby="irs-popup-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="irs-popup-label">IRS Berhasil!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    IRS Anda telah berhasil disimpan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div> -->

    <!-- JavaScript for Form submission and modal -->
    <script>
        document.getElementById('irs-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const irsStatusSelect = document.getElementById('irs-status');
            if (irsStatusSelect.value === 'Disetujui') {
                const irsPopup = new bootstrap.Modal(document.getElementById('irs-popup'));
                irsPopup.show();

                setTimeout(function() {
                    event.target.submit();
                }, 2000);
            } else {
                event.target.submit();
            }
        });
    </script>

    <script>
        document.getElementById('exportPdf').addEventListener('click', function () {
            // Ambil elemen tabel
            const table = document.querySelector('table'); 

            // Buat PDF
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Tambahkan tabel ke PDF
            doc.autoTable({ html: table });

            // Simpan PDF
            doc.save('{{$mahasiswa->nama}}_{{$mahasiswa->nim}}_IRS.pdf');
        });
    </script>

    <script>
        document.getElementById('saveIRS').addEventListener('click', function () {
            // Ambil elemen form
            const irsForm = document.getElementById('irs-form');

            // Tampilkan SweetAlert sebelum submit
            Swal.fire({
                title: "Yakin ingin menyimpan?",
                text: "Perubahan data IRS akan disimpan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, simpan",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika user menekan tombol "Ya"
                    irsForm.submit();
                }
            });
        });
    </script>

<script>
    document.getElementById('resetButton').addEventListener('click', function() {
        // Mengosongkan textarea komentar
        const komentarText = document.getElementById('komentarText');
        komentarText.value = ''; // Kosongkan textarea

        // Mengaktifkan kembali dropdown
        const statusDropdown = document.getElementById('status');
        statusDropdown.disabled = false; // Pastikan dropdown bisa dipilih
    });

    document.getElementById('saveIRS').addEventListener('click', function() {
        // Simulasi penyimpanan data
        // Di sini Anda harus menambahkan logika untuk menyimpan data ke server
        console.log("Data disimpan");

        // Nonaktifkan dropdown setelah disimpan
        const statusDropdown = document.getElementById('status');
        statusDropdown.disabled = true; // Nonaktifkan dropdown
    });
</script>



</body>
</html>
