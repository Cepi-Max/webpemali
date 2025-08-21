<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kependudukan extends Model
{
    use SoftDeletes;
    use HasFactory;
    //
    protected $table = 'kependudukan';
    protected $primaryKey = 'nik';
    protected $fillable = [
        'rt',
        'dusun',
        'alamat',
        'no_kk',
        'kepala_keluarga',
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'posisi_dalam_keluarga',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'status_pernikahan',
        'agama',
        'golongan_darah',
        'pendidikan',
        'pekerjaan',
    ];


    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where('nama_lengkap', 'like', '%' . $search . '%')
                ->orWhere('nik', 'like', '%' . $search . '%');
        });

        $query->when(($filters['status'] ?? false) === 'trashed', function ($query) {
            $query->onlyTrashed();
        });
    }


}
