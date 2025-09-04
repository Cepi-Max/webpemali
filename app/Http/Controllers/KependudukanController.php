<?php

namespace App\Http\Controllers;

use App\Models\Kependudukan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KependudukanImport;
use App\Exports\KependudukanExport;

class KependudukanController extends Controller
{
    
    public function index()
    {
        $data = Kependudukan::latest()->paginate(20);
        return view('kependudukan.index', compact('data'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        // Proses import
        $import = new KependudukanImport;
        Excel::import($import, $request->file('file'));

        // Kalau ada data yang gagal, tampilkan
        if (count($import->invalidRows) > 0) {
            return back()->with('warning', 'Beberapa data gagal diimport. Silakan cek kembali formatnya.')
                         ->with('invalidRows', $import->invalidRows);
        }

        return back()->with('success', 'Data berhasil diimport!');
    }

    public function export()
    {
        $filename = 'data_kependudukan_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new KependudukanExport, $filename);
    }

    // Soft Delete
    public function destroy($id)
    {
        $data = Kependudukan::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Data berhasil dihapus (soft delete)');
    }

    // Tampilkan data yang sudah dihapus
    public function trashed()
    {
        $data = Kependudukan::onlyTrashed()->paginate(20);
        return view('kependudukan.trashed', compact('data'));
    }

    // Restore data yang terhapus
    public function restore($id)
    {
        $data = Kependudukan::onlyTrashed()->findOrFail($id);
        $data->restore();

        return back()->with('success', 'Data berhasil dipulihkan');
    }

    // Permanent Delete
    public function forceDelete($id)
    {
        $data = Kependudukan::onlyTrashed()->findOrFail($id);
        $data->forceDelete();

        return back()->with('success', 'Data berhasil dihapus permanen');
    }
}
