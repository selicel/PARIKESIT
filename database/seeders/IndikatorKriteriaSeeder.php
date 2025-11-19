<?php

namespace Database\Seeders;

use App\Models\Indikator;
use Illuminate\Database\Seeder;

class IndikatorKriteriaSeeder extends Seeder
{

    public function run(): void
    {
        // Kriteria untuk Indikator Tingkat Kematangan Diseminasi Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Diseminasi Data')
            ->update([
                'level_1_kriteria' => 'Proses Diseminasi Data belum dilakukan oleh Walidata',
                'level_2_kriteria' => 'Proses Diseminasi Data telah dilakukan oleh Walidata sesuai standar masing-masing Produsen Data',
                'level_3_kriteria' => 'Proses Diseminasi Data telah dilakukan oleh Walidata berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Proses Diseminasi Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Proses Diseminasi Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penjaminan Transparansi Informasi Statistik
        Indikator::where('nama_indikator', 'LIKE', '%Penjaminan Transparansi%Informasi Statistik%')
            ->update([
                'level_1_kriteria' => 'Penjaminan Transparansi Informasi Statistik bagi Pengguna Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Transparansi Informasi Statistik bagi Pengguna Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Transparansi Informasi Statistik bagi Pengguna Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Transparansi Informasi Statistik bagi Pengguna Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Transparansi Informasi Statistik bagi Pengguna Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penjaminan Netralitas dan Objektivitas
        Indikator::where('nama_indikator', 'LIKE', '%Penjaminan Netralitas%Objektivitas%')
            ->update([
                'level_1_kriteria' => 'Penjaminan Netralitas dan Objektivitas terhadap Penggunaan Sumber Data dan Metodologi belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Netralitas dan Objektivitas terhadap Penggunaan Sumber Data dan Metodologi telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Netralitas dan Objektivitas terhadap Penggunaan Sumber Data dan Metodologi telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Netralitas dan Objektivitas terhadap Penggunaan Sumber Data dan Metodologi telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Netralitas dan Objektivitas terhadap Penggunaan Sumber Data dan Metodologi telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Konsistensi Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Konsistensi Statistik')
            ->update([
                'level_1_kriteria' => 'Penjaminan Konsistensi Statistik belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Konsistensi Statistik telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Konsistensi Statistik telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Konsistensi Statistik telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Konsistensi Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Pendefinisian Kebutuhan Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Pendefinisian Kebutuhan Statistik')
            ->update([
                'level_1_kriteria' => 'Pendefinisian Kebutuhan Statistik belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Pendefinisian Kebutuhan Statistik telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Pendefinisian Kebutuhan Statistik telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Pendefinisian Kebutuhan Statistik telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Pendefinisian Kebutuhan Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Desain Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Desain Statistik')
            ->update([
                'level_1_kriteria' => 'Penerapan Desain Statistik belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penerapan Desain Statistik telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penerapan Desain Statistik telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penerapan Desain Statistik telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penerapan Desain Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penyiapan Instrumen
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penyiapan Instrumen')
            ->update([
                'level_1_kriteria' => 'Penyiapan Instrumen belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penyiapan Instrumen telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penyiapan Instrumen telah dilakukan berdasarkan prosedur baku yang telah ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penyiapan Instrumen telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penyiapan Instrumen telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Proses Pengumpulan Data atau Akuisisi Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Proses Pengumpulan Data atau Akuisisi Data')
            ->update([
                'level_1_kriteria' => 'Proses Pengumpulan Data atau Akuisisi Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Proses Pengumpulan Data atau Akuisisi Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Proses Pengumpulan Data atau Akuisisi Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Proses Pengumpulan Data atau Akuisisi Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Proses Pengumpulan Data atau Akuisisi Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Pengolahan Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Pengolahan Data')
            ->update([
                'level_1_kriteria' => 'Pengolahan Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Pengolahan Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Pengolahan Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Pengolahan Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Pengolahan Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Analisis Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Analisis Data')
            ->update([
                'level_1_kriteria' => 'Proses Analisis Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Proses Analisis Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Proses Analisis Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Proses Analisis Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Proses Analisis Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penjaminan Kualitas Data
        Indikator::where('nama_indikator', 'LIKE', '%Penjaminan Kualitas Data%')
            ->update([
                'level_1_kriteria' => 'Penjaminan Kualitas Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Kualitas Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Kualitas Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Kualitas Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Kualitas Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penjaminan Konfidensialitas Data
        Indikator::where('nama_indikator', 'LIKE', '%Penjaminan Konfidensialitas%Data%')
            ->update([
                'level_1_kriteria' => 'Penjaminan Konfidensialitas Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Konfidensialitas Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Konfidensialitas Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Konfidensialitas Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Konfidensialitas Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penerapan Kompetensi SDM Bidang Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penerapan Kompetensi Sumber Daya Manusia Bidang Statistik')
            ->update([
                'level_1_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Statistik belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Statistik telah dilakukan oleh setiap Produsen Data sesuai dengan perencanaan',
                'level_3_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Statistik telah dilakukannya yaitu kompetensi di bidang proses bisinis penyelenggaraan Statistik Sektoral',
                'level_4_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Statistik telah dilakukan peningkatan, penilaian, reviu, dan evaluasi secara berkala',
                'level_5_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penerapan Kompetensi SDM Bidang Manajemen Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penerapan Kompetensi Sumber Daya Manusia Bidang Manajemen Data')
            ->update([
                'level_1_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Manajemen Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Manajemen Data telah dilakukan oleh setiap Produsen Data sesuai dengan perencanaan',
                'level_3_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Manajemen Data telah dilakukan seluruhnya yaitu kompetensi di bidang proses bisinis penyelenggaraan Statistik Sektoral',
                'level_4_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Manajemen Data telah dilakukan peningkatan, penilaian, reviu, dan evaluasi secara berkala',
                'level_5_kriteria' => 'Pemenuhan Kompetensi Sumber Daya Manusia Bidang Manajemen Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Kolaborasi Penyelenggaraan Kegiatan Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Kolaborasi Penyelenggaraan Kegiatan Statistik')
            ->update([
                'level_1_kriteria' => 'Kolaborasi antar unit kerja/perangkat daerah di Instansi Pusat/Pemerintahan Daerah dalam penyelenggaraan kegiatan statistik belum dilaksanakan',
                'level_2_kriteria' => 'Kolaborasi antar unit kerja/perangkat daerah di Instansi Pusat/Pemerintahan Daerah dalam penyelenggaraan kegiatan statistik telah dilaksanakan secara informal',
                'level_3_kriteria' => 'Kolaborasi antar unit kerja/perangkat daerah di Instansi Pusat/Pemerintahan Daerah dalam penyelenggaraan kegiatan statistik telah dilaksanakan oleh tim yang dibentuk secara formal',
                'level_4_kriteria' => 'Kolaborasi antar unit kerja/perangkat daerah di Instansi Pusat/Pemerintahan Daerah dalam penyelenggaraan kegiatan statistik telah dilakukan melalui koordinasi kepala lembaga/kepala daerah serta dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Kolaborasi antar unit kerja/perangkat daerah di Instansi Pusat/Pemerintahan Daerah dalam penyelenggaraan kegiatan statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penyelenggaraan Forum Satu Data Indonesia
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penyelenggaraan Forum Satu Data Indonesia')
            ->update([
                'level_1_kriteria' => 'Walidata/Walidata pendukung belum terlibat dalam Forum Satu Data Indonesia',
                'level_2_kriteria' => 'Walidata/Walidata pendukung telah terlibat dalam Forum Satu Data Indonesia sesuai dengan rencana aksi Forum Satu Data Indonesia',
                'level_3_kriteria' => 'Walidata/Walidata pendukung telah melaksanakan rencana aksi yang ditetapkan/disepakati dalam Forum Satu Data Indonesia',
                'level_4_kriteria' => 'Walidata/Walidata pendukung telah melaksanakan rencana aksi dan berkolaborasi dengan Walidata lain atau Pembina Data Statistik dalam Forum Satu Data Indonesia dan telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Walidata/Walidata pendukung telah menindaklanjuti hasil reviu dan evaluasi dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Kolaborasi dengan Pembina Data Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Kolaborasi dengan Pembina Data Statistik')
            ->update([
                'level_1_kriteria' => 'Kolaborasi pembangunan/pengembangan data dengan Pembina Data Statistik belum dilakukan',
                'level_2_kriteria' => 'Kolaborasi pembangunan/pengembangan data dengan Pembina Data Statistik telah dilakukan secara informal',
                'level_3_kriteria' => 'Kolaborasi pembangunan/pengembangan data dengan Pembina Data Statistik telah dilakukan secara formal',
                'level_4_kriteria' => 'Kolaborasi pembangunan/pengembangan data dengan Pembina Data Statistik telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Kolaborasi pembangunan/pengembangan data dengan Pembina Data Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Pelaksanaan Tugas sebagai Walidata
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penyelenggaraan Pelaksanaan Tugas Sebagai Walidata')
            ->update([
                'level_1_kriteria' => 'Walidata belum ditetapkan',
                'level_2_kriteria' => 'Tugas/program kerja Walidata belum dilakukan seluruhnya',
                'level_3_kriteria' => 'Tugas/program kerja Walidata telah dilakukan seluruhnya',
                'level_4_kriteria' => 'Tugas/program kerja Walidata telah dilakukan secara terpadu dengan seluruh Produsen Data yang dikordinasikan dalam Forum SDI tingkat pusat/daerah, serta telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Tugas/program kerja Walidata telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penggunaan Data Statistik Dasar untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan
        Indikator::where('nama_indikator', 'Tingkat Kematangan  Penggunaan Data Statistik  Dasar untuk Perencanaan,  Monitoring, dan Evaluasi,  dan atau Penyusunan  Kebijakan')
            ->update([
                'level_1_kriteria' => 'Penggunaan Data Statistik Dasar untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penggunaan Data Statistik Dasar untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan oleh setiap Produsen Data sesuai kepentingannya masing-masing',
                'level_3_kriteria' => 'Penggunaan Data Statistik Dasar untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan oleh Produsen Data bersama Walidata untuk kepentingan Instansi Pusat/Pemerintahan Daerah',
                'level_4_kriteria' => 'Penggunaan Data Statistik Dasar untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan oleh Instansi Pusat/Pemerintahan Daerah bersama Walidata untuk kepentingan Pusat/Pemerintahan Daerah/Nasional, telah dilakukan koordinasi/konsultasi dengan Pembina Data Statistik, serta telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penggunaan Data Statistik Dasar untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penggunaan Data Statistik Sektoral untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan
        Indikator::where('nama_indikator', 'Tingkat Kematangan  Penggunaan Data Statistik  Sektoral untuk Perencanaan,  Monitoring, dan Evaluasi,  dan atau Penyusunan  Kebijakan')
            ->update([
                'level_1_kriteria' => 'Penggunaan Data Statistik Sektoral untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penggunaan Data Statistik Sektoral untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan oleh setiap Produsen Data sesuai kepentingannya masing-masing',
                'level_3_kriteria' => 'Penggunaan Data Statistik Sektoral untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan oleh Produsen Data bersama Walidata sesuai dengan kepentingan Instansi Pusat/Pemerintahan Daerah',
                'level_4_kriteria' => 'Penggunaan Data Statistik Sektoral untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan oleh Instansi Pusat/Pemerintahan Daerah, telah dilakukan koordinasi/konsultasi/rekomendasi dari Pembina Data Statistik, serta telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penggunaan Data Statistik Sektoral untuk Perencanaan, Monitoring, dan Evaluasi, dan atau Penyusunan Kebijakan telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Sosialisasi dan Literasi Data Statistik
        Indikator::where('nama_indikator', 'LIKE', '%Sosialisasi%Literasi Data%Statistik%')
            ->update([
                'level_1_kriteria' => 'Sosialisasi Data Statistik kepada publik belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Sosialisasi Data Statistik kepada publik telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Sosialisasi Data Statistik kepada publik yang telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Sosialisasi Data Statistik kepada publik telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Sosialisasi Data Statistik kepada publik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Pelaksanaan Rekomendasi Kegiatan Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Pelaksanaan Rekomendasi Kegiatan Statistik')
            ->update([
                'level_1_kriteria' => 'Pemberitahuan rancangan kegiatan statistik ke BPS belum dilaksanakan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Pemberitahuan rancangan kegiatan statistik ke BPS telah dilaksanakan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Pemberitahuan rancangan kegiatan statistik ke BPS telah dilaksanakan berdasarkan prosedur baku yang ditetapkan, berlaku untuk seluruh Produsen Data, telah dikoordinasikan oleh walidata, serta telah ada rekomendasi dari BPS',
                'level_4_kriteria' => 'Pelaksanaan Rekomendasi Kegiatan Statistik telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Pelaksanaan Rekomendasi Kegiatan Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Perencanaan Pembangunan Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Perencanaan Pembangunan Statistik')
            ->update([
                'level_1_kriteria' => 'Perencanaan Pembangunan Statistik di Instansi Pusat/Pemerintahan Daerah belum disusun',
                'level_2_kriteria' => 'Perencanaan Pembangunan Statistik di Instansi Pusat/Pemerintahan Daerah telah disusun dan ditetapkan',
                'level_3_kriteria' => 'Perencanaan Pembangunan Statistik di Instansi Pusat/Pemerintahan Daerah telah dilaksanakan',
                'level_4_kriteria' => 'Perencanaan Pembangunan Statistik di Instansi Pusat/Pemerintahan Daerah telah dilakukan reviu serta evaluasi bersama Pembina Data Statistik',
                'level_5_kriteria' => 'Perencanaan Pembangunan Statistik di Instansi Pusat/Pemerintahan Daerah telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penyebarluasan Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penyebarluasan Data')
            ->update([
                'level_1_kriteria' => 'Penyebarluasan Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penyebarluasan Data dilakukan oleh setiap Produsen Data untuk kepentingan masing-masing',
                'level_3_kriteria' => 'Penyebarluasan Data telah dilakukan oleh Walidata untuk kepentingan Instansi Pusat/Pemerintahan Daerah',
                'level_4_kriteria' => 'Penyebarluasan Data telah dilakukan oleh Walidata melalui pujian informasi statistik, portal Satu Data Indonesia, Jaringan Informasi Geospasial Nasional (atau Sistem Big Data Permendagri) serta dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penyebarluasan Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Pemanfaatan Big Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Pemanfaatan Big Data')
            ->update([
                'level_1_kriteria' => 'Pemanfaatan Big Data dalam kegiatan Statistik belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Pemanfaatan Big Data dalam kegiatan Statistik telah dilakukan oleh setiap Produsen Data dalam bentuk uji coba dan eksperiman',
                'level_3_kriteria' => 'Pemanfaatan Big Data dalam kegiatan Statistik telah dilakukan oleh Produsen Data atau Walidata untuk menghasilkan data statistik pendukung',
                'level_4_kriteria' => 'Pemanfaatan Big Data dalam kegiatan Statistik telah dilakukan reviu dan evaluasi secara berkala bersama Pembina Data Statistik',
                'level_5_kriteria' => 'Pemanfaatan Big Data dalam kegiatan Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penerapan Standar Data Statistik (SDS)
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penerapan Standar Data Statistik (SDS)')
            ->update([
                'level_1_kriteria' => 'Penerapan Standar Data Statistik (SDS) belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penerapan Standar Data Statistik (SDS) telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penerapan Standar Data Statistik (SDS) telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penerapan Standar Data Statistik (SDS) telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penerapan Standar Data Statistik (SDS) telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penerapan Metadata Statistik
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penerapan Metadata Statistik')
            ->update([
                'level_1_kriteria' => 'Penerapan Metadata Statistik belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penerapan Metadata Statistik telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penerapan Metadata Statistik telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penerapan Metadata Statistik telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penerapan Metadata Statistik telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penerapan Interoperabilitas Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penerapan Interoperabilitas Data')
            ->update([
                'level_1_kriteria' => 'Penerapan Interoperabilitas Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penerapan Interoperabilitas Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penerapan Interoperabilitas Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penerapan Interoperabilitas Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penerapan Interoperabilitas Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penerapan Kode Referensi
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penerapan Kode Referensi')
            ->update([
                'level_1_kriteria' => 'Penerapan Kode Referensi belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penerapan Kode Referensi telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penerapan Kode Referensi telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penerapan Kode Referensi telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penerapan Kode Referensi telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Relevansi Data Terhadap Pengguna
        Indikator::where('nama_indikator', 'Tingkat Kematangan Relevansi Data Terhadap Pengguna')
            ->update([
                'level_1_kriteria' => 'Relevansi Data terhadap Pengguna belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Relevansi Data terhadap Pengguna telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Relevansi Data terhadap Pengguna telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Relevansi Data terhadap Pengguna telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Relevansi Data terhadap Pengguna telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Proses Identifikasi Kebutuhan Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Proses Identifikasi Kebutuhan Data')
            ->update([
                'level_1_kriteria' => 'Proses Identifikasi Kebutuhan Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Proses Identifikasi Kebutuhan Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Proses Identifikasi Kebutuhan Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Proses Identifikasi Kebutuhan Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Proses Identifikasi Kebutuhan Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penilaian Akurasi Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penilaian Akurasi Data')
            ->update([
                'level_1_kriteria' => 'Penilaian Akurasi Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penilaian Akurasi Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penilaian Akurasi Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penilaian Akurasi Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penilaian Akurasi Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penjaminan Aktualitas Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penjaminan Aktualitas Data')
            ->update([
                'level_1_kriteria' => 'Penjaminan Aktualitas Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Aktualitas Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Aktualitas Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Aktualitas Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Aktualitas Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Pemantauan Ketepatan Waktu Diseminasi
        Indikator::where('nama_indikator', 'Tingkat Kematangan Pemantauan Ketepatan Waktu Diseminasi')
            ->update([
                'level_1_kriteria' => 'Pemantauan ketepatan Waktu Diseminasi belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Pemantauan Ketepatan Waktu Diseminasi telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Pemantauan Ketepatan Waktu Diseminasi telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Pemantauan Ketepatan Waktu Diseminasi telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Pemantauan Ketepatan Waktu Diseminasi telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Ketersediaan Data untuk Pengguna Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Ketersediaan Data untuk Pengguna Data')
            ->update([
                'level_1_kriteria' => 'Penjaminan Ketersediaan Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Ketersediaan Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Ketersediaan Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Ketersediaan Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Ketersediaan Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Akses Media Penyebarluasan Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Akses Media Penyebarluasan Data')
            ->update([
                'level_1_kriteria' => 'Penjaminan Akses Media Penyebarluasan Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Akses Media Penyebarluasan Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Akses Media Penyebarluasan Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Akses Media Penyebarluasan Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Akses Media Penyebarluasan Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Penyediaan Format Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Penyediaan Format Data')
            ->update([
                'level_1_kriteria' => 'Penjaminan Penyediaan Format Data yang beragam belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Penyediaan Format Data yang beragam telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Penyediaan Format Data yang beragam telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Penyediaan Format Data yang beragam telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Penyediaan Format Data yang beragam telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);

        // Kriteria untuk Indikator Tingkat Kematangan Keterbandingan Data
        Indikator::where('nama_indikator', 'Tingkat Kematangan Keterbandingan Data')
            ->update([
                'level_1_kriteria' => 'Penjaminan Keterbandingan Data belum dilakukan oleh seluruh Produsen Data',
                'level_2_kriteria' => 'Penjaminan Keterbandingan Data telah dilakukan oleh setiap Produsen Data sesuai standarnya masing-masing',
                'level_3_kriteria' => 'Penjaminan Keterbandingan Data telah dilakukan berdasarkan prosedur baku yang ditetapkan dan berlaku untuk seluruh Produsen Data',
                'level_4_kriteria' => 'Penjaminan Keterbandingan Data telah dilakukan reviu dan evaluasi secara berkala',
                'level_5_kriteria' => 'Penjaminan Keterbandingan Data telah dilakukan pemutakhiran dalam rangka peningkatan kualitas'
            ]);
    }
}
