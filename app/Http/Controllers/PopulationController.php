<?php

namespace App\Http\Controllers;

use App\Exports\KependudukanExport;
use App\Imports\KependudukanImport;
use App\Models\Kependudukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PopulationController extends Controller
{
    
    public function index()
    {
        $dataKependudukan = Kependudukan::filter(request(['search', 'status']))->latest()->paginate(6)->withQueryString();

        $data = [
            'title' => 'Data Kependudukan',
            'dataKependudukan' => $dataKependudukan
        ];

        return view('admin.population.index', $data);
    }

    function details($nik)
    {
        $details = Kependudukan::where('nik', $nik)->firstOrFail();

        $data = [
            'title' => 'Data ' . $details->nama_lengkap,
            'details' => $details,
        ];

        return view('admin.population.details', $data);
    }

    public function downloadTemplate()
    {
        $filePath = 'excel/template.xlsx';

        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File template tidak ditemukan.');
        }

        $fileName = 'Template_import_data_masyarakat' . now()->format('YmdHis') . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($filePath, $fileName);
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls'
    ]);

    if (!$request->hasFile('file')) {
        return back()->with('error', 'Tidak ada file yang diunggah.');
    }

    $file = $request->file('file');

    // Pastikan file valid
    if (!$file->isValid()) {
        return back()->with('error', 'File yang diunggah tidak valid.');
    }

    // Debugging: Pastikan file memiliki path
    $filePath = $file->getPathname();
    if (empty($filePath) || !file_exists($filePath)) {
        return back()->with('error', 'File tidak ditemukan atau tidak dapat diakses.');
    }

    // Import file menggunakan Maatwebsite Excel
    try {
        $import = new KependudukanImport;
        Excel::import($import, $file);
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
    }

    if (count($import->invalidRows) > 0) {
        Session::put('invalid_data', $import->invalidRows);
        return redirect()->route('populations.invalidrows.show')
            ->with('warning', 'Beberapa data gagal diimport. Silakan cek kembali formatnya.');
    }

    return back()->with('success', 'Data berhasil diimport!');
}


    

    public function showInvalidRows()
    {
        $invalidData = session('invalid_data', []);
        
        return view('admin.population.invalid-rows', compact('invalidData'));
    }

    public function export()
    {
        $filename = 'data_kependudukan_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new KependudukanExport, $filename);
    }
 
    // Soft Delete
    public function destroy($nik)
    {
        $data = Kependudukan::findOrFail($nik);
        $data->delete();

        return back()->with('success', 'Data dipindahkan ke sampah');
    }

    // Tampilkan data yang sudah dihapus
    public function trashed()
    {
        $data = Kependudukan::onlyTrashed()->paginate(20);
        return view('kependudukan.trashed', compact('data'));
    }

    // Restore data yang terhapus
    public function restore($nik)
    {
        $data = Kependudukan::onlyTrashed()->findOrFail($nik);
        $data->restore();

        return back()->with('success', 'Data berhasil dipulihkan');
    }

    // Permanent Delete
    public function forceDelete($nik)
    {
        $data = Kependudukan::onlyTrashed()->findOrFail($nik);
        $data->forceDelete();

        return back()->with('success', 'Data berhasil dihapus');
    }
    
    public function truncate()
    {
        Kependudukan::truncate();

        return back()->with('success', 'Semua Data dihapus permanen');
    }

    // function form($nik = null)
    // {
    //     $dataMasyarakat = $nik ? Kependudukan::where('nik', $nik)->firstOrFail() : null;
    //     // dd($dataMasyarakat->nama_lengkap);
    //     $data = [
    //         'title' => $dataMasyarakat ? 'Ubah data '. $dataMasyarakat->nama_lengkap : 'Tambah data',
    //         'dataMasyarakat' => $dataMasyarakat,
    //     ];
    //     return view('admin.population.form', $data);
    // }

    // public function importLama(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls'
    //     ]);

    //     $import = new KependudukanImport;
    //     Excel::import($import, $request->file('file'));

    //     if (count($import->invalidRows) > 0) {
    //         return redirect()->route('populations.invalidrows.show')->with('warning', 'Beberapa data gagal diimport. Silakan cek kembali formatnya.')
    //                      ->with('invalidRows', $import->invalidRows);
    //     }

    //     return back()->with('success', 'Data berhasil diimport!');
    // }
}
