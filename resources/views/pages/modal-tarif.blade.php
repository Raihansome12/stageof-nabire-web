<div id="tarifModal" class="fixed inset-0 z-[60] hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6 opacity-0 transition-all duration-300">
    
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden transform scale-95 transition-all duration-300" id="tarifModalContent">
        
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 bg-white z-10">
            <div>
                <h3 class="font-bold text-[#003366] text-xl">Tarif Layanan MKG Lainnya</h3>
                <p class="text-xs text-gray-500 mt-1">Berdasarkan Peraturan Pemerintah (PP) No 47 Tahun 2018</p>
            </div>
            <button type="button" onclick="closeTarifModal()" class="p-2 rounded-full text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-1 w-full bg-slate-50 overflow-y-auto p-6 space-y-8">

            {{-- A. INFORMASI KHUSUS MKG --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#f0f4f8] px-4 py-3 border-b border-gray-200">
                    <h4 class="font-semibold text-[#003366]">A. Informasi Khusus Meteorologi, Klimatologi, dan Geofisika</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full table-fixed text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 w-1/2 py-3 border-b">Jenis Layanan / Data</th>
                                <th class="px-4 py-3 border-b text-center w-40">Satuan</th>
                                <th class="px-4 py-3 border-b text-center w-36">Tarif (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Informasi Cuaca</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Cuaca untuk Penerbangan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per route / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">4% biaya navigasi</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Cuaca untuk Pelayaran</td>
                                <td class="px-4 py-3 text-center text-gray-500">per route / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp250.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Cuaca untuk Pelabuhan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp225.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Cuaca untuk Pengeboran Lepas Pantai</td>
                                <td class="px-4 py-3 text-center text-gray-500">per dok / lok / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp330.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Informasi Iklim untuk Agro Industri</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Analisis dan Prakiraan Hujan Bulanan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp65.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Prakiraan Musim Kemarau</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp230.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Prakiraan Musim Hujan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp230.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Kesesuaian Agroklimat</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp470.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Normal Temperatur Periode 1981–2010</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Windrose Wilayah Indonesia Periode 1981–2010</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Curah Hujan di Indonesia Rata-rata Periode 1981–2010</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Informasi Kualitas Udara Rata-rata Mingguan untuk Industri</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Particulate Matter (PM10)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per stasiun / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp70.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Particulate Matter (PM2.5)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per stasiun / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp70.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Sulfur Dioksida (SO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per stasiun / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp60.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Nitrogen Oksida (NOx)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per stasiun / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp60.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Ozon (O₃)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per stasiun / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp60.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Karbon Monoksida (CO)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per stasiun / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp60.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Karbon Dioksida (CO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp80.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Methan (CH₄)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp80.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Peta Kegempaan untuk Perencanaan Konstruksi</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Peta Kegempaan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per provinsi / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp250.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Peta Percepatan Tanah</td>
                                <td class="px-4 py-3 text-center text-gray-500">per provinsi / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp250.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Keperluan Klaim Asuransi</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Meteorologi</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp175.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Geofisika</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp185.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- B. INFORMASI KHUSUS SESUAI PERMINTAAN --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#f0f4f8] px-4 py-3 border-b border-gray-200">
                    <h4 class="font-semibold text-[#003366]">B. Informasi Khusus MKG Sesuai Permintaan</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 w-1/2 border-b">Jenis Layanan / Data</th>
                                <th class="px-4 py-3 border-b text-center w-40">Satuan</th>
                                <th class="px-4 py-3 border-b text-center w-36">Tarif (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Informasi Meteorologi</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Cuaca Khusus untuk Kegiatan Olah Raga</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp100.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Cuaca Khusus Kegiatan Komersial Outdoor/Indoor</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp100.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Radar Cuaca (per 10 menit)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per data / lokasi</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">70.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Informasi Klimatologi</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Peta Spasial Informasi Maritim</td>
                                <td class="px-4 py-3 text-center text-gray-500">per peta / bulan</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp300.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Informasi Tabular dan Grafik Maritim</td>
                                <td class="px-4 py-3 text-center text-gray-500">per tabel / bulan</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp350.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Potensi Rawan Banjir</td>
                                <td class="px-4 py-3 text-center text-gray-500">per atlas</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp350.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Informasi Perubahan Iklim dan Kualitas Udara</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Publikasi Informasi Perubahan Iklim dan Kualitas Udara</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp100.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Kerentanan Perubahan Iklim</td>
                                <td class="px-4 py-3 text-center text-gray-500">per atlas</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp450.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Potensi Energi Matahari di Indonesia</td>
                                <td class="px-4 py-3 text-center text-gray-500">per atlas</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp300.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Atlas Potensi Energi Angin di Indonesia</td>
                                <td class="px-4 py-3 text-center text-gray-500">per atlas</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp300.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Pengambilan Sampel Kualitas Udara</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Sulfur Dioksida (SO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp30.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Nitrogen Dioksida (NO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp30.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Karbon Dioksida (CO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp40.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Ozon (O₃)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp30.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Suspended Particulate Matter (SPM)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp60.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Debu Particulate Matter (PM10)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp60.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Debu Particulate Matter (PM2.5)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp90.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Kimia Air Hujan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp230.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Methan (CH₄)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp40.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Pengujian Sampel Kualitas Udara</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Sulfur Dioksida (SO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp20.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Nitrogen Dioksida (NO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp20.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Karbon Dioksida (CO₂)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp30.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Ozon (O₃)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp20.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Suspended Particulate Matter (SPM)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp50.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Debu Particulate Matter (PM10)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp50.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Debu Particulate Matter (PM2.5)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp70.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Kimia Air Hujan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp240.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Methan (CH₄)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per sampel</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp30.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Informasi Geofisika</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Buku dan Peta Variasi Magnet Bumi (Epoch)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp300.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Peta Tingkat Kerawanan Petir</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp200.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Waktu Terbit dan Terbenam Matahari atau Bulan</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp50.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Buku Almanak BMKG</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Buku Peta Ketinggian Hilal</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku / thn</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Titik Dasar Gaya Berat (Gravitasi)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per titik</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Kejadian Petir</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp75.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- C. JASA KONSULTASI --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#f0f4f8] px-4 py-3 border-b border-gray-200">
                    <h4 class="font-semibold text-[#003366]">C. Jasa Konsultasi MKG</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 w-1/2 border-b">Jenis Layanan / Data</th>
                                <th class="px-4 py-3 border-b text-center w-40">Satuan</th>
                                <th class="px-4 py-3 border-b text-center w-36">Tarif (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700">Informasi Meteorologi Khusus (Proyek / Survei / Penelitian Komersial)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp3.750.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700">Analisis Iklim (Klimatologi)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp9.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700">Informasi Pendahuluan Geofisika (Proyek / Survei / Penelitian Komersial)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per lokasi</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp12.300.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- D. JASA KALIBRASI --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#f0f4f8] px-4 py-3 border-b border-gray-200">
                    <h4 class="font-semibold text-[#003366]">D. Jasa Kalibrasi Alat MKG</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 w-1/2 border-b">Jenis Alat</th>
                                <th class="px-4 py-3 border-b text-center w-40">Satuan</th>
                                <th class="px-4 py-3 border-b text-center w-36">Tarif (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Peralatan Sederhana Mekanik (Konvensional)</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Barometer Aneroid / Air Raksa / Barograph</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp400.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Thermometer (Bola Basah/Kering/Maks/Min/Tanah/Apung/Rumput)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp285.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Thermohygrograph (2 sensor) / Thermohygrometer (2 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp735.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Portable Weather Station / PWS (5 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp2.570.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Hygrometer (Kelembaban Udara)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp450.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Camble Stokes / Actinograph</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp205.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Panci Penguapan / Still Well</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Alat Penguapan Lengkap</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp2.020.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Cup Counter Anemometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Psycrometer Assman (2 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp570.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Penakar Hujan Obs</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp210.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Penakar Hujan Hellman</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp265.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Penakar Hujan Tipping Bucket</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp270.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Theodolite</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp200.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Pyranometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp400.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Peralatan Sederhana Elektronik (Otomatis)</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Anemometer (2 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.235.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Digital Hand Anemometer (1 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Digital Hand Anemometer (2 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.235.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Digital Barometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp400.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Peralatan Teknologi Canggih (Modern)</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">AWS 5 sensor</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp2.240.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">AWS 6 sensor</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp2.640.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">AWS 7 sensor</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp3.040.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">AWS 11 sensor</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp4.775.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Marine AWS / MAWS (9 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp3.475.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">AWOS (9 sensor)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp4.790.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">AAWS 11 sensor</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp4.360.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">AAWS 32 sensor</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp6.660.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Sensor Runway Visual Range (RVR)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp800.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Ceillometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp950.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Alat Geofisika</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Portable Analog / Short Period Seismograph (SPS-1 / SPS-3)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Portable Digital / Broadband Seismograph / Accelerograph (3 Komponen)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.750.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Gravimeter</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp4.450.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Terrameter SAS 1000</td>
                                <td class="px-4 py-3 text-center text-gray-500">per unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp280.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- E. JASA PENGGUNAAN ALAT --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#f0f4f8] px-4 py-3 border-b border-gray-200">
                    <h4 class="font-semibold text-[#003366]">E. Jasa Penggunaan Alat MKG</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 w-1/2 border-b">Jenis Alat</th>
                                <th class="px-4 py-3 border-b text-center w-40">Satuan</th>
                                <th class="px-4 py-3 border-b text-center w-36">Tarif (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Peralatan Sederhana Mekanik</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Barometer Aneroid / Air Raksa</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp60.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Barograph / Camble Stokes</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp70.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Thermometer Tanah / Thermohygrograph / Actinograph</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp55.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Psycrometer Assman</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp45.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Cup Counter Anemometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp35.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Portable Weather Station (PWS)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Peralatan Sederhana Elektronik (Otomatis)</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Anemometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp190.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Digital Hand Anemometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp90.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Digital Barometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp160.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Teropong Rukhyat (Low Grade)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp230.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Peralatan Teknologi Canggih (Modern)</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">PAWS / PMAWS</td>
                                <td class="px-4 py-3 text-center text-gray-500">per minggu</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp700.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Thermal Imager</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp150.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">System Grounding Tester</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp200.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Proton Magnetometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp400.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Portable Digital Short Period Seismograph</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp640.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Portable Digital Broadband Seismograph</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp970.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Portable Digital Broadband Accelerograph</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp735.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Mikrotremor Array</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp4.000.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Mikrotremor Civil Engineering</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp680.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">MASW (Multichannel Analysis of Surface Wave)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.750.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Gravimeter</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp600.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">GPS Geodesi</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp270.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Deklinasi dan Inklinasi Magnetometer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp400.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Magnetotellurik 5 CH</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp4.000.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Teropong Rukhyat (High Grade)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per hari / unit</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp400.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Computing Server of Climate Change</td>
                                <td class="px-4 py-3 text-center text-gray-500">per core / bulan</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp300.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- F. STMKG & DIKLAT --}}
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#f0f4f8] px-4 py-3 border-b border-gray-200">
                    <h4 class="font-semibold text-[#003366]">F. STMKG, Diklat & Penggunaan Gedung</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-600 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 w-1/2 border-b">Jenis Layanan</th>
                                <th class="px-4 py-3 border-b text-center w-40">Satuan</th>
                                <th class="px-4 py-3 border-b text-center w-36">Tarif (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Sekolah Tinggi MKG (STMKG)</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Uang Pendaftaran & Seleksi Masuk STMKG</td>
                                <td class="px-4 py-3 text-center text-gray-500">per orang</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp75.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">SPP Tetap STMKG dari Instansi Lain</td>
                                <td class="px-4 py-3 text-center text-gray-500">per orang / smt</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp4.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Pendidikan dan Pelatihan</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Diklat Teknis / Fungsional / Sertifikasi MKG Non-Pegawai BMKG (10 hari, min. 30 orang)</td>
                                <td class="px-4 py-3 text-center text-gray-500">per orang</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp5.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Modul Diklat Bidang MKG</td>
                                <td class="px-4 py-3 text-center text-gray-500">per buku</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp100.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-500 italic text-xs" colspan="3">Penggunaan Gedung (Diklat / Workshop / Seminar)</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Ruang Aula / Ruang Sinema</td>
                                <td class="px-4 py-3 text-center text-gray-500">per 8 jam</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp1.500.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Tambahan Ruang Aula / Sinema</td>
                                <td class="px-4 py-3 text-center text-gray-500">per jam</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp200.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Ruang Kelas / Ruang Komputer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per 8 jam / ruang</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp400.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Tambahan Ruang Kelas / Komputer</td>
                                <td class="px-4 py-3 text-center text-gray-500">per jam / ruang</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp50.000</td>
                            </tr>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-gray-700 pl-6">Kamar Asrama</td>
                                <td class="px-4 py-3 text-center text-gray-500">per kamar / hari</td>
                                <td class="px-4 py-3 text-right font-medium text-gray-800">Rp225.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>