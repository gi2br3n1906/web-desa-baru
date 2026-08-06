<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Pelaksanaan Program KKN Undip 2026 di Desa Pringanom',
                'slug' => 'pelaksanaan-program-kkn-undip-2026-di-desa-pringanom',
                'category' => 'KKN',
                'excerpt' => 'Tim KKN Undip 2026 berkolaborasi bersama Pemerintah Desa dan warga untuk menguatkan literasi, kesehatan, dan pemberdayaan UMKM.',
                'content' => '<p>Desa Pringanom menyambut pelaksanaan program KKN Undip 2026. Kegiatan dilaksanakan melalui kolaborasi antara mahasiswa, Pemerintah Desa, kader kesehatan, pelaku UMKM, dan masyarakat.</p><p>Program kerja berfokus pada literasi digital, edukasi kesehatan, penguatan administrasi desa, serta pendampingan pembukuan UMKM.</p>',
                'author_name' => 'Tim KKN Undip 2026',
                'published_at' => '2026-08-01 08:00:00',
            ],
            [
                'title' => 'Karang Taruna Pringanom Gelar Kerja Bakti Lingkungan',
                'slug' => 'karang-taruna-pringanom-gelar-kerja-bakti-lingkungan',
                'category' => 'Karang Taruna',
                'excerpt' => 'Pemuda Desa Pringanom mengajak warga menjaga kebersihan lingkungan melalui kerja bakti bersama di setiap wilayah dusun.',
                'content' => '<p>Karang Taruna Desa Pringanom mengadakan kerja bakti lingkungan sebagai bagian dari gerakan gotong royong pemuda desa.</p><p>Kegiatan meliputi pembersihan saluran air, pemilahan sampah, dan penataan ruang publik. Warga dapat menyampaikan kebutuhan kegiatan lingkungan melalui pengurus Karang Taruna.</p>',
                'author_name' => 'Karang Taruna Pringanom',
                'published_at' => '2026-07-27 09:00:00',
            ],
            [
                'title' => 'Pemerintah Desa Pringanom Sampaikan Agenda Pelayanan Agustus',
                'slug' => 'pemerintah-desa-pringanom-sampaikan-agenda-pelayanan-agustus',
                'category' => 'Pemerintah Desa',
                'excerpt' => 'Informasi agenda pelayanan administrasi, musyawarah warga, dan kegiatan pembangunan Desa Pringanom pada bulan Agustus 2026.',
                'content' => '<p>Pemerintah Desa Pringanom menyampaikan agenda pelayanan dan kegiatan desa untuk bulan Agustus 2026.</p><ul><li>Pelayanan administrasi desa berlangsung pada hari dan jam kerja.</li><li>Musyawarah warga dilaksanakan sesuai undangan wilayah masing-masing.</li><li>Informasi perubahan jadwal akan diumumkan melalui kanal resmi desa.</li></ul>',
                'author_name' => 'Admin Desa',
                'published_at' => '2026-08-03 07:30:00',
            ],
            [
                'title' => 'Pendataan dan Pendampingan UMKM Desa Pringanom',
                'slug' => 'pendataan-dan-pendampingan-umkm-desa-pringanom',
                'category' => 'Pemerintah Desa',
                'excerpt' => 'Pemerintah Desa membuka ruang pendampingan bagi pelaku UMKM untuk memperbarui data usaha dan meningkatkan pencatatan keuangan.',
                'content' => '<p>Pendataan UMKM membantu Pemerintah Desa menyusun program pemberdayaan yang lebih tepat sasaran.</p><p>Pelaku usaha dapat memperbarui informasi usaha melalui layanan desa dan menggunakan template pembukuan UMKM yang tersedia di portal resmi.</p>',
                'author_name' => 'Admin Desa',
                'published_at' => '2026-07-20 10:00:00',
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(['slug' => $article['slug']], $article);
        }
    }
}