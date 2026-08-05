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
        'jangka_waktu_penyelesaian',
        'biaya_tarif',
        'admin_penanggung_jawab_id',
        'admin_penanggung_jawab_nama',
        'dokumen_terkirim',
        'selesai_at',
    ];

    protected $casts = [
        'dokumen_terkirim' => 'array',
        'selesai_at'       => 'datetime',
        // NIK (national ID number) is sensitive PII — encrypt at rest.
        // Requires the 'nik' column to be TEXT, not VARCHAR(16); see the
        // 2026_08_03_000000_widen_nik_column_for_encryption migration.
        'nik'              => 'encrypted',
    ];

    // ── Relations ────────────────────────────────────────────────────────────
    // Admin yang sedang/terakhir menangani permohonan ini — hanya untuk
    // informasi internal admin panel, tidak ditampilkan pada PDF.
    public function adminPenanggungJawab()
    {
        return $this->belongsTo(User::class, 'admin_penanggung_jawab_id');
    }

    // Riwayat/log setiap perubahan status beserta admin yang melakukannya.
    public function logs()
    {
        return $this->hasMany(PermohonanDataLog::class)->latest();
    }

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

    public function labelLingkupKegiatan(): string
    {
        return match ($this->lingkup_kegiatan) {
            'pendidikan' => 'Pendidikan',
            'penelitian' => 'Penelitian',
            'sosial'     => 'Sosial/Kemanusiaan',
            default      => $this->lingkup_kegiatan ? ucfirst($this->lingkup_kegiatan) : '-',
        };
    }

    public function badgeStatus(): array
    {
        return match ($this->status) {
            'baru'      => ['label' => 'Baru',      'class' => 'bg-blue-100 text-blue-700'],
            'diproses'  => ['label' => 'Diproses',  'class' => 'bg-yellow-100 text-yellow-700'],
            'belum dibayar' => ['label' => 'Belum Dibayar', 'class' => 'bg-orange-100 text-orange-700'],
            'sudah dibayar' => ['label' => 'Sudah Dibayar', 'class' => 'bg-emerald-100 text-emerald-700'],
            'selesai'   => ['label' => 'Selesai',   'class' => 'bg-green-100 text-green-700'],
            'ditolak'   => ['label' => 'Ditolak',   'class' => 'bg-red-100 text-red-700'],
            default     => ['label' => ucfirst($this->status), 'class' => 'bg-gray-100 text-gray-600'],
        };
    }
}
