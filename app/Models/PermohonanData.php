<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PermohonanData extends Model
{
    protected $table = 'permohonan_data';

    protected $fillable = [
        'nama_lengkap',
        'nik',
        'email',
        'no_hp',
        'instansi',
        'alamat',
        'jenis_permohonan',
        'jenis_data',
        'lingkup_kegiatan',
        'file_surat_permohonan',
        'file_surat_pengantar',
        'file_surat_pernyataan',
        'file_proposal',
        'status',
        'catatan_admin',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeBaru($query)
    {
        return $query->where('status', 'baru');
    }

    public function scopePnbp($query)
    {
        return $query->where('jenis_permohonan', 'pnbp');
    }

    public function scopeNol($query)
    {
        return $query->where('jenis_permohonan', 'nol');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────
    public function labelJenisPermohonan(): string
    {
        return $this->jenis_permohonan === 'pnbp' ? 'PNBP' : 'Tarif Nol Rupiah';
    }

    public function badgeStatus(): array
    {
        return match ($this->status) {
            'baru'      => ['label' => 'Baru',      'class' => 'bg-blue-100 text-blue-700'],
            'diproses'  => ['label' => 'Diproses',  'class' => 'bg-yellow-100 text-yellow-700'],
            'selesai'   => ['label' => 'Selesai',   'class' => 'bg-green-100 text-green-700'],
            'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-red-100 text-red-700'],
            default     => ['label' => ucfirst($this->status), 'class' => 'bg-gray-100 text-gray-600'],
        };
    }
}
