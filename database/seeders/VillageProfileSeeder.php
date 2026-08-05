<?php

namespace Database\Seeders;

use App\Models\VillagePotential;
use App\Models\VillageProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class VillageProfileSeeder extends Seeder
{
    /**
     * Sumber: Data Website/PROFIL DESA PRINGANOM_Habib.pdf.
     * Koreksi masa jabatan 2019-2027 mengikuti data terverifikasi pengguna.
     */
    public function run(): void
    {
        $structurePath = 'seeded/struktur-organisasi-pringanom.svg';
        Storage::disk('public')->put($structurePath, $this->structureSvg());

        VillageProfile::updateOrCreate(
            ['id' => 1],
            [
                'visi' => <<<'HTML'
<p><strong>Arah pelayanan berdasarkan Profil Desa Pringanom</strong></p>
<p>Pemerintah Desa Pringanom berkomitmen mewujudkan tata kelola pemerintahan desa yang baik untuk meningkatkan kesejahteraan seluruh masyarakat Desa Pringanom.</p>
<p><em>Dokumen sumber belum mencantumkan rumusan visi formal; teks ini menyajikan komitmen pelayanan yang tercantum dalam dokumen profil resmi.</em></p>
HTML,
                'misi' => <<<'HTML'
<ol>
    <li>Memberikan pelayanan publik yang cepat, mudah, transparan, dan akuntabel.</li>
    <li>Mengedepankan profesionalisme, integritas, dan partisipasi masyarakat.</li>
    <li>Mengembangkan potensi pertanian, peternakan, UMKM, dan sumber daya manusia.</li>
    <li>Memperkuat gotong royong serta kelembagaan desa dalam pembangunan berkelanjutan.</li>
</ol>
HTML,
                'struktur_organisasi_path' => $structurePath,
                'kontak_desa' => [
                    'Alamat' => 'Desa Pringanom, Kecamatan Masaran, Kabupaten Sragen, Jawa Tengah',
                    'Koordinat' => 'Bujur 110.92565; lintang 7.451762 (sesuai dokumen sumber)',
                    'Jarak ke Kecamatan' => '4 km',
                    'Jarak ke Kabupaten' => '17 km',
                ],
            ],
        );

        $potentials = [
            [
                'title_id' => 'Profil Wilayah dan Demografi',
                'title_jp' => '村の概要と人口',
                'content_id' => <<<'HTML'
<p>Desa Pringanom berada di Kecamatan Masaran, Kabupaten Sragen, Provinsi Jawa Tengah. Wilayahnya berupa dataran rendah pada ketinggian sekitar <strong>95 mdpl</strong> dengan luas <strong>342,54 hektare</strong>, terdiri dari <strong>32 RT</strong> dan <strong>3 wilayah dusun</strong>.</p>
<ul>
    <li>Jumlah penduduk: <strong>4.778 jiwa</strong></li>
    <li>Laki-laki: <strong>2.385 jiwa</strong></li>
    <li>Perempuan: <strong>2.393 jiwa</strong></li>
    <li>Kepala Keluarga: <strong>1.535 KK</strong></li>
</ul>
<p>Batas wilayah: Desa Bentak di utara, Desa Jati di selatan, Desa Pilang di timur, dan Desa Krikilan di barat.</p>
HTML,
                'content_jp' => <<<'HTML'
<p>プリンガノム村は、中部ジャワ州スラゲン県マサラン郡にあります。標高約<strong>95メートル</strong>の低地で、面積は<strong>342.54ヘクタール</strong>、<strong>32のRT</strong>と<strong>3つの行政地区</strong>から構成されています。</p>
<ul><li>人口：<strong>4,778人</strong></li><li>男性：<strong>2,385人</strong></li><li>女性：<strong>2,393人</strong></li><li>世帯数：<strong>1,535世帯</strong></li></ul>
HTML,
            ],
            [
                'title_id' => 'Mata Pencaharian Penduduk',
                'title_jp' => '住民の職業構成',
                'content_id' => <<<'HTML'
<p>Sektor pertanian menjadi salah satu penopang utama ekonomi desa. Data mata pencaharian penduduk:</p>
<ul>
    <li>Pekerja lain: 1.230</li><li>Petani: 670</li><li>Buruh tani: 372</li><li>PNS: 65</li>
    <li>Tukang bangunan: 25</li><li>Tukang jahit: 15</li><li>Pengrajin industri rumah tangga: 12</li>
    <li>Pedagang keliling: 11</li><li>Tukang kayu: 10</li><li>TNI/Polri: 7</li><li>Tukang servis: 6</li>
    <li>Bidan: 4</li><li>Tukang cukur: 4</li><li>Tukang pijet: 3</li>
</ul>
HTML,
                'content_jp' => <<<'HTML'
<p>農業は村の主要な経済基盤の一つです。職業別人数は、その他の仕事1,230人、農家670人、農業労働者372人、公務員65人、建設職人25人、縫製職人15人、家内工業職人12人、行商人11人、木工職人10人、軍・警察7人、修理工6人、助産師4人、理容師4人、マッサージ師3人です。</p>
HTML,
            ],
            [
                'title_id' => 'Pemerintahan dan Kelembagaan Desa',
                'title_jp' => '村行政と地域組織',
                'content_id' => <<<'HTML'
<p><strong>Kepala Desa:</strong> Sugiyoto, S.H. (masa jabatan 2019–2027).</p>
<ul>
    <li>Sekretaris Desa: Agus Purwanto</li><li>Kaur Tata Usaha dan Umum: Tri Wiyanto</li>
    <li>Kaur Keuangan: Sardi</li><li>Kaur Perencanaan: Khosim Nur Huda</li>
    <li>Kasi Pemerintahan: Wahyu Tri Wulandari</li><li>Kasi Kesejahteraan: Suprapti</li>
    <li>Kasi Pelayanan: Sunarwan</li><li>Kadus I: Sunardi</li><li>Kadus II: Sukidi</li><li>Kadus III: Sugiyo</li>
</ul>
<p>Lembaga desa meliputi BPD, PKK, Karang Taruna, BUMDes, RT/RW, Posyandu, kelompok tani, dan lembaga kemasyarakatan lainnya.</p>
HTML,
                'content_jp' => <<<'HTML'
<p><strong>村長：</strong>Sugiyoto, S.H.（任期2019～2027年）。村行政は、村書記、総務・財務・計画担当、行政・福祉・住民サービス担当、および3地区の責任者によって支えられています。地域組織にはBPD、PKK、青年団、BUMDes、RT/RW、Posyandu、農民グループなどがあります。</p>
HTML,
            ],
            [
                'title_id' => 'Potensi Pertanian, UMKM, dan Sumber Daya Manusia',
                'title_jp' => '農業・零細中小企業・人材の可能性',
                'content_id' => <<<'HTML'
<p>Potensi utama Desa Pringanom meliputi komoditas padi, pengembangan pertanian berkelanjutan, produk olahan hasil pertanian, usaha mikro dan usaha rumahan, serta partisipasi masyarakat dalam pembangunan sosial dan kemasyarakatan.</p>
<p>Lingkungan yang masih asri dan budaya gotong royong menjadi modal sosial untuk pembangunan desa yang berkelanjutan.</p>
HTML,
                'content_jp' => <<<'HTML'
<p>プリンガノム村の主な可能性は、米作、持続可能な農業、農産加工品、零細企業・家内事業、そして社会・地域開発への住民参加です。自然環境と相互扶助の文化は、持続可能な村づくりの重要な社会資本です。</p>
HTML,
            ],
        ];

        foreach ($potentials as $potential) {
            VillagePotential::updateOrCreate(
                ['title_id' => $potential['title_id']],
                $potential + ['image_path' => null],
            );
        }
    }

    private function structureSvg(): string
    {
        return <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" width="1400" height="980" viewBox="0 0 1400 980">
  <rect width="1400" height="980" fill="#f8fafc"/>
  <style>.title{font:700 34px Arial;fill:#172554}.role{font:700 18px Arial;fill:#1e3a8a}.name{font:600 20px Arial;fill:#0f172a}.box{fill:#fff;stroke:#1e3a8a;stroke-width:2;rx:14}.line{stroke:#94a3b8;stroke-width:3}</style>
  <text x="700" y="52" text-anchor="middle" class="title">Struktur Pemerintah Desa Pringanom</text>
  <line x1="700" y1="145" x2="700" y2="185" class="line"/>
  <rect x="500" y="75" width="400" height="70" class="box"/><text x="700" y="104" text-anchor="middle" class="role">Kepala Desa (2019–2027)</text><text x="700" y="132" text-anchor="middle" class="name">Sugiyoto, S.H.</text>
  <rect x="500" y="185" width="400" height="70" class="box"/><text x="700" y="214" text-anchor="middle" class="role">Sekretaris Desa</text><text x="700" y="242" text-anchor="middle" class="name">Agus Purwanto</text>
  <line x1="700" y1="255" x2="700" y2="295" class="line"/><line x1="190" y1="295" x2="1210" y2="295" class="line"/>
  <g><line x1="190" y1="295" x2="190" y2="325" class="line"/><rect x="50" y="325" width="280" height="82" class="box"/><text x="190" y="355" text-anchor="middle" class="role">Kaur TU &amp; Umum</text><text x="190" y="385" text-anchor="middle" class="name">Tri Wiyanto</text></g>
  <g><line x1="530" y1="295" x2="530" y2="325" class="line"/><rect x="390" y="325" width="280" height="82" class="box"/><text x="530" y="355" text-anchor="middle" class="role">Kaur Keuangan</text><text x="530" y="385" text-anchor="middle" class="name">Sardi</text></g>
  <g><line x1="870" y1="295" x2="870" y2="325" class="line"/><rect x="730" y="325" width="280" height="82" class="box"/><text x="870" y="355" text-anchor="middle" class="role">Kaur Perencanaan</text><text x="870" y="385" text-anchor="middle" class="name">Khosim Nur Huda</text></g>
  <g><line x1="1210" y1="295" x2="1210" y2="325" class="line"/><rect x="1070" y="325" width="280" height="82" class="box"/><text x="1210" y="355" text-anchor="middle" class="role">Kasi Pemerintahan</text><text x="1210" y="385" text-anchor="middle" class="name">Wahyu Tri Wulandari</text></g>
  <rect x="220" y="470" width="280" height="82" class="box"/><text x="360" y="500" text-anchor="middle" class="role">Kasi Kesejahteraan</text><text x="360" y="530" text-anchor="middle" class="name">Suprapti</text>
  <rect x="560" y="470" width="280" height="82" class="box"/><text x="700" y="500" text-anchor="middle" class="role">Kasi Pelayanan</text><text x="700" y="530" text-anchor="middle" class="name">Sunarwan</text>
  <rect x="900" y="470" width="280" height="82" class="box"/><text x="1040" y="500" text-anchor="middle" class="role">BPD (Mitra Pemerintah Desa)</text><text x="1040" y="530" text-anchor="middle" class="name">Badan Permusyawaratan Desa</text>
  <line x1="700" y1="552" x2="700" y2="625" class="line"/><line x1="250" y1="625" x2="1150" y2="625" class="line"/>
  <g><line x1="250" y1="625" x2="250" y2="655" class="line"/><rect x="100" y="655" width="300" height="82" class="box"/><text x="250" y="685" text-anchor="middle" class="role">Kepala Dusun I</text><text x="250" y="715" text-anchor="middle" class="name">Sunardi</text></g>
  <g><line x1="700" y1="625" x2="700" y2="655" class="line"/><rect x="550" y="655" width="300" height="82" class="box"/><text x="700" y="685" text-anchor="middle" class="role">Kepala Dusun II</text><text x="700" y="715" text-anchor="middle" class="name">Sukidi</text></g>
  <g><line x1="1150" y1="625" x2="1150" y2="655" class="line"/><rect x="1000" y="655" width="300" height="82" class="box"/><text x="1150" y="685" text-anchor="middle" class="role">Kepala Dusun III</text><text x="1150" y="715" text-anchor="middle" class="name">Sugiyo</text></g>
  <rect x="100" y="810" width="1200" height="105" class="box"/><text x="700" y="848" text-anchor="middle" class="role">Lembaga Kemasyarakatan Desa</text><text x="700" y="883" text-anchor="middle" class="name">BPD · PKK · Karang Taruna · BUMDes · RT/RW · Posyandu · Kelompok Tani</text>
</svg>
SVG;
    }
}