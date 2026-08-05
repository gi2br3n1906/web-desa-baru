<?php

namespace Database\Seeders;

use App\Models\VillageLegalProduct;
use Illuminate\Database\Seeder;

class LegalProductSeeder extends Seeder
{
    /**
     * Sumber metadata dan dokumen: Data Website/Produk Hukum/.
     * PDF merupakan scan sehingga nomor formal yang tidak terbaca tidak ditebak.
     */
    public function run(): void
    {
        $products = [
            [
                'judul_peraturan' => 'Perdes APBDes Tahun Anggaran 2026',
                'nomor_tahun' => 'Tahun 2026 · Nomor tercantum pada dokumen PDF',
                'kategori' => 'Peraturan Desa (Perdes)',
                'tentang' => 'Anggaran Pendapatan dan Belanja Desa (APBDes) Desa Pringanom Tahun Anggaran 2026.',
                'file_path' => 'documents/produk-hukum/perdes-apbdes-2026.pdf',
            ],
            [
                'judul_peraturan' => 'Perdes Rencana Kerja Pemerintah Desa (RKP Desa)',
                'nomor_tahun' => 'Nomor dan tahun tercantum pada dokumen PDF',
                'kategori' => 'Peraturan Desa (Perdes)',
                'tentang' => 'Rencana Kerja Pemerintah Desa (RKP Desa) Pringanom.',
                'file_path' => 'documents/produk-hukum/perdes-rkpdesa.pdf',
            ],
        ];

        foreach ($products as $product) {
            VillageLegalProduct::updateOrCreate(
                ['judul_peraturan' => $product['judul_peraturan']],
                $product,
            );
        }
    }
}