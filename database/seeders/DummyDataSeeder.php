<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Artikel;
use App\Models\Earthquake;
use App\Models\Publication;
use App\Models\InformasiPublik;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('artikels')->truncate();
        DB::table('earthquakes')->truncate();
        DB::table('publications')->truncate();
        DB::table('informasi_publik')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Artikel::create([
            'title' => 'Peningkatan Mitigasi Bencana di Wilayah Papua',
            'description' => 'Kantor Geofisika memperluas sistem pemantauan dan sosialisasi mitigasi bencana untuk masyarakat lokal.',
            'photo' => 'artikels/mitigasi-papua.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-10'),
        ]);

        Artikel::create([
            'title' => 'Sosialisasi Gempa Bumi dan Evakuasi',
            'description' => 'Pelatihan dan simulasi evakuasi dilaksanakan untuk meningkatkan kesiapsiagaan warga dan petugas.',
            'photo' => 'artikels/simulasi-evakuasi.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-15'),
        ]);

        Artikel::create([
            'title' => 'Pemeliharaan Alat Seismograf Baru',
            'description' => 'Tim teknis melakukan inspeksi dan kalibrasi untuk memastikan data gempa bumi tercatat akurat.',
            'photo' => 'artikels/seismograf-baru.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-18'),
        ]);

        Artikel::create([
            'title' => 'Laporan Kegiatan Triwulan I 2026',
            'description' => 'Ringkasan kegiatan monitoring dan publikasi hasil geofisika selama tiga bulan terakhir.',
            'photo' => 'artikels/laporan-triwulan.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-22'),
        ]);

        Artikel::create([
            'title' => 'Pelayanan Informasi Publik Lebih Cepat',
            'description' => 'Layanan informasi geofisika ditingkatkan dengan portal dan kanal resmi untuk masyarakat umum.',
            'photo' => 'artikels/pelayanan-publik.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-24'),
        ]);

        Earthquake::create([
            'magnitude' => 4.7,
            'depth_km' => 18,
            'latitude' => -2.12345,
            'longitude' => 140.98765,
            'location_description' => '130 km barat daya Kabupaten A',
            'felt_intensity' => 'Dirasakan ringan di beberapa kecamatan pesisir.',
            'potensi' => 'Potensi tsunami kecil, belum ada rekomendasi evakuasi.',
            'occurred_at' => Carbon::parse('2026-03-20 08:14:00'),
            'shakemap_image' => 'shakemaps/2026-03-20-0814.png',
        ]);

        Earthquake::create([
            'magnitude' => 5.2,
            'depth_km' => 22,
            'latitude' => -3.45678,
            'longitude' => 136.54321,
            'location_description' => '90 km tenggara Kota B',
            'felt_intensity' => 'Getaran sedang dirasakan di pusat kota.',
            'potensi' => 'Potensi kerusakan ringan di bangunan tua.',
            'occurred_at' => Carbon::parse('2026-03-21 13:30:00'),
            'shakemap_image' => 'shakemaps/2026-03-21-1330.png',
        ]);

        Earthquake::create([
            'magnitude' => 3.9,
            'depth_km' => 12,
            'latitude' => -1.98765,
            'longitude' => 139.65432,
            'location_description' => '55 km barat laut Pelabuhan C',
            'felt_intensity' => 'Dirasakan lemah, sebagian besar tidak kuat terasa.',
            'potensi' => 'Potensi dampak minimal.',
            'occurred_at' => Carbon::parse('2026-03-22 02:45:00'),
            'shakemap_image' => null,
        ]);

        Earthquake::create([
            'magnitude' => 5.8,
            'depth_km' => 30,
            'latitude' => -2.78901,
            'longitude' => 141.23456,
            'location_description' => '140 km selatan Kota D',
            'felt_intensity' => 'Dirasakan kuat, beberapa bangunan bergetar.',
            'potensi' => 'Potensi kerusakan ringan hingga sedang.',
            'occurred_at' => Carbon::parse('2026-03-23 11:05:00'),
            'shakemap_image' => 'shakemaps/2026-03-23-1105.png',
        ]);

        Earthquake::create([
            'magnitude' => 4.3,
            'depth_km' => 8,
            'latitude' => -2.34567,
            'longitude' => 138.87654,
            'location_description' => '25 km utara Kabupaten E',
            'felt_intensity' => 'Dirasakan ringan di zona pesisir.',
            'potensi' => 'Potensi dampak tidak signifikan.',
            'occurred_at' => Carbon::parse('2026-03-24 18:55:00'),
            'shakemap_image' => null,
        ]);

        Publication::create([
            'type' => 'buletin',
            'title' => 'Buletin Geofisika Maret 2026',
            'description' => 'Laporan bulanan berisi rangkuman kejadian geofisika dan analisis cuaca.',
            'thumbnail' => 'publications/buletin-maret-2026.jpg',
            'file_path' => 'publications/buletin-maret-2026.pdf',
            'external_url' => null,
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-05'),
        ]);

        Publication::create([
            'type' => 'berita',
            'title' => 'Peringatan Dini Prakiraan Cuaca Ekstrem',
            'description' => 'Instansi mengeluarkan peringatan dini untuk potensi hujan lebat dan angin kencang.',
            'thumbnail' => 'publications/cuaca-ekstrem.jpg',
            'file_path' => null,
            'external_url' => 'https://example.com/prakiraan-cuaca',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-12'),
        ]);

        Publication::create([
            'type' => 'buletin',
            'title' => 'Buletin Gempa Triwulan I 2026',
            'description' => 'Dokumen resmi berisi data gempa dan rekomendasi mitigasi triwulan pertama.',
            'thumbnail' => 'publications/buletin-gempa-q1-2026.jpg',
            'file_path' => 'publications/buletin-gempa-q1-2026.pdf',
            'external_url' => null,
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-18'),
        ]);

        Publication::create([
            'type' => 'berita',
            'title' => 'Rilis Data Kilat Petir Wilayah Timur',
            'description' => 'Data kilat petir terbaru ditayangkan untuk membantu perencanaan keselamatan.',
            'thumbnail' => 'publications/data-petir.jpg',
            'file_path' => null,
            'external_url' => 'https://example.com/data-petir',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-20'),
        ]);

        Publication::create([
            'type' => 'berita',
            'title' => 'Update Infrastruktur Balai Geofisika',
            'description' => 'Pembaruan fasilitas dan peningkatan jaringan data untuk mendukung layanan publik.',
            'thumbnail' => 'publications/infrastruktur-balai.jpg',
            'file_path' => null,
            'external_url' => 'https://example.com/update-infrastruktur',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-22'),
        ]);

        InformasiPublik::create([
            'type' => 'berita',
            'title' => 'Pelayanan Publik Dibuka Sabtu Ini',
            'description' => 'Layanan informasi geofisika akan tersedia pada hari Sabtu untuk memudahkan masyarakat.',
            'photo' => 'informasi_publik/pelayanan-sabtu.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-08'),
        ]);

        InformasiPublik::create([
            'type' => 'pengumuman',
            'title' => 'Workshop Keselamatan Bencana',
            'description' => 'Workshop akan digelar untuk meningkatkan pemahaman kesiapsiagaan gempa bagi masyarakat.',
            'photo' => 'informasi_publik/workshop-bencana.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-13'),
        ]);

        InformasiPublik::create([
            'type' => 'berita',
            'title' => 'Aplikasi Informasi Geofisika Resmi',
            'description' => 'Aplikasi baru dirilis untuk mempermudah akses informasi gempa, cuaca, dan peringatan dini.',
            'photo' => 'informasi_publik/aplikasi-resmi.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-17'),
        ]);

        InformasiPublik::create([
            'type' => 'pengumuman',
            'title' => 'Penutupan Sementara Layanan Offline',
            'description' => 'Layanan offline ditutup sementara karena pembaruan sistem. Layanan online tetap aktif.',
            'photo' => 'informasi_publik/penutupan-layanan.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-19'),
        ]);

        InformasiPublik::create([
            'type' => 'berita',
            'title' => 'Data Publik Direvisi',
            'description' => 'Data publik diperbarui dengan informasi terbaru dari hasil pemantauan lapangan.',
            'photo' => 'informasi_publik/data-direvisi.jpg',
            'is_active' => true,
            'published_at' => Carbon::parse('2026-03-23'),
        ]);
    }
}
