<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class KecamatanKelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Bukit Raya' => ['Air Dingin', 'Simpang Tiga', 'Tangkerang Labuai', 'Tangkerang Selatan', 'Tangkerang Utara'],
            'Lima Puluh' => ['Pesisir', 'Sekip', 'Tanjung Rhu', 'Rintis'],
            'Marpoyan Damai' => ['Maharatu', 'Perhentian Marpoyan', 'Sidomulyo Timur', 'Wonorejo', 'Tangkerang Barat', 'Tangkerang Tengah'],
            'Payung Sekaki' => ['Air Hitam', 'Labuh Baru Barat', 'Labuh Baru Timur', 'Tampan', 'Bandar Raya', 'Tirta Siak'],
            'Pekanbaru Kota' => ['Sukaramai', 'Sumahilang', 'Kota Tinggi', 'Kota Baru', 'Tanah Datar', 'Simpang Empat'],
            'Sail' => ['Cinta Raja', 'Sukamaju', 'Sukamulya'],
            'Senapelan' => ['Sago', 'Kampung Dalam', 'Kampung Bandar', 'Kampung Baru', 'Padang Terubuk', 'Padang Bulan'],
            'Sukajadi' => ['Sukajadi', 'Harjosari', 'Kedung Sari', 'Kampung Melayu', 'Jadirejo', 'Pulau Karam', 'Kampung Tengah'],
            'Tenayan Raya' => ['Rejosari', 'Bambu Kuning', 'Bencah Lesung', 'Tangkerang Timur', 'Industri Tenayan', 'Melebung', 'Sialang Sakti', 'Tuah Negeri'],
            'Binawidya' => ['Binawidya', 'Delima', 'Simpang Baru', 'Tobek Godang', 'Sungai Sibam'],
            'Kulim' => ['Kulim', 'Mentangor', 'Sialangrampai', 'Pebatuan', 'Pematangkapau'],
            'Rumbai Barat' => ['Agrowisata', 'Maharani', 'Muara Fajar Barat', 'Muara Fajar Timur', 'Rantau Panjang', 'Rumbai Bukit'],
            'Rumbai' => ['Sri Meranti', 'Umban Sari', 'Palas', 'Lembah Damai', 'Limbungan Baru', 'Meranti Pandak'],
            'Rumbai Timur' => ['Tebing Tinggi Okura', 'Sungai Ukai', 'Sungai Ambang', 'Lembah Sari', 'Limbungan'],
            'Tuahmadani' => ['Sidomulyo Barat', 'Sialang Munggu', 'Tuah Karya', 'Tuahmadani', 'Air Putih'],
        ];

        foreach ($data as $kecamatanName => $kelurahans) {
            $kecamatan = Kecamatan::create(['name' => $kecamatanName]);
            foreach ($kelurahans as $kelurahanName) {
                Kelurahan::create([
                    'kecamatan_id' => $kecamatan->id,
                    'name' => $kelurahanName,
                ]);
            }
        }
    }
}