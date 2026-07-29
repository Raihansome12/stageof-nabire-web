<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermohonanDataLog extends Model
{
    protected $table = 'permohonan_data_logs';

    protected $fillable = [
        'permohonan_data_id',
        'status_sebelumnya',
        'status_baru',
        'admin_id',
        'catatan',
    ];

    // ── Relations ────────────────────────────────────────────────────────────
    public function permohonanData()
    {
        return $this->belongsTo(PermohonanData::class, 'permohonan_data_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────
    public function badgeStatus(): array
    {
        return match ($this->status_baru) {
            'baru'           => ['label' => 'Baru',           'class' => 'bg-blue-100 text-blue-700'],
            'diproses'       => ['label' => 'Diproses',       'class' => 'bg-yellow-100 text-yellow-700'],
            'belum dibayar'  => ['label' => 'Belum Dibayar',  'class' => 'bg-orange-100 text-orange-700'],
            'sudah dibayar'  => ['label' => 'Sudah Dibayar',  'class' => 'bg-emerald-100 text-emerald-700'],
            'selesai'        => ['label' => 'Selesai',        'class' => 'bg-green-100 text-green-700'],
            'ditolak'        => ['label' => 'Ditolak',        'class' => 'bg-red-100 text-red-700'],
            default          => ['label' => ucfirst($this->status_baru), 'class' => 'bg-gray-100 text-gray-600'],
        };
    }

    public function labelStatusSebelumnya(): string
    {
        return $this->status_sebelumnya ? ucfirst($this->status_sebelumnya) : '—';
    }
}
