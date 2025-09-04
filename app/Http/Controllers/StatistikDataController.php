<?php

namespace App\Http\Controllers;

use App\Imports\DataAgamaImport;
use App\Imports\DataDusunImport;
use App\Imports\DataEkonomiImport;
use App\Imports\DataJenisCacatImport;
use App\Imports\DataKewarganegaraanImport;
use App\Imports\DataPekerjaanImport;
use App\Imports\DataPendidikanImport;
use App\Imports\DataTenagaKerjaImport;
use App\Imports\DataUsiaImport;
use App\Imports\StatistikPendudukImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class StatistikDataController extends Controller
{
    public function index()
    {
        return view('admin.data-statistik.index');
    }

    public function importDataPenduduk(Request $request)
    {
        $request->validate([
            'dataPenduduk' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new StatistikPendudukImport, $request->file('dataPenduduk'));
            return back()->with('success', 'Data statistik berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data penduduk gagal: Pastikan format file benar!');
        }
    }

    public function importDataDusun(Request $request)
    {
        $request->validate([
            'dataDusun' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataDusunImport, $request->file('dataDusun'));
            return back()->with('success', 'Data wilayah berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data wilayah gagal: Pastikan format file benar!');
        }
    }

    public function importDataUsia(Request $request)
    {
        $request->validate([
            'dataUsia' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataUsiaImport, $request->file('dataUsia'));
            return back()->with('success', 'Data usia berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data usia gagal: Pastikan format file benar!');
        }
    }

    public function importDataPendidikan(Request $request)
    {
        $request->validate([
            'dataPendidikan' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataPendidikanImport, $request->file('dataPendidikan'));
            return back()->with('success', 'Data pendidikan berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data pendidikan gagal: Pastikan format file benar!');
        }
    }

    public function importDataPekerjaan(Request $request)
    {
        $request->validate([
            'dataPekerjaan' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataPekerjaanImport, $request->file('dataPekerjaan'));
            return back()->with('success', 'Data pekerjaan berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data pekerjaan gagal: Pastikan format file benar!');
        }
    }

    public function importDataAgama(Request $request)
    {
        $request->validate([
            'dataAgama' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataAgamaImport, $request->file('dataAgama'));
            return back()->with('success', 'Data agama berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data agama gagal: Pastikan format file benar!');
        }
    }

    public function importDataKewarganegaraan(Request $request)
    {
        $request->validate([
            'dataKewarganegaraan' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataKewarganegaraanImport, $request->file('dataKewarganegaraan'));
            return back()->with('success', 'Data kewarganegaraan berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data kewarganegaraan gagal: Pastikan format file benar!');
        }
    }

    public function importDataJenisCacat(Request $request)
    {
        $request->validate([
            'dataJenisCacat' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataJenisCacatImport, $request->file('dataJenisCacat'));
            return back()->with('success', 'Data jenis cacat berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data jenis cacat gagal: Pastikan format file benar!');
        }
    }

    public function importDataTenagaKerja(Request $request)
    {
        $request->validate([
            'dataTenagaKerja' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataTenagaKerjaImport, $request->file('dataTenagaKerja'));
            return back()->with('success', 'Data tenaga kerja berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data tenaga kerja gagal: Pastikan format file benar!');
        }
    }

    public function importDataEkonomi(Request $request)
    {
        $request->validate([
            'dataEkonomi' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new DataEkonomiImport, $request->file('dataEkonomi'));
            return back()->with('success', 'Data ekonomi berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import data ekonomi gagal: Pastikan format file benar!');
        }
    }
}
