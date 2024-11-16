<?php

namespace App\Http\Controllers;


use App\Models\Irstest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Mahasiswa;

class IrsController extends Controller
{
    public function all()
    {
        // Join the mahasiswa table to group by semester in matakuliah and sum SKS
        $data = Irstest::select('mata_kuliah.plotsemester as semester', DB::raw('SUM(mata_kuliah.sks) as total_sks'))
            ->join('mata_kuliah', 'irs_test.kodemk', '=', 'mata_kuliah.kodemk')
            ->where('irs_test.status', 'Disetujui')  // Filter by status 'Disetujui'
            ->groupBy('mata_kuliah.plotsemester')
            ->orderBy('mata_kuliah.plotsemester', 'asc')
            ->get();

        // dd($data);

        $email = auth()->user()->email;

        return view('mhsIrs', compact('data', 'email'));
    }

    public function index(Request $request, $semester,$email)
    {

        // Get the specific records for the selected semester from matakuliah
        $query = "SELECT m.kodemk as kodemk, m.nama as mata_kuliah, j.ruang as ruang, m.sks as sks FROM irs_test i JOIN mata_kuliah m ON i.kodemk = m.kodemk JOIN jadwal j ON i.kodejadwal = j.id WHERE email = '".$email."' AND i.status = 'Disetujui'  AND plotsemester='".$semester."'";

        $data = DB::select($query);

        //change data to object
        $data = json_decode(json_encode($data));
        return response()->json(['data' => $data]);

        if ($request->ajax()) {
            return response()->json($data);
        }

        return view('paDaftarMahasiswa', compact('mahasiswa'));
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id); // Mengambil data mahasiswa berdasarkan ID
        $data = MataKuliah::all(); // Mengambil semua data mata kuliah
        $status = $mahasiswa->status; // Misalkan kolom status IRS ada di tabel mahasiswa
        $komentar = $mahasiswa->komentar; // Ambil komentar yang sudah tersimpan
        
        return view('paHalamanIRS', compact('mahasiswa', 'data', 'status', 'komentar'));
        return view('paHalamanIRS', compact('mahasiswa', 'status'));

        $allApproved = Mahasiswa::where('irs_status', 'Disetujui')->get();
        return view('paDaftarMahasiswa', compact('allApproved'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Menemukan data IRS berdasarkan ID mahasiswa
        $irs = Irs::where('mahasiswa_id', $id)->first();

        if (!$irs) {
            return redirect()->back()->with('error', 'IRS tidak ditemukan');
        }

        // Memperbarui status dan komentar IRS
        $irs->status = $request->status;
        $irs->komentar = $request->komentar;
        $irs->save();

        // Update status mahasiswa jika IRS disetujui
        if ($request->status == 'disetujui') {
            $mahasiswa = Mahasiswa::find($id);
            $mahasiswa->status = 'Disetujui'; // Update status mahasiswa
            $mahasiswa->save();
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('daftar-mahasiswa')->with('success', 'Status IRS berhasil diperbarui');
    }

    public function saveStatus(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|string',
            'id' => 'required|exists:mahasiswa,id', // Pastikan ID mahasiswa valid
        ]);

        $mahasiswa = Mahasiswa::find($validated['id']);
        $mahasiswa->irs_status = $validated['status']; // Update kolom irs_status
        $mahasiswa->save();

        return redirect()->route('daftarmahasiswa')->with('success', 'Status IRS berhasil diperbarui!');
    }

    public function save(Request $request)
    {
        // Validasi input dari request
        $validatedData = $request->validate([
            'id' => 'required|exists:mahasiswa,id',
            'status' => 'required|string',
            'komentar' => 'nullable|string', // Menambahkan komentar sebagai optional
        ]);

        // Cari data mahasiswa berdasarkan ID
        $mahasiswa = Mahasiswa::findOrFail($validatedData['id']);
        
        // Perbarui kolom status dan komentar jika ada
        $mahasiswa->irs_status = $validatedData['status'];
        
        // Jika Anda juga ingin menyimpan komentar
        if (isset($validatedData['komentar'])) {
            $mahasiswa->komentar = $validatedData['komentar'];
        }

        // Simpan perubahan ke database
        $mahasiswa->save();

        // Redirect ke halaman daftar mahasiswa dengan pesan sukses
        return redirect()->route('daftarmahasiswa')->with('success', 'Status IRS berhasil diperbarui!');
    }

    public function indexMahasiswa()
    {
        $mahasiswa = Mahasiswa::all(); // Ambil semua data mahasiswa
        return view('paDaftarMahasiswa', compact('mahasiswa'));
    }

    public function daftarMahasiswa()
    {
        $mahasiswa = Mahasiswa::all();
        $approvedCount = Mahasiswa::where('irs_status', 'Disetujui')->count();
        $notApprovedCount = Mahasiswa::where('irs_status', '!=', 'Disetujui')->count();
        $totalCount = $mahasiswa->count();

        return view('paDaftarMahasiswa', compact('mahasiswa', 'approvedCount', 'notApprovedCount', 'totalCount'));
        return view('paDaftarMahasiswa', compact('mahasiswa'));
    }

}
